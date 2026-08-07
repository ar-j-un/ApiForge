<?php
namespace App\Services;

use App\Contracts\BlogServiceInterface;
use App\DataTransferObjects\Blog;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

final class BlogService implements BlogServiceInterface
{
    private const INDEX = 'blogs_index';

    private function baseUrl(): string
    {
        return rtrim(config('scout.elasticsearch.hosts')[0] ?? 'http://localhost:9200', '/');
    }

    private function refreshIndex(): void
    {
        Http::withBody('', 'application/json')
        ->post("{$this->baseUrl()}/".self::INDEX."/_refresh")
        ->throw();
    }

    #[\Override]
    public function paginateForUser(int $userId, int $perPage = 3): LengthAwarePaginator
    {
        $page = (int) request('page', 1);

        $response = Http::post("{$this->baseUrl()}/".self::INDEX."/_search", [
            'query' => ['term' => ['user_id' => $userId]],
            'sort' => [['created_at' => 'desc']],
            'from' => ($page - 1) * $perPage,
            'size' => $perPage,
        ])->throw()->json();

        return $this->toPaginator($response, $perPage, $page);
    }

    #[\Override]
    public function find(string $id): ?Blog
    {
        $response = Http::get("{$this->baseUrl()}/".self::INDEX."/_doc/{$id}");

        if ($response->status() === 404) {
            return null;
        }

        $response->throw();
        $data = $response->json();

        return Blog::fromDocument($data['_id'], $data['_source']);
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

        Http::put("{$this->baseUrl()}/".self::INDEX."/_doc/{$id}", $document)
            ->throw();

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

        Http::post("{$this->baseUrl()}/".self::INDEX."/_update/{$id}", [
            'doc' => $data,
        ])->throw();

        $this->refreshIndex();

        return $this->find($id);
    }

    #[\Override]
    public function delete(string $id): bool
    {
        Http::delete("{$this->baseUrl()}/".self::INDEX."/_doc/{$id}")->throw();
        $this->refreshIndex();
        return true;
    }

    #[\Override]
    public function search(string $query, int $userId): LengthAwarePaginator
    {
        $perPage = 15;
        $page = (int) request('page', 1);

        $response = Http::post("{$this->baseUrl()}/".self::INDEX."/_search", [
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
        ])->throw()->json();

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