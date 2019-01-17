<?php

namespace App\Http\Middleware;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    protected function unauthorized()
    {
        return response()->json([
            'success' => 'false',
            'message' => 'Unauthorized',
            'data' => [],
        ], 401);
    }

    protected function authenticate($request, array $guards)
    {
        if (empty($guards)) {
            $guards = [null];
        }

        foreach ($guards as $guard) {
            if ($this->auth->guard($guard)->check()) {
                return $this->auth->shouldUse($guard);
            } else {
                return response()->json([
                    'success' => 'false',
                    'message' => 'Unauthorized',
                    'data' => [],
                ], 401);
            }
        }

        throw new AuthenticationException(
            'Unauthenticated.', $guards
        );
    }
}