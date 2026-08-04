<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Blog extends Model
{
    use Searchable;

    protected $fillable = ['title', 'slug', 'excerpt', 'content', 'author_name', 'is_published', 'published_at'];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    #[Override]
    public function toSearchableArray(): array
    {
        return [
            'title' => $this->title,
            'excerpt' => $this->excerpt,
            'content' => strip_tags($this->content),
            'author_name' => $this->author_name,
            'is_published' => $this->is_published,
        ];
    }

    #[Override]
    public function searchableAs(): string
    {
        return 'blogs_index';
    }

    #[Override]
    public function shouldBeSearchable(): bool
    {
        return $this->is_published;
    }
}
