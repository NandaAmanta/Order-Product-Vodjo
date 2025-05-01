<?php

namespace App\Repositories;

interface OrderProductRepository extends BaseRepository
{
    public function createMany($orderId, array $orderProducts): bool;
    public function createOrUpdateMany($orderId, array $orderProducts): bool;
    public function deleteByIds(array $ids): bool;

}