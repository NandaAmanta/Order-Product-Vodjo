<?php

namespace App\Services;

use App\Repositories\OrderProductRepository;
use App\Repositories\OrderRepository;
use App\Traits\CanCrudUsingRepository;
use App\Traits\CanPaginateDataUsingRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;

class OrderService
{
    use CanCrudUsingRepository, CanPaginateDataUsingRepository;

    public function __construct(private OrderRepository $repository, private OrderProductRepository $orderProductRepository) {}

    public function create(array $data) {
        return DB::transaction(function () use ($data) {
            $this->calculateGrandTotal($data);
            $order = $this->repository->create($data);
            if(isset($data['order_products']) && count($data['order_products']) > 0){
                $this->orderProductRepository->createMany($order->id, $data['order_products']);
            }
            
            return $order;
        });
    }

    public function update(array $data, $id)
    {
        return DB::transaction(function () use ($data, $id) {
            Log::info('Updating order', $data);
            $this->calculateGrandTotal($data);
            $this->repository->updateById($id, $data);
            $order = $this->repository->findById($id);

            // Get and delete order products that are not in the request
            $orderProducts = $order->orderProducts->pluck('id')->toArray();
            $orderProductIds = array_column($data['order_products'], 'id');
            $orderProductsToDelete = array_diff($orderProducts, $orderProductIds);
            $this->orderProductRepository->deleteByIds($orderProductsToDelete);

            // Create or update order products
            if(isset($data['order_products']) && count($data['order_products']) > 0){
                $this->orderProductRepository->createOrUpdateMany($order->id, $data['order_products']);
            }
            
        });
    }

    public function detail($id)
    {
        return $this->repository->findById($id, ['orderProducts']);
    }

    public function pagination(array $request){
        $query = $this->repository->getQueryBuilder();
        $query->when(isset($request['start_at']) && $request['start_at'], function ($query)  use ($request) {
            return $query->whereDate('order_date', '>=', $request['start_at']);
        })
        ->when(isset($request['end_at']) && $request['end_at'], function ($query) use ($request) {
            return $query->whereDate('order_date', '<=', $request['end_at']);
        });
        return DataTables::of($query)->make(true);
    }

    /**
     * Calculates the grand total for an order by summing up the subtotal of each order product.
     *
     * @param array $data Reference to the order data array containing order products.
     *                    The grand total is calculated and added to this array.
     */
    private function calculateGrandTotal(&$data) {
        $data['grand_total'] = 0;
        foreach ($data['order_products'] as $orderProduct) {
            $data['grand_total'] += $orderProduct['qty'] * $orderProduct['price'];
        }
    }
}