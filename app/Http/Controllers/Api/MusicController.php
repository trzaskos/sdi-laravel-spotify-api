<?php

namespace App\Http\Controllers\Api;

use App\Enums\MusicSource;
use App\Http\Controllers\Controller;
use App\Services\MusicServiceInterface;
use App\Services\MusicServiceResolver;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MusicController extends Controller
{
    protected MusicServiceInterface $musicService;

    public function __construct(
        protected MusicServiceResolver $musicResolver,
        protected Request $request
    ) {
        $rawSource = $this->request->query('source', 'spotify');
        $source = MusicSource::tryFrom($rawSource);

        if (!$source) {
            abort(422, "Invalid music source: {$rawSource}");
        }

        $this->musicService = $this->musicResolver->resolve($source);
    }

    public function searchArtists(Request $request): JsonResponse
    {
        $query = $request->query('query');

        if (!$query) {
            return response()->json(['error' => 'Missing query parameter'], 422);
        }

        return response()->json(
            $this->musicService->searchArtist($query)
        );
    }

    public function getPlaylist(string $id): JsonResponse
    {
        return response()->json(
            $this->musicService->getPlaylist($id)
        );
    }
}
