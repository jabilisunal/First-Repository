<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class BasicAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param  Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if (config('baseauth.users')->contains([$request->getUser(), $request->getPassword()])) {
            return $next($request);
        }

        return response('You shall not pass!', 401, ['WWW-Authenticate' => 'Basic']);
    }
}
