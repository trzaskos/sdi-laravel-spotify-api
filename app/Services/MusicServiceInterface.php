<?php

namespace App\Services;

interface MusicServiceInterface
{
    /**
     * Search artists by name.
     *
     * @param string $query
     * @return array
     */
    public function searchArtist(string $query): array;

    /**
     * Get a public playlist by ID.
     *
     * @param string $playlistId
     * @return array
     */
    public function getPlaylist(string $playlistId): array;
}
