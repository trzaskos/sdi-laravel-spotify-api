<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\MusicServiceInterface;
use Illuminate\Http\Request;

class MusicController extends Controller
{
    public function __construct(protected MusicServiceInterface $musicServiceInterface) {}

    public function searchArtists(Request $request)
    {
        $query = $request->query('query');

        if (!$query) {
            return response()->json(['error' => 'Missing query parameter'], 422);
        }

        return response()->json(
            $this->musicServiceInterface->searchArtist($query)
        );
    }

    public function getPlaylist(string $id)
    {
        return response()->json(
            $this->musicServiceInterface->getPlaylist($id)
        );
    }
}
