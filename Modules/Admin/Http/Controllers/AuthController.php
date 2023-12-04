<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class AuthController extends Controller
{

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected string $redirectTo = '/admin/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->middleware('guest:admin')->except('logout');
    }

    /**
     * @return Application|Factory|View
     */
    public function showLoginForm(): Factory|View|Application
    {
        return $this->view('pages.login.index');
    }

    /**
     * The user has logged out of the application.
     *
     * @param Request $request
     * @return Application|RedirectResponse|Response|Redirector
     */
    protected function loggedOut(Request $request): Response|Redirector|Application|RedirectResponse
    {
        return $request->wantsJson()
            ? new Response('', 204)
            : redirect('/admin/login');
    }

}
