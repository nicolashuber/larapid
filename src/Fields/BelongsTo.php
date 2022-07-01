<?php

namespace Internexus\Larapid\Fields;

use Illuminate\Database\Eloquent\Model;

class BelongsTo extends Relational
{
    protected $isAjax = false;

    /**
     * Field component name.
     *
     * @var string
     */
    public static $component = 'belongs-to';

    protected $customQueryCb;

    /**
     * Display field value on index.
     *
     * @param Model $model
     * @return mixed
     */
    protected function displayRelation(Model $model)
    {
        $method = $this->guestRelationMethod();

        if (method_exists($model, $method)) {
            $entity = $this->resolveRelationEntity();

            if (isset($model->{$method})) {
                return $model->{$method}->{$entity::$titleColumn};
            }
        }

        return $this->display($model);
    }

    /**
     * Display field value on index.
     *
     * @param Model $model
     * @return mixed
     */
    public function displayOnIndex(Model $model)
    {
        return $this->displayRelation($model);
    }

    /**
     * Display field value on detail.
     *
     * @param Model $model
     * @return mixed
     */
    public function displayOnDetail(Model $model)
    {
        return $this->displayRelation($model);
    }

    /**
     * Get select options.
     *
     * @return array
     */
    public function getOptions()
    {
        $data = [];
        $default = null;
        $entity = $this->resolveRelationEntity();

        if ($entity) {
            $model = $entity->model();
            $value = $this->getValue();
            $primaryKey = $model->getKeyName();
            $query = $model->query();

            if (! $this->isAjax) {
                if ($this->customQueryCb) {
                    $query = call_user_func($this->customQueryCb, $query);
                }

                $data = $query->pluck($entity::$titleColumn, $primaryKey)->all();
            } else if ($value) {
                $column = $this->getColumn();

                $default = $entity->title($model->find($value->$column));
            }
        }

        return [
            'data' => $data,
            'entity' => $this->entity ? $this->entity::slug() : null,
            'default' => $default,
            'isAjax' => $this->isAjax,
        ];
    }

    public function customQuery(callable $callback)
    {
        $this->customQueryCb = $callback;

        return $this;
    }

    public function isAjax()
    {
        $this->isAjax = true;

        return $this;
    }
}

