<?php

namespace App\DataTransferObjects;

class TrackDTO
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $source,
        public readonly string $albumName,
        public readonly array $artists,
        public readonly int $durationMs,
        public readonly ?string $previewUrl,
        public readonly ?string $image
    ) {}

    public static function fromArray(array $data, string $source): self
    {
        return new self(
            id: $data['id'],
            name: $data['name'],
            source: $source,
            albumName: $data['album']['name'] ?? '',
            artists: array_map(fn($artist) => $artist['name'], $data['artists'] ?? []),
            durationMs: $data['duration_ms'] ?? 0,
            previewUrl: $data['preview_url'] ?? null,
            image: $data['album']['images'][0]['url'] ?? null
        );
    }
}
