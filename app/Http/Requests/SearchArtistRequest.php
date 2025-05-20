<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseMusicRequest;

class SearchArtistRequest extends BaseMusicRequest
{
    /**
     * @queryParam query string required The artist name to search. Example: drake
     * @queryParam source string optional The music provider (spotify, youtube, deezer). Defaults to spotify. Example: spotify
     * @header Authorization string required Bearer token
     * @header Accept string required Must be application/json
     *
     * @response 200 [
     *   {
     *     "id": "1",
     *     "name": "Drake",
     *     "image": "https://example.com/image.jpg",
     *     "source": "spotify"
     *   }
     * ]
     */
    public function rules(): array
    {
        return [
            'query' => 'required|string',
        ];
    }
}
