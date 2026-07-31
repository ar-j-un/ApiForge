<?php

namespace App\Contracts;

interface PostApiServiceInterface
{
    public function all(): array;

    public function find(int $id): array;

    public function create(array $data): array;

    public function findByUser(int $userId): array;
}