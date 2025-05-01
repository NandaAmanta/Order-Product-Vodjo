<?php

namespace App\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

interface BaseRepository
{
    public function getQueryBuilder(): Builder;

    public function create(array $data): Model;

    public function updateById($id, array $data): Collection;

    public function deleteById($id): bool;

    public function findById(int $id, $with = []): ?Model;

    public function save(Model $model): Model;

    public function pagination($params = []): LengthAwarePaginator;

    public function getByField($field, $value): Collection;
}
