<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    /**
     * @param Request $request
     * @return Application|Factory|View
     * @throws \Exception
     */
    public function index(Request $request): View|Factory|Application
    {
        $fields = $request->all();

        return $this->view('pages.dashboard.index', [
            'fields' => $fields
        ]);
    }
}
