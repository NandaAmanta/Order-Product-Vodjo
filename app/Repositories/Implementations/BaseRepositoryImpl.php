<?php

namespace App\Repositories\Implementations;

use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class BaseRepositoryImpl implements BaseRepository
{
    public function __construct(protected Model $model) {}

    public function getQueryBuilder(): Builder
    {
        return $this->model::query();
    }

    public function findById(int $id, $with = []): ?Model {
        return $this->model::query()
            ->with($with)
            ->findOrFail($id);
    }

    public function create(array|Model $data): Model {
        if (is_array($data)) {
            $data = $this->model::query()
                ->create($data);
        }
        else $data->save();
        return $data;
    }

    public function updateById($id, array $data): Model
    {
        $resource = $this->model->find($id);
        $resource->fill($data);
        $resource->save();
        return $resource;
    }

    public function deleteById($id): bool
    {
        return $this->model::query()->where('id', $id)->delete();
    }

    public function save(Model $model): Model
    {
        $model->save();
        return $model;
    }

    public function getByField($field, $value): Collection
    {
        return $this->model::query()->where($field, $value)->get();
    }

    public function pagination($params = []): LengthAwarePaginator
    {
        return $this->basePagination($this->model::query(), $params);
    }

    protected function basePagination($query = null, $params = []): LengthAwarePaginator
    {
        $perPage = $params['perPage'] ?? config('app.pagination.per_page');

        $sortField = isset($params['sortField']) && $params['sortField'] !== 'null' ? $params['sortField'] : 'created_at';
        $sortOrder = isset($params['sortOrder']) && $params['sortOrder'] !== 'null' ? $params['sortOrder'] : 'desc';

        return ($query ?? $this->model::query())
            ->orderBy($sortField, $sortOrder)
            ->paginate($perPage);
    }

}
