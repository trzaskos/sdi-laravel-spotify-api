<?php

namespace App\Services\Clients;

use App\DataTransferObjects\ArtistDTO;
use App\DataTransferObjects\PlaylistDTO;
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
        $data = $this->get(SpotifyEndpoints::PLAYLIST->withId($playlistId));

        return PlaylistDTO::fromSpotify($data);
    }
}
