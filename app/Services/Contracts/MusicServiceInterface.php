<?php

namespace App\Services\Contracts;

use App\DataTransferObjects\PlaylistDTO;
use App\DataTransferObjects\TrackDTO;

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
    /**
     * Search tracks by name.
     *
     * @param string $query
     * @return array
     */
    public function searchTrack(string $query): array;

    /**
     * Get a track by ID.
     *
     * @param string $trackId
     * @return TrackDTO
     */
    public function getTrack(string $trackId): TrackDTO;

    /**
     * Get albums by artist ID.
     *
     * @param string $artistId
     * @return array
     */
    public function getAlbumsByArtist(string $artistId): array;

    /**
     * Get top tracks by artist ID.
     *
     * @param string $artistId
     * @return array
     */
    public function getTopTracksByArtist(string $artistId): array;
}
