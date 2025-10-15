<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    use ApiResponseTrait;
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return $this->errorResponse(
                null,
                'يجب تسجيل الدخول أولاً',
                401
            );
        }
    }

}
