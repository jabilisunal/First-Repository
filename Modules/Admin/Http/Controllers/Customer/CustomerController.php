<?php


namespace Modules\Admin\Http\Controllers\Customer;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
use Modules\Admin\Entities\Customer;
use Modules\Admin\Http\Controllers\Controller;

class CustomerController extends Controller {

    /**
     * @var string $viewPath
     */
    protected string $viewPath = 'pages.customer.customer.';

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return Renderable
     */
    public function index(Request $request): Renderable
    {
        $customers = Customer::where(['type' => 'supplier'])
            ->paginate();

        return $this->view($this->viewPath . 'index', [
            'customers' => $customers
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(): Renderable
    {
        $customers = ['customer', 'supplier'];

        return $this->view($this->viewPath . 'create', [
            'customers' => $customers
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return void
     */
    public function store(Request $request): void
    {
        $request->validate([
            'name' => 'required',
            'surname' => 'required',
            'surname' => 'required',
        ]);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(int $id): Renderable
    {
        return $this->view($this->viewPath . 'show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(int $id): Renderable
    {

        return $this->view($this->viewPath . 'edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return void
     */
    public function update(Request $request, int $id): void
    {

    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return void
     */
    public function destroy(int $id): void
    {

    }
}
