<?php

namespace App\Services;

use App\Contracts\BlogServiceInterface;
use App\DataTransferObjects\Blog;
use Elasticsearch\Common\Exceptions\Missing404Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use MailerLite\LaravelElasticsearch\Manager as ElasticsearchManager;
use Throwable;

final class BlogService implements BlogServiceInterface
{
    private const INDEX = 'blogs_index';

    public function __construct(
        private readonly ElasticsearchManager $elasticsearch,
    ) {}

    private function refreshIndex(): void
    {
        $this->elasticsearch->indices()->refresh(['index' => self::INDEX]);
    }

    private function success(mixed $data): array
    {
        return [
            'success' => true,
            'data' => $data,
            'message' => null,
            'detail' => null,
        ];
    }

    private function failure(string $message, Throwable $err): array
    {
        return [
            'success' => false,
            'data' => null,
            'message' => $message,
            'detail' => $err->getMessage(),
        ];
    }

    #[\Override]
    public function paginateForUser(int $userId, int $perPage = 3): array
    {
        $page = $this->resolvePage();

        try {
            $response = $this->elasticsearch->search([
                'index' => self::INDEX,
                'body' => [
                    'query' => ['term' => ['user_id' => $userId]],
                    'sort' => [['created_at' => 'desc']],
                    'from' => ($page - 1) * $perPage,
                    'size' => $perPage,
                ],
            ]);

            return $this->success($this->toPaginator($response, $perPage, $page));
        } catch (Throwable $err) {
            Log::error('Failed to paginate blogs from Elasticsearch', [
                'user_id' => $userId,
                'page' => $page,
                'exception' => $err->getMessage(),
            ]);

            return $this->failure("We couldn't load your blogs right now. Please try again shortly.", $err);
        }
    }

    #[\Override]
    public function find(string $id): array
    {
        try {
            $response = $this->elasticsearch->get([
                'index' => self::INDEX,
                'id' => $id,
            ]);
        } catch (Missing404Exception) {
            return $this->success(null);
        } catch (Throwable $err) {
            Log::error('Failed to fetch blog from Elasticsearch', [
                'id' => $id,
                'exception' => $err->getMessage(),
            ]);

            return $this->failure("We couldn't load this blog right now. Please try again shortly.", $err);
        }

        return $this->success(Blog::fromDocument($response['_id'], $response['_source']));
    }

    #[\Override]
    public function create(array $data, int $userId): array
    {
        $id = (string) Str::uuid();

        $document = [
            'title' => $data['title'],
            'slug' => Str::slug($data['title']),
            'excerpt' => $data['excerpt'] ?? null,
            'content' => $data['content'],
            'author_name' => $data['author_name'],
            'country' => $data['country'],
            'user_id' => $userId,
            'is_published' => (bool) ($data['is_published'] ?? false),
            'created_at' => now()->toIso8601String(),
            'updated_at' => now()->toIso8601String(),
        ];

        try {
            $this->elasticsearch->index([
                'index' => self::INDEX,
                'id' => $id,
                'body' => $document,
            ]);
            $this->refreshIndex();

            return $this->success(Blog::fromDocument($id, $document));
        } catch (Throwable $err) {
            Log::error('Failed to create blog in Elasticsearch', [
                'id' => $id,
                'user_id' => $userId,
                'exception' => $err->getMessage(),
            ]);

            return $this->failure("We couldn't save your blog. Please try again.", $err);
        }
    }

    #[\Override]
    public function update(string $id, array $data): array
    {
        if (isset($data['title'])) {
            $data['slug'] = Str::slug($data['title']);
        }
        $data['is_published'] = (bool) ($data['is_published'] ?? false);
        $data['updated_at'] = now()->toIso8601String();

        try {
            $this->elasticsearch->update([
                'index' => self::INDEX,
                'id' => $id,
                'body' => ['doc' => $data],
            ]);
            $this->refreshIndex();

            return $this->success(true);
        } catch (Throwable $err) {
            Log::error('Failed to update blog in Elasticsearch', [
                'id' => $id,
                'exception' => $err->getMessage(),
            ]);

            return $this->failure("We couldn't update your blog. Please try again.", $err);
        }
    }

    #[\Override]
    public function delete(string $id): array
    {
        try {
            $this->elasticsearch->delete([
                'index' => self::INDEX,
                'id' => $id,
            ]);
            $this->refreshIndex();

            return $this->success(true);
        } catch (Throwable $err) {
            Log::error('Failed to delete blog from Elasticsearch', [
                'id' => $id,
                'exception' => $err->getMessage(),
            ]);

            return $this->failure("We couldn't delete your blog. Please try again.", $err);
        }
    }

    #[\Override]
    public function search(string $query, int $userId): array
    {
        $perPage = 15;
        $page = $this->resolvePage();

        try {
            $response = $this->elasticsearch->search([
                'index' => self::INDEX,
                'body' => [
                    'query' => [
                        'bool' => [
                            'must' => [
                                ['multi_match' => ['query' => $query, 'fields' => ['title', 'content', 'excerpt']]],
                            ],
                            'filter' => [
                                ['term' => ['user_id' => $userId]],
                            ],
                        ],
                    ],
                    'from' => ($page - 1) * $perPage,
                    'size' => $perPage,
                ],
            ]);

            return $this->success($this->toPaginator($response, $perPage, $page));
        } catch (Throwable $err) {
            Log::error('Failed to search blogs in Elasticsearch', [
                'query' => $query,
                'user_id' => $userId,
                'page' => $page,
                'exception' => $err->getMessage(),
            ]);

            return $this->failure('Search is temporarily unavailable. Please try again shortly.', $err);
        }
    }

    private function toPaginator(array $response, int $perPage, int $page): LengthAwarePaginator
    {
        $items = array_map(
            fn ($hit) => Blog::fromDocument($hit['_id'], $hit['_source']),
            $response['hits']['hits']
        );

        return new LengthAwarePaginator(
            items: $items,
            total: $response['hits']['total']['value'],
            perPage: $perPage,
            currentPage: $page,
            options: ['path' => request()->url(), 'query' => request()->query()],
        );
    }

    private function resolvePage(): int
    {
        $raw = request('page', 1);

        if (! is_numeric($raw) || (int) $raw != $raw) {
            return 1;
        }

        $page = (int) $raw;

        return $page < 1 ? 1 : $page;
    }

    #[\Override]
    public function countByUser(int $userId): array
    {
        try {
            $response = $this->elasticsearch->count([
                'index' => self::INDEX,
                'body' => [
                    'query' => [
                        'bool' => [
                            'filter' => [
                                ['term' => ['user_id' => $userId]],
                            ],
                        ],
                    ],
                ],
            ]);

            return $this->success($response['count'] ?? 0);
        } catch (Throwable $err) {
            Log::error('Failed to count blogs from Elasticsearch', [
                'user_id' => $userId,
                'exception' => $err->getMessage(),
            ]);

            return $this->failure("We couldn't load your blog count right now.", $err);
        }
    }

    #[\Override]
    public function foreignCountryCounts(string $homeCountry = 'India'): array
    {
        try {
            $response = $this->elasticsearch->search([
                'index' => self::INDEX,
                'body' => [
                    'size' => 0,
                    'query' => [
                        'bool' => [
                            'must_not' => [
                                ['term' => ['country' => $homeCountry]],
                            ],
                        ],
                    ],
                    'aggs' => [
                        'by_country' => [
                            'terms' => ['field' => 'country'],
                        ],
                    ],
                ],
            ]);

            return $this->success($response['aggregations']['by_country']['buckets'] ?? []);
        } catch (Throwable $err) {
            Log::error('Failed to fetch foreign country counts from Elasticsearch', [
                'home_country' => $homeCountry,
                'exception' => $err->getMessage(),
            ]);

            return $this->failure("We couldn't load country stats right now.", $err);
        }
    }

    #[\Override]
    public function foreignBlogs(int $userId, int $perPage = 3, string $homeCountry = 'India'): array
    {
        $page = $this->resolvePage();

        try {
            $response = $this->elasticsearch->search([
                'index' => self::INDEX,
                'body' => [
                    'query' => [
                        'bool' => [
                            'filter' => [
                                ['match_all' => new \stdClass],
                                ['term' => ['user_id' => $userId]],
                            ],
                            'must_not' => [
                                ['term' => ['country' => $homeCountry]],
                            ],
                            'should' => [
                                ['term' => ['country' => 'United States']],
                                ['term' => ['country' => 'United Kingdom']],
                            ],
                        ],
                    ],
                    'from' => ($page - 1) * $perPage,
                    'size' => $perPage,
                ],
            ]);

            return $this->success($this->toPaginator($response, $perPage, $page));
        } catch (Throwable $err) {
            Log::error('Failed to fetch foreign blogs from Elasticsearch', [
                'user_id' => $userId,
                'page' => $page,
                'home_country' => $homeCountry,
                'exception' => $err->getMessage(),
            ]);

            return $this->failure("We couldn't load foreign blogs right now.", $err);
        }
    }
}
