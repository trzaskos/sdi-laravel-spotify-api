<?php

namespace App\Services\Resolvers;

use App\Enums\MusicSource;
use App\Services\Clients\SpotifyService;
use App\Services\Clients\YouTubeService;
use App\Services\Contracts\MusicServiceInterface;
use InvalidArgumentException;

class MusicServiceResolver
{
    public function resolve(MusicSource $source): MusicServiceInterface
    {
        return match ($source) {
            MusicSource::SPOTIFY => app(SpotifyService::class),
            MusicSource::YOUTUBE => app(YouTubeService::class),
            default => throw new InvalidArgumentException("Unsupported music source: $source"),
        };
    }
}
