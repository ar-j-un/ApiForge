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
}