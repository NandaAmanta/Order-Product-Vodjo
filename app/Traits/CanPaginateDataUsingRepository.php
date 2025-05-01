<?php

namespace App\Traits;

use Yajra\DataTables\DataTables;

trait CanPaginateDataUsingRepository
{
    public function pagination(array $request){
        return DataTables::of($this->repository->getQueryBuilder())->make(true);
    }
}
