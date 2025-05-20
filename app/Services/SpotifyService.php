<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class SpotifyService implements MusicServiceInterface
{
    protected string $token;

    public function __construct()
    {
        $this->token = $this->getAccessToken();
    }

    protected function getAccessToken(): string
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

    public function searchArtist(string $query): array
    {
        $response = Http::withToken($this->token)
            ->get(config('services.spotify.api_url') . '/search', [
                'q' => $query,
                'type' => 'artist',
                'limit' => 10,
            ]);

        if (!$response->successful()) {
            throw new RuntimeException('Error fetching artist from Spotify.');
        }

        return $response->json('artists.items');
    }

    public function getPlaylist(string $playlistId): array
    {
        $response = Http::withToken($this->token)
            ->get(config('services.spotify.api_url') . "/playlists/{$playlistId}");

        if (!$response->successful()) {
            throw new RuntimeException('Error fetching playlist from Spotify.');
        }

        return $response->json();
    }
}
