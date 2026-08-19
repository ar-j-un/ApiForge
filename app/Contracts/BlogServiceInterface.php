<?php

namespace App\Contracts;

interface BlogServiceInterface
{
    public function paginateForUser(int $userId, int $perPage = 15): array;

    public function find(string $id): array;

    public function create(array $data, int $userId): array;

    public function update(string $id, array $data): array;

    public function delete(string $id): array;

    public function search(string $query, int $userId): array;

    public function countByUser(int $userId): array;

    public function foreignBlogs(int $userId, int $perPage = 15, string $homeCountry = 'India'): array;

    public function foreignCountryCounts(string $homeCountry = 'India'): array;
}
