<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class BaseMusicRequest extends FormRequest
{
    /**
     * @queryParam source string optional The music provider. Accepted values: spotify, youtube. Defaults to spotify. Example: spotify
     *
     * @header Authorization string required Bearer token
     * @header Accept string required Must be application/json
     */
    public function rules(): array
    {
        return [
            'source' => 'nullable|string|in:spotify,youtube',
        ];
    }
}
