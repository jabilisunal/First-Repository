<?php

namespace App\Http\Middleware;

use App\Models\Language;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  Request  $request
     * @return string|null
     */
    protected function redirectTo($request, $guards = [])
    {
        if (! $request->expectsJson()) {

            $current_language = Language::where('code', $_SESSION['locale'] ?? 'az')->first();

            if (str_contains($request->path(), 'admin')) {
                return route('admin.login');
            }

            return route('auth.login', $current_language->code);
        }
    }
}
