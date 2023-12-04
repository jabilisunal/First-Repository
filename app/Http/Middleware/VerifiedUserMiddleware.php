<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifiedUserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $payload = auth()->guard('api')->payload()->toArray();

        if (isset($payload['isVerified']) && $payload['isVerified'] === true) {
            return $next($request);
        }

        return response()->json([
            'success' => false,
            'message' => 'You not verified with OTP'
        ], Response::HTTP_FORBIDDEN);
    }
}
