<?php

namespace App\Traits;

/**
 * CanCrudUsingRepository
 *  
 * This trait is used to pagination, create, update, delete, detail
 * please define the repository first
 * 
 * @package   App\Traits
 */
trait CanCrudUsingRepository
{
    public function create(array $data)
    {
        return $this->repository->create($data);
    }

    public function update(array $data, $id)
    {
        return $this->repository->updateById($data, $id);
    }

    public function delete($id)
    {
        return $this->repository->deleteById($id);
    }

    public function detail($id)
    {
        return $this->repository->findById($id);
    }
}
