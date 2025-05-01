<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderCreationRequest;
use App\Http\Requests\OrderUpdateRequest;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    
    public function __construct(private OrderService $service){}

    public function index() {
        if(request()->ajax() || request()->wantsJson()){
            return $this->service->pagination(request()->all());
        }
        return view('pages.orders.index');
    }

    public function create() {
        return view('pages.orders.create');
    }

    public function store(OrderCreationRequest $request){
        $body = $request->validated();
        Log::info('Creating order', $body);
        $this->service->create($body);
        return redirect()->route('orders.index')->with([
            'type' => 'success',
            'message' => 'Order created successfully'
        ]);
    }

    public function show($id) {
        $data = $this->service->detail($id);
        return view('pages.orders.show', compact('data'));
    }

    public function edit($id) {
        $order = $this->service->detail($id);
        return view('pages.orders.edit', compact('order'));
    }

    public function update($id, OrderUpdateRequest $request) {
        $body = $request->validated();
        $this->service->update($body,$id);
        return redirect()->route('orders.edit', ['id' => $id])->with([
            'type' => 'success',
            'message' => 'Order updated successfully'
        ]);
    }

    public function destroy($id) {
        $this->service->delete($id);
        return redirect()->route('orders.index')->with([
            'type' => 'success',
            'message' => 'Order deleted successfully'
        ]);
    }

    
}
