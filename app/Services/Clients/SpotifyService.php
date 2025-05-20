<?php

namespace App\Services\Clients;

use App\DataTransferObjects\ArtistDTO;
use App\DataTransferObjects\PlaylistDTO;
use App\DataTransferObjects\AlbumDTO;
use App\DataTransferObjects\TrackDTO;
use App\Enums\MusicSource;
use App\Enums\SpotifyEndpoints;
use App\Services\Contracts\MusicServiceInterface;
use App\Services\Shared\BaseMusicServiceWithToken;

class SpotifyService extends BaseMusicServiceWithToken implements MusicServiceInterface
{
    public function __construct()
    {
        parent::__construct(MusicSource::SPOTIFY);
    }

    public function searchArtist(string $query): array
    {
        $data = $this->get(SpotifyEndpoints::SEARCH->value, [
            'q' => $query,
            'type' => 'artist',
            'limit' => 10,
        ]);

        return collect($data['artists']['items'])
            ->map(fn($item) => ArtistDTO::fromSpotify($item))
            ->all();
    }

    public function getPlaylist(string $playlistId): PlaylistDTO
    {
        $data = $this->get(SpotifyEndpoints::GET_PLAYLIST->withId($playlistId));

        return PlaylistDTO::fromSpotify($data);
    }

    public function searchTrack(string $query): array
    {
        $data = $this->get(SpotifyEndpoints::SEARCH->value, [
            'q' => $query,
            'type' => 'track',
            'limit' => 10,
        ]);

        return collect($data['tracks']['items'])
            ->map(fn($item) => TrackDTO::fromArray($item, $this->source->value))
            ->all();
    }

    public function getTrack(string $trackId): TrackDTO
    {
        $data = $this->get(SpotifyEndpoints::GET_TRACK->withId($trackId));

        return TrackDTO::fromArray($data, $this->source->value);
    }

    public function getAlbumsByArtist(string $artistId): array
    {
        $data = $this->get(SpotifyEndpoints::GET_ALBUMS_BY_ARTIST->withId($artistId), [
            'limit' => 10,
        ]);

        return collect($data['items'])
            ->map(fn($item) => AlbumDTO::fromArray($item, $this->source->value))
            ->all();
    }

    public function getTopTracksByArtist(string $artistId): array
    {
        $data = $this->get(SpotifyEndpoints::GET_TOP_TRACKS_BY_ARTIST->withId($artistId), [
            'market' => 'US',
        ]);

        return collect($data['tracks'])
            ->map(fn($item) => TrackDTO::fromArray($item, $this->source->value))
            ->all();
    }
}
