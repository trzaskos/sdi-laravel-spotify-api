<?php

namespace App\DataTransferObjects;

use App\Enums\MusicSource;

class ArtistDTO
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly int|null $popularity,
        public readonly array $genres,
        public readonly string|null $image,
        public readonly MusicSource $source,
    ) {}

    public static function fromSpotify(array $data): self
    {
        return new self(
            id: $data['id'],
            name: $data['name'],
            popularity: $data['popularity'] ?? null,
            genres: $data['genres'] ?? [],
            image: $data['images'][0]['url'] ?? null,
            source: MusicSource::SPOTIFY,
        );
    }

    public static function fromYouTube(array $data): self
    {
        return new self(
            id: $data['id'],
            name: $data['name'],
            popularity: $data['popularity'] ?? null,
            genres: $data['genres'] ?? [],
            image: $data['imageUrl'] ?? null,
            source: MusicSource::YOUTUBE,
        );
    }
}
