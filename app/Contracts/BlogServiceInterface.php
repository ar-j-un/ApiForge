<?php

namespace App\Contracts;

use App\DataTransferObjects\Blog;
use Illuminate\Pagination\LengthAwarePaginator;

interface BlogServiceInterface
{
    public function paginateForUser(int $userId, int $perPage = 15): LengthAwarePaginator|array;

    public function find(string $id): Blog|array|null;

    public function create(array $data, int $userId): Blog|array;

    public function update(string $id, array $data): Blog|array;

    public function delete(string $id): bool|array;

    public function search(string $query, int $userId): LengthAwarePaginator|array;

    public function countByUser(int $userId): int|array;

    public function foreignBlogs(int $userId, int $perPage = 15, string $homeCountry = 'India'): LengthAwarePaginator|array;

    public function foreignCountryCounts(string $homeCountry = 'India'): array;
}
