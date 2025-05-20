<?php

namespace App\Services;

use App\Enums\MusicSource;
use InvalidArgumentException;

class MusicServiceResolver
{
    public function resolve(MusicSource $source): MusicServiceInterface
    {
        return match ($source) {
            MusicSource::SPOTIFY => app(SpotifyService::class),
            //  MusicSource::DEEZER => app(DeezerService::class),
            //  MusicSource::YOUTUBE => app(YouTubeService::class),
            default => throw new InvalidArgumentException("Unsupported music source: $source"),
        };
    }
}
