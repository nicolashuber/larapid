<?php

namespace Internexus\Larapid\Fields;

use Illuminate\Database\Eloquent\Model;

class BelongsTo extends Relational
{
    /**
     * Field component name.
     *
     * @var string
     */
    public static $component = 'belongs-to';

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
        $entity = $this->resolveRelationEntity();

        if ($entity) {
            $model = $entity->model();

            return $model->pluck($entity::$titleColumn, $model->getKeyName())->all();
        }

        return [];
    }
}

