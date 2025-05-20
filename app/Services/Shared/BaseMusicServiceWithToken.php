<?php

namespace App\Services\Shared;

use App\Enums\MusicSource;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use RuntimeException;

abstract class BaseMusicServiceWithToken extends AbstractMusicHttpService
{
    public function __construct(protected MusicSource $source) {}

    protected function token(): string
    {
        $cacheKey = "{$this->source->value}_token";

        return Cache::remember($cacheKey, now()->addMinutes(50), function () {
            $credentials = config("services.{$this->source->value}");

            $response = Http::asForm()->post($credentials['token_url'], [
                'grant_type' => 'client_credentials',
                'client_id' => $credentials['client_id'],
                'client_secret' => $credentials['client_secret'],
            ]);

            if (!$response->successful()) {
                throw new RuntimeException("Failed to authenticate with {$this->source->value} API.");
            }

            return $response->json('access_token');
        });
    }

    protected function buildUrl(string $endpoint): string
    {
        $baseUrl = config("services.{$this->source->value}.api_url");
        return rtrim($baseUrl, '/') . '/' . ltrim($endpoint, '/');
    }
}
