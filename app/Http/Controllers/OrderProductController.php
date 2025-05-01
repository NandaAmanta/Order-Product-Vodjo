<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderProductCreationRequest;
use App\Http\Requests\OrderProductUpdateRequest;
use App\Models\Order;
use App\Services\OrderProductService;
use Illuminate\Routing\Controller;

class OrderProductController extends Controller
{
    public function __construct(private OrderProductService $service){}

    public function index()
    {
        if(request()->ajax() || request()->wantsJson()){
            return $this->service->pagination(request()->all());
        }
        return view('pages.order_products.index');
    }

    public function create() {
        return view('pages.order_products.create');
    }

    public function store(OrderProductCreationRequest $request){
        $body = $request->validated();
        $this->service->create($body);
        return redirect()->route('pages.order_products.index')->with([
            'type' => 'success',
            'message' => 'Order Product created successfully'
        ]);
    }

    public function show($id) {
        $data = $this->service->detail($id);
        return view('pages.order_products.show', compact('data'));
    }

    public function edit($id) {
        $data = $this->service->detail($id);
        return view('pages.order_products.edit', compact('data'));
    }

    public function update($id, OrderProductUpdateRequest $request) {
        $body = $request->validated();
        $this->service->update($id, $body);
        return redirect()->route('pages.order_products.index')->with([
            'type' => 'success',
            'message' => 'Order Product updated successfully'
        ]);
    }

    public function destroy($id) {
        $this->service->delete($id);
        return redirect()->route('orders.index')->with([
            'type' => 'success',
            'message' => 'Order Product deleted successfully'
        ]);
    }
}
