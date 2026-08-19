<?php

namespace App\DataTransferObjects;

use Illuminate\Support\Carbon;

final class Blog
{
    public function __construct(
        public readonly string $id,
        public readonly string $title,
        public readonly ?string $slug,
        public readonly ?string $excerpt,
        public readonly string $content,
        public readonly string $authorName,
        public readonly string $country,
        public readonly int $userId,
        public readonly bool $isPublished,
        public readonly ?string $createdAt = null,
    ) {}

    public static function fromDocument(string $id, array $source): self
    {
        $createdAt = $source['created_at'] ?? null;

        return new self(
            id: $id,
            title: $source['title'],
            slug: $source['slug'] ?? null,
            excerpt: $source['excerpt'] ?? null,
            content: $source['content'],
            authorName: $source['author_name'],
            country: $source['country'],
            userId: (int) $source['user_id'],
            isPublished: (bool) ($source['is_published'] ?? false),
            createdAt: $createdAt !== null ? Carbon::parse($createdAt)->diffForHumans() : 'Unknown',
        );
    }
}
