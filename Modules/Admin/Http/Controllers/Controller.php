<?php


namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller as BaseController;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{

    public function __construct()
    {
        Auth::setDefaultDriver('admin');
    }

    /**
     * @param string $name
     * @param array $data
     * @return Application|Factory|View
     */
    public function view(string $name, array $data = []): Factory|View|Application
    {
        return view('admin::'.$name,$data);
    }
}
