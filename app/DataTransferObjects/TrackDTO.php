<?php

namespace App\DataTransferObjects;

use App\Enums\MusicSource;

class TrackDTO
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly MusicSource $source,
        public readonly string $albumName,
        public readonly array $artists,
        public readonly int $durationMs,
        public readonly ?string $previewUrl,
        public readonly ?string $image
    ) {}

    public static function fromSpotify(array $data): self
    {
        return new self(
            id: $data['id'],
            name: $data['name'],
            source: MusicSource::SPOTIFY,
            albumName: $data['album']['name'] ?? '',
            artists: array_map(fn($artist) => $artist['name'], $data['artists'] ?? []),
            durationMs: $data['duration_ms'] ?? 0,
            previewUrl: $data['preview_url'] ?? null,
            image: $data['album']['images'][0]['url'] ?? null
        );
    }

    public static function fromYouTube(array $data): self
    {
        return new self(
            id: $data['id'],
            name: $data['name'],
            source: MusicSource::YOUTUBE,
            albumName: $data['albumName'],
            artists: $data['artists'],
            durationMs: $data['durationMs'],
            previewUrl: $data['previewUrl'] ?? null,
            image: $data['image'] ?? null
        );
    }
}
