<?php

namespace App\Services;

use App\Models\Blog;
use App\Contracts\BlogServiceInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class BlogService implements BlogServiceInterface
{
    #[Override]
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return Blog::latest()->paginate($perPage);
    }

    #[Override]
    public function create(array $data): Blog
    {
        $data['slug'] = Str::slug($data['title']);
        return Blog::create($data);
    }

    #[Override]
    public function update(Blog $blog, array $data): Blog
    {
        $data['slug'] = Str::slug($data['title']);
        $blog->update($data);
        return $blog;
    }

    #[Override]
    public function delete(Blog $blog): bool
    {
        return $blog->delete();
    }

    #[Override]
    public function search(string $query): LengthAwarePaginator
    {
        return Blog::search($query)->paginate(15);
    }
}