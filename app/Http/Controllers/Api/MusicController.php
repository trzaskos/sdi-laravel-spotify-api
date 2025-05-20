<?php

namespace App\Http\Controllers\Api;

use App\Enums\MusicSource;
use App\Exceptions\MusicApiException;
use App\Http\Controllers\Controller;
use App\Services\Contracts\MusicServiceInterface;
use App\Services\Resolvers\MusicServiceResolver;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Requests\SearchArtistRequest;
use App\Http\Requests\SearchTracksRequest;
use App\Http\Requests\BaseMusicByIdRequest;

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

    /**
     * Search Artist
     *
     * Search for an artist by name using the specified music provider.
     *
     * This endpoint searches for artists using a query string. You can optionally specify the music provider (source).
     *
     */
    public function searchArtist(SearchArtistRequest $request): JsonResponse
    {
        $validated = $request->validated();
        return response()->json(
            $this->musicService->searchArtist($validated['query'])
        );
    }

    /**
     * Get Playlist
     *
     * Retrieve a playlist by ID using the specified music provider.
     */
    public function getPlaylist(BaseMusicByIdRequest $request, string $id): JsonResponse
    {
        try {
            $playlist = $this->musicService->getPlaylist($id);
            return response()->json($playlist);
        } catch (MusicApiException $ex) {
            return response()->json(['message' => $ex->getMessage()], $ex->getCode() ?: 500);
        }
    }

    /**
     * Search Tracks
     *
     * Search for tracks by name using the specified music provider.
     */
    public function searchTracks(SearchTracksRequest $request): JsonResponse
    {
        $validated = $request->validated();
        return response()->json(
            $this->musicService->searchTrack($validated['query'])
        );
    }

    /**
     * Get Track
     *
     * Retrieve a track by ID using the specified music provider.
     */
    public function getTrack(BaseMusicByIdRequest $request, string $id): JsonResponse
    {
        try {
            $track = $this->musicService->getTrack($id);
            return response()->json($track);
        } catch (MusicApiException $ex) {
            return response()->json(['message' => $ex->getMessage()], $ex->getCode() ?: 500);
        }
    }

    /**
     * Get Albums by Artist
     *
     * Retrieve all albums for a specific artist using the specified music provider.
     */
    public function getAlbumsByArtist(BaseMusicByIdRequest $request, string $id): JsonResponse
    {
        try {
            $albums = $this->musicService->getAlbumsByArtist($id);
            return response()->json($albums);
        } catch (MusicApiException $ex) {
            return response()->json(['message' => $ex->getMessage()], $ex->getCode() ?: 500);
        }
    }

    /**
     * Get Top Tracks by Artist
     *
     * Retrieve the top tracks for a specific artist using the specified music provider.
     */
    public function getTopTracksByArtist(BaseMusicByIdRequest $request, string $id): JsonResponse
    {
        try {
            $tracks = $this->musicService->getTopTracksByArtist($id);
            return response()->json($tracks);
        } catch (MusicApiException $ex) {
            return response()->json(['message' => $ex->getMessage()], $ex->getCode() ?: 500);
        }
    }
}
