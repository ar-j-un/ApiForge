<?php

namespace App\Contracts;

use App\Models\Blog;
use Illuminate\Pagination\LengthAwarePaginator;

interface BlogServiceInterface
{
    public function paginate(int $perPage = 15): LengthAwarePaginator;
    public function create(array $data): Blog;
    public function update(Blog $blog, array $data): Blog;
    public function delete(Blog $blog): bool;
    public function search(string $query): LengthAwarePaginator;
}