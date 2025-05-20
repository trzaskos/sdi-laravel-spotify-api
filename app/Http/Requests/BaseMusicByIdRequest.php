<?php

namespace App\Http\Requests;

/**
 * Class BaseMusicByIdRequest
 *
 * @header Authorization string The authorization token
 * @queryParam source string The music source provider. Defaults to "spotify".
 */
class BaseMusicByIdRequest extends BaseMusicRequest
{
    //
}
