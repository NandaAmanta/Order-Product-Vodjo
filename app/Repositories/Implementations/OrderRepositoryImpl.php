<?php

namespace App\Repositories\Implementations;

use App\Models\Order;
use App\Repositories\OrderRepository;
use App\Repositories\Implementations\BaseRepositoryImpl;

class OrderRepositoryImpl extends BaseRepositoryImpl implements OrderRepository
{
    public function __construct(Order $order) {
        parent::__construct($order);
    }
}