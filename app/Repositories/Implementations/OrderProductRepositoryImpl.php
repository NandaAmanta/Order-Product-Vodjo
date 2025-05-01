<?php

namespace App\Repositories\Implementations;

use App\Models\OrderProduct;
use App\Repositories\OrderRepository;
use App\Repositories\Implementations\BaseRepositoryImpl;
use App\Repositories\OrderProductRepository;

class OrderProductRepositoryImpl extends BaseRepositoryImpl implements OrderProductRepository
{
    public function __construct(OrderProduct $orderProduct) {
        parent::__construct($orderProduct);
    }

    
    public function createMany($orderId, array $orderProducts): bool{

        $data = []; 
        foreach ($orderProducts as $orderProduct) {
            $data[] = [
                'order_id' => $orderId,
                'product_name' => $orderProduct['product_name'],
                'qty' => $orderProduct['qty'],
                'price' => $orderProduct['price'],
                'subtotal' => $orderProduct['qty'] * $orderProduct['price'],
                'created_at' => now(),
                'updated_at' => now()
            ];
        }
        return $this->model::insert($data);
    }

    public function deleteByIds(array $ids): bool{
        return $this->model::query()->whereIn('id', $ids)->delete();
    }

    public function createOrUpdateMany($orderId, array $orderProducts): bool{
        $data = []; 
        foreach ($orderProducts as $orderProduct) {
            $data[] = [
                'id' => $orderProduct['id'] ?? null,
                'order_id' => $orderId,
                'product_name' => $orderProduct['product_name'],
                'qty' => $orderProduct['qty'],
                'price' => $orderProduct['price'],
                'subtotal' => $orderProduct['qty'] * $orderProduct['price'],
                'created_at' => now(),
                'updated_at' => now()
            ];
        }
        return $this->model::upsert($data, ['id']);
    }
}