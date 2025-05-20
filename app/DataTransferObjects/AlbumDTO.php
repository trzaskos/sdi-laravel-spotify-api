<?php

namespace App\DataTransferObjects;

use App\Enums\MusicSource;

class AlbumDTO
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly MusicSource $source,
        public readonly ?string $releaseDate,
        public readonly array $artists,
        public readonly ?string $image
    ) {}

    public static function fromSpotify(array $data): self
    {
        return new self(
            id: $data['id'],
            name: $data['name'],
            source: MusicSource::SPOTIFY,
            releaseDate: $data['release_date'] ?? null,
            artists: array_map(fn($artist) => $artist['name'], $data['artists'] ?? []),
            image: $data['images'][0]['url'] ?? null
        );
    }

    public static function fromYouTube(array $data): self
    {
        return new self(
            id: $data['id'],
            name: $data['name'],
            source: MusicSource::YOUTUBE,
            releaseDate: $data['release_date'] ?? null,
            artists: $data['artists'] ?? [],
            image: $data['image'] ?? null
        );
    }
}
