<?php

namespace App\DataTransferObjects;

use App\Enums\MusicSource;

class PlaylistDTO
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string|null $description,
        public readonly string|null $image,
        public readonly array $tracks,
        public readonly MusicSource $source,
    ) {}

    public static function fromSpotify(array $data): self
    {
        return new self(
            id: $data['id'],
            name: $data['name'],
            description: $data['description'] ?? null,
            image: $data['image'] ?? null,
            tracks: $data['tracks']['items'] ?? [],
            source: MusicSource::SPOTIFY,
        );
    }
}
