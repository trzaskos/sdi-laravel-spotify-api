<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\RateLimiter;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
use App\Models\User;

class RateLimitingTest extends TestCase
{
    public function test_throttle_blocks_excessive_requests()
    {
        $user = User::factory()->create();
        RateLimiter::clear('login:' . $user->id);
        Sanctum::actingAs($user);

        for ($i = 0; $i < 60; $i++) {
            $this->getJson('/api/music/artists?query=test')->assertOk();
        }

        $response = $this->getJson('/api/music/artists?query=test');

        $response->assertStatus(429);
        $response->assertJsonFragment([
            'message' => 'You have exceeded the request limit. Please try again in a few moments.',
        ]);
    }
}
