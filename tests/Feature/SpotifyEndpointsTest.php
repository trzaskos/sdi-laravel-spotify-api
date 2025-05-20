<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class SpotifyEndpointsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Authenticate fake user
        Sanctum::actingAs(User::factory()->create());

        Http::fake([
            config('services.spotify.token_url') => Http::response([
                'access_token' => 'fake-token',
            ]),

            config('services.spotify.api_url') . '/search*' => Http::response([
                'artists' => [
                    'items' => [
                        [
                            'id' => '123',
                            'name' => 'Fake Artist',
                            'popularity' => 80,
                            'genres' => ['rock'],
                            'images' => [['url' => 'https://img.test']],
                        ]
                    ]
                ]
            ]),
        ]);
    }

    public function test_can_search_artists()
    {
        $response = $this->getJson('/api/music/artists?query=fake');

        $response->assertOk();
        $response->assertJsonFragment(['name' => 'Fake Artist']);
    }

    public function test_can_fetch_playlist_by_id()
    {
        Http::fake([
            config('services.spotify.api_url') . '/playlists/*' => Http::response([
                'id' => 'abc123',
                'name' => 'Test Playlist',
                'description' => 'Mocked description',
                'images' => [['url' => 'https://playlist.test']],
                'tracks' => ['items' => []],
            ]),
        ]);

        $response = $this->getJson('/api/music/playlists/abc123');

        $response->assertOk();
        $response->assertJsonFragment(['name' => 'Test Playlist']);
    }

    public function test_search_artists_requires_query_param()
    {
        $response = $this->getJson('/api/music/artists');

        $response->assertStatus(422);
        $response->assertJson(['error' => 'Missing query parameter']);
    }

    public function test_playlist_endpoint_handles_spotify_not_found()
    {
        Http::preventStrayRequests();
        Http::fake([
            config('services.spotify.token_url') => Http::response([
                'access_token' => 'fake-token',
            ]),
            config('services.spotify.api_url') . '/playlists/*' => Http::response([
                'error' => [
                    'status' => 404,
                    'message' => 'Not found'
                ]
            ], 404),
        ]);

        $response = $this->getJson('/api/music/playlists/invalid-id');

        $response->assertStatus(404);
        $response->assertJsonFragment(['message' => 'GET playlists/invalid-id failed: {"error":{"status":404,"message":"Not found"}}']);
    }
}
