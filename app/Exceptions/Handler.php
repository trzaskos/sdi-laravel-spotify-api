<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;

class Handler extends ExceptionHandler
{
    protected $levels = [
        // ...
    ];

    protected $dontReport = [
        //
    ];

    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        $this->renderable(function (MusicApiException $e, $request) {
            return response()->json([
                'error' => $e->getMessage(),
            ], $e->getCode() ?: 500);
        });
        $this->renderable(function (ThrottleRequestsException $e, $request) {
            return response()->json([
                'message' => 'You have exceeded the request limit. Please try again in a few moments.',
            ], 429);
        });
    }
}
