<?php

namespace App\Services\Shared;

use App\Exceptions\MusicApiException;
use Illuminate\Support\Facades\Http;
use RuntimeException;

abstract class AbstractMusicHttpService
{
    protected function get(string $endpoint, array $params = []): array
    {
        $response = Http::withToken($this->token())
            ->get($this->buildUrl($endpoint), $params);

        if (!$response->successful()) {
            throw new MusicApiException("GET $endpoint failed: " . $response->body(), $response->status());
        }

        return $response->json();
    }

    protected function post(string $endpoint, array $data = []): array
    {
        $response = Http::asForm()
            ->post($this->buildUrl($endpoint), $data);

        if (!$response->successful()) {
            throw new MusicApiException("GET $endpoint failed: " . $response->body(), $response->status());
        }

        return $response->json();
    }

    abstract protected function token(): string;
    abstract protected function buildUrl(string $endpoint): string;
}
