<?php

namespace App\Enums;

enum SpotifyEndpoints: string
{
    case SEARCH = 'search';
    case PLAYLIST = 'playlist';

    public function withId(string $id): string
    {
        return match ($this) {
            self::PLAYLIST => "{$this->value}/{$id}",
            default => $this->value,
        };
    }
}
