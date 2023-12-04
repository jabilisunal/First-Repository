<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DocAccessMiddleware
{

    public function handle($request, Closure $next)
    {
        header('Cache-Control: no-cache, must-revalidate, max-age=0');

        if (!($user = $this->checkCredentials($request))) {
            $this->accessDenied();
        }

        $request->request->set('user', $user);

        return $next($request);
    }

    public function checkCredentials($request)
    {
        $user = User::where('email',$request->getUser())->first();

        if (!$user) {
            return false;
        }

        if (!Hash::check($request->getPassword(),$user->password)) {
            return false;
        }

        return $user;
    }

    public function accessDenied() : void
    {
        header('HTTP/1.1 401 Authorization Required');
        header('WWW-Authenticate: Basic realm="Access denied"');
        exit;
    }
}
