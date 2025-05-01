<?php

namespace App\Repositories;

interface OrderProductRepository extends BaseRepository
{
    public function createMany($orderId, array $orderProducts): bool;
}