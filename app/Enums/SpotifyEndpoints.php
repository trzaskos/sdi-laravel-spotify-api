<?php

namespace App\Enums;

enum SpotifyEndpoints: string
{
    case SEARCH = 'search';
    case GET_PLAYLIST = 'playlists';
    case GET_TRACK = 'tracks';
    case GET_ALBUMS_BY_ARTIST = 'artists/%s/albums';
    case GET_TOP_TRACKS_BY_ARTIST = 'artists/%s/top-tracks';

    public function withId(string $id): string
    {
        return match ($this) {
            self::GET_PLAYLIST,
            self::GET_TRACK => "{$this->value}/{$id}",

            self::GET_ALBUMS_BY_ARTIST,
            self::GET_TOP_TRACKS_BY_ARTIST => sprintf($this->value, $id),

            default => $this->value,
        };
    }
}
