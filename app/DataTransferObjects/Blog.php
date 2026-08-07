<?php
namespace App\DataTransferObjects;

final class Blog
{
    public function __construct(
        public readonly string $id,
        public readonly string $title,
        public readonly ?string $slug,
        public readonly ?string $excerpt,
        public readonly string $content,
        public readonly string $authorName,
        public readonly int $userId,
        public readonly bool $isPublished,
        public readonly ?string $createdAt = null,
    ) {}

    public static function fromDocument(string $id, array $source): self
    {
        return new self(
            id: $id,
            title: $source['title'],
            slug: $source['slug'] ?? null,
            excerpt: $source['excerpt'] ?? null,
            content: $source['content'],
            authorName: $source['author_name'],
            userId: (int) $source['user_id'],
            isPublished: (bool) ($source['is_published'] ?? false),
            createdAt: $source['created_at'] ?? null,
        );
    }
}