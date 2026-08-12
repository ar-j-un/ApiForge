<?php

namespace App\Contracts;

use App\DataTransferObjects\Blog;
use Illuminate\Pagination\LengthAwarePaginator;

interface BlogServiceInterface
{
    public function paginateForUser(int $userId, int $perPage = 15): LengthAwarePaginator;

    public function find(string $id): ?Blog;

    public function create(array $data, int $userId): Blog;

    public function update(string $id, array $data): Blog;

    public function delete(string $id): bool;

    public function search(string $query, int $userId): LengthAwarePaginator;

    public function countByUser(int $userId): int;

    public function foreignBlogs(string $homeCountry = 'India'): array;

    public function foreignCountryCounts(string $homeCountry = 'India'): array;
}
