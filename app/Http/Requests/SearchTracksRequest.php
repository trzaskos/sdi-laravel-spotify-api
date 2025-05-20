<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchTracksRequest extends FormRequest
{
    /**
     * @queryParam query string required The track name to search. Example: love
     * @queryParam source string optional The music provider (spotify, youtube). Defaults to spotify. Example: spotify
     * @header Authorization string required Bearer token
     * @header Accept string required Must be application/json
     *
     * @response 200 [
     *   {
     *     "id": "123",
     *     "name": "Love Song",
     *     "album": "Greatest Hits",
     *     "image": "https://example.com/image.jpg",
     *     "preview_url": "https://example.com/preview.mp3",
     *     "source": "spotify"
     *   }
     * ]
     */
    public function rules(): array
    {
        return [
            'query' => 'required|string',
            'source' => 'nullable|string|in:spotify,youtube',
        ];
    }
}
