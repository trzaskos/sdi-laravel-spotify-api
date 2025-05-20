<?php

namespace App\Services\Contracts;

use App\DataTransferObjects\PlaylistDTO;

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
     * @return PlaylistDTO
     */
    public function getPlaylist(string $playlistId): PlaylistDTO;
}
