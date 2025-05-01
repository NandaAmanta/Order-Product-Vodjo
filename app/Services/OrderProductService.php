<?php

namespace App\Services;

use App\Repositories\OrderProductRepository;
use App\Traits\CanCrudUsingRepository;
use App\Traits\CanPaginateDataUsingRepository;

class OrderProductService
{
    use CanCrudUsingRepository, CanPaginateDataUsingRepository;

    public function __construct(public OrderProductRepository $repository) {}
}