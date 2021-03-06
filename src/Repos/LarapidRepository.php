<?php

namespace Internexus\Larapid\Repos;

use Illuminate\Database\Eloquent\Model;
use Internexus\Larapid\Query\Search;

class LarapidRepository
{
    /**
     * Entity model.
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * Construct.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * List entity.
     *
     * @param int $perPage
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function list($perPage = 25)
    {
        return $this->model->latest()->paginate($perPage);
    }

    /**
     * Search on entity.
     *
     * @param string $query
     * @param array $fields
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function filter($query, array $searchableFields = [], $perPage = 25, string $sortBy = null)
    {
        $search = new Search($searchableFields, $sortBy);

        return $search->runQuery($this->model->query(), $query)->paginate($perPage);
    }

    /**
     * Find a entity.
     *
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function find($id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Create a new entity item.
     *
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function store($data)
    {
        return $this->model->create($data);
    }

    /**
     * Update a entity item.
     *
     * @param int $id
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function update($id, $data)
    {
        $item = $this->find($id);
        $item->update($data);

        return $item;
    }

    /**
     * Delete a entity item.
     *
     * @param int $id
     * @return boolean
     */
    public function destroy($id)
    {
        $item = $this->find($id);

        return $item->delete();
    }
}
