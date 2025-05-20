<?php

namespace Tests\Unit;

use App\DataTransferObjects\ArtistDTO;
use App\DataTransferObjects\PlaylistDTO;
use App\Services\Clients\SpotifyService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class SpotifyServiceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Http::fake([
            config('services.spotify.token_url') => Http::response([
                'access_token' => 'fake-token',
            ], 200),

            config('services.spotify.api_url') . '/search*' => Http::response([
                'artists' => [
                    'items' => [
                        [
                            'id' => '123',
                            'name' => 'Test Artist',
                            'popularity' => 90,
                            'genres' => ['rock'],
                            'images' => [['url' => 'http://image.url']],
                        ],
                    ],
                ],
            ], 200),

            config('services.spotify.api_url') . '/playlist/*' => Http::response([
                'id' => 'abc123',
                'name' => 'My Playlist',
                'description' => 'Great songs',
                'images' => [['url' => 'http://playlist.cover']],
                'tracks' => ['items' => []],
            ], 200),
        ]);

        Cache::forget('spotify_token');
    }

    public function test_search_artist_returns_array_of_artist_dtos(): void
    {
        $service = new SpotifyService();
        $result = $service->searchArtist('test');

        $this->assertIsArray($result);
        $this->assertInstanceOf(ArtistDTO::class, $result[0]);
        $this->assertEquals('Test Artist', $result[0]->name);
    }

    public function test_get_playlist_returns_playlist_dto(): void
    {
        Cache::put('spotify_token', 'fake-token');

        $service = new SpotifyService();

        $result = $service->getPlaylist('abc123');

        $this->assertInstanceOf(PlaylistDTO::class, $result);
        $this->assertEquals('abc123', $result->id);
        $this->assertEquals('My Playlist', $result->name);
    }
}
