<?php

namespace App\Repositories;

interface RepositoryInterface
{
    /**
     * Get all
     * @return mixed
     */
    public function getAll();

    /**
     * Get one
     * @param $id
     * @return mixed
     */
    public function find($id);

    /**
     * Get one or return false
     * @param $id
     * @return mixed
     */
    public function findOrFail($id);

    /**
     * Create
     * @param array $attributes
     * @return mixed
     */
    public function create($attributes = []);

    /**
     * Update
     * @param $id
     * @param array $attributes
     * @return mixed
     */
    public function update($id, $attributes = []);

    /**
     * Delete
     * @param $id
     * @return mixed
     */
    public function delete($id);

    /**
     * Paging
     * @param $id
     * @return mixed
     */
    public function paginate($per_page);

    /**
     * Where
     * @param $id
     * @return mixed
     */
    public function where($column, $value);

    /**
     * Count
     * @return init
     */
    public function count();

    public function forceUpdate($id, $array_value_with_key);
}
