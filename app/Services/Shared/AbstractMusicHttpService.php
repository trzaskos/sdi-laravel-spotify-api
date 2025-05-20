<?php

namespace App\Services\Shared;

use Illuminate\Support\Facades\Http;
use RuntimeException;

abstract class AbstractMusicHttpService
{
    protected function get(string $endpoint, array $params = []): array
    {
        $response = Http::withToken($this->token())
            ->get($this->buildUrl($endpoint), $params);

        if (!$response->successful()) {
            throw new RuntimeException("GET $endpoint failed: " . $response->body());
        }

        return $response->json();
    }

    protected function post(string $endpoint, array $data = []): array
    {
        $response = Http::asForm()
            ->post($this->buildUrl($endpoint), $data);

        if (!$response->successful()) {
            throw new RuntimeException("POST $endpoint failed: " . $response->body());
        }

        return $response->json();
    }

    abstract protected function token(): string;
    abstract protected function buildUrl(string $endpoint): string;
}
