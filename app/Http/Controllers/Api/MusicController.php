<?php

namespace App\Http\Controllers\Api;

use App\Enums\MusicSource;
use App\Exceptions\MusicApiException;
use App\Http\Controllers\Controller;
use App\Services\Contracts\MusicServiceInterface;
use App\Services\Resolvers\MusicServiceResolver;
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
        try {
            $playlist = $this->musicService->getPlaylist($id);
            return response()->json($playlist);
        } catch (MusicApiException $ex) {
            return response()->json(['message' => $ex->getMessage()], $ex->getCode() ?: 500);
        }
    }

    public function searchTracks(Request $request): JsonResponse
    {
        $query = $request->query('query');

        if (!$query) {
            return response()->json(['error' => 'Missing query parameter'], 422);
        }

        return response()->json(
            $this->musicService->searchTrack($query)
        );
    }

    public function getTrack(string $id): JsonResponse
    {
        try {
            $track = $this->musicService->getTrack($id);
            return response()->json($track);
        } catch (MusicApiException $ex) {
            return response()->json(['message' => $ex->getMessage()], $ex->getCode() ?: 500);
        }
    }

    public function getAlbumsByArtist(string $id): JsonResponse
    {
        try {
            $albums = $this->musicService->getAlbumsByArtist($id);
            return response()->json($albums);
        } catch (MusicApiException $ex) {
            return response()->json(['message' => $ex->getMessage()], $ex->getCode() ?: 500);
        }
    }

    public function getTopTracksByArtist(string $id): JsonResponse
    {
        try {
            $tracks = $this->musicService->getTopTracksByArtist($id);
            return response()->json($tracks);
        } catch (MusicApiException $ex) {
            return response()->json(['message' => $ex->getMessage()], $ex->getCode() ?: 500);
        }
    }
}
