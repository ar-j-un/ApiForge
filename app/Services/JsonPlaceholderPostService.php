<?php

namespace App\Services;

use App\Contracts\PostApiServiceInterface;
use Illuminate\Support\Facades\Http;

class JsonPlaceholderPostService implements PostApiServiceInterface
{
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('services.jsonplaceholder.base_url');
    }

    public function all(): array
    {
        return Http::get("{$this->baseUrl}/posts")->throw()->json();
    }

    public function find(int $id): array
    {
        return Http::get("{$this->baseUrl}/posts/{$id}")->throw()->json();
    }

    public function create(array $data): array
    {
        return Http::post("{$this->baseUrl}/posts", $data)->throw()->json();
    }

    public function update(int $id, array $data): array
    {
        return Http::patch("{$this->baseUrl}/posts/{$id}", $data)->throw()->json();
    }

    public function delete(int $id): bool
    {
        return Http::delete("{$this->baseUrl}/posts/{$id}")->throw()->successful();
    }

    public function findByUser(int $userId): array
    {
        return Http::get("{$this->baseUrl}/posts", [
            'userId' => $userId,
        ])->throw()->json();
    }
}