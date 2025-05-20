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

            config('services.spotify.api_url') . '/playlist/*' => Http::response([
                'id' => 'abc123',
                'name' => 'Test Playlist',
                'description' => 'Mocked description',
                'images' => [['url' => 'https://playlist.test']],
                'tracks' => ['items' => []],
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
        $response = $this->getJson('/api/music/playlist/abc123');

        $response->assertOk();
        $response->assertJsonFragment(['name' => 'Test Playlist']);
    }
}
