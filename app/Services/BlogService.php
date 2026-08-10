<?php

namespace App\Services;

use App\Contracts\BlogServiceInterface;
use App\DataTransferObjects\Blog;
use Elasticsearch\Common\Exceptions\Missing404Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;
use MailerLite\LaravelElasticsearch\Manager as ElasticsearchManager;

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

    #[\Override]
    public function paginateForUser(int $userId, int $perPage = 3): LengthAwarePaginator
    {
        $page = (int) request('page', 1);

        $response = $this->elasticsearch->search([
            'index' => self::INDEX,
            'body' => [
                'query' => ['term' => ['user_id' => $userId]],
                'sort' => [['created_at' => 'desc']],
                'from' => ($page - 1) * $perPage,
                'size' => $perPage,
            ],
        ]);

        return $this->toPaginator($response, $perPage, $page);
    }

    #[\Override]
    public function find(string $id): ?Blog
    {
        try {
            $response = $this->elasticsearch->get([
                'index' => self::INDEX,
                'id' => $id,
            ]);
        } catch (Missing404Exception) {
            return null;
        }

        return Blog::fromDocument($response['_id'], $response['_source']);
    }

    #[\Override]
    public function create(array $data, int $userId): Blog
    {
        $id = (string) Str::uuid();

        $document = [
            'title' => $data['title'],
            'slug' => Str::slug($data['title']),
            'excerpt' => $data['excerpt'] ?? null,
            'content' => $data['content'],
            'author_name' => $data['author_name'],
            'user_id' => $userId,
            'is_published' => $data['is_published'] ?? false,
            'created_at' => now()->toIso8601String(),
            'updated_at' => now()->toIso8601String(),
        ];

        $this->elasticsearch->index([
            'index' => self::INDEX,
            'id' => $id,
            'body' => $document,
        ]);

        $this->refreshIndex();

        return Blog::fromDocument($id, $document);
    }

    #[\Override]
    public function update(string $id, array $data): Blog
    {
        if (isset($data['title'])) {
            $data['slug'] = Str::slug($data['title']);
        }
        $data['is_published'] = (bool) ($data['is_published'] ?? false);
        $data['updated_at'] = now()->toIso8601String();

        $this->elasticsearch->update([
            'index' => self::INDEX,
            'id' => $id,
            'body' => ['doc' => $data],
        ]);

        $this->refreshIndex();

        return $this->find($id);
    }

    #[\Override]
    public function delete(string $id): bool
    {
        $this->elasticsearch->delete([
            'index' => self::INDEX,
            'id' => $id,
        ]);

        $this->refreshIndex();

        return true;
    }

    #[\Override]
    public function search(string $query, int $userId): LengthAwarePaginator
    {
        $perPage = 15;
        $page = (int) request('page', 1);

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

        return $this->toPaginator($response, $perPage, $page);
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
}
