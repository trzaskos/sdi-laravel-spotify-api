<?php

namespace App\Services\Clients;

use App\DataTransferObjects\ArtistDTO;
use App\DataTransferObjects\PlaylistDTO;
use App\Enums\SpotifyEndpoints;
use App\Services\Contracts\MusicServiceInterface;
use App\Services\Shared\AbstractMusicHttpService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class SpotifyService extends AbstractMusicHttpService implements MusicServiceInterface
{
    protected function token(): string
    {
        return Cache::remember('spotify_token', now()->addMinutes(50), function () {
            $response = Http::asForm()->post(config('services.spotify.token_url'), [
                'grant_type' => 'client_credentials',
                'client_id' => config('services.spotify.client_id'),
                'client_secret' => config('services.spotify.client_secret'),
            ]);

            if (!$response->successful()) {
                throw new RuntimeException('Failed to authenticate with Spotify API.');
            }

            return $response->json('access_token');
        });
    }

    protected function buildUrl(string $endpoint): string
    {
        return rtrim(config('services.spotify.api_url'), '/') . '/' . ltrim($endpoint, '/');
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
