<?php

namespace App\DataTransferObjects;

class AlbumDTO
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $source,
        public readonly ?string $releaseDate,
        public readonly array $artists,
        public readonly ?string $image
    ) {}

    public static function fromArray(array $data, string $source): self
    {
        return new self(
            id: $data['id'],
            name: $data['name'],
            source: $source,
            releaseDate: $data['release_date'] ?? null,
            artists: array_map(fn($artist) => $artist['name'], $data['artists'] ?? []),
            image: $data['images'][0]['url'] ?? null
        );
    }
}
