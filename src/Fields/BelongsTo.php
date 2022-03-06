<?php

namespace Internexus\Larapid\Fields;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Internexus\Larapid\Entities\Entity;
use Internexus\Larapid\Facades\Larapid;

class BelongsTo extends Field
{
    /**
     * Field component name.
     *
     * @var string
     */
    public static $component = 'belongs-to';

    /**
     * Get field column name.
     *
     * @return string
     */
    public function getColumn()
    {
        if ($this->column) {
            return $this->column;
        }

        return Str::snake(Str::lower($this->label)) . '_id';
    }

    /**
     * Display field value.
     *
     * @param Model $model
     * @return mixed
     */
    public function display(Model $model)
    {
        $method = $this->guestRelationMethod();

        if (method_exists($model, $method)) {
            $entity = $this->resolveRelationEntity();

            if (isset($model->{$entity::slug()})) {
                return $model->{$entity::slug()}->{$entity::$titleColumn};
            }
        }

        return $this->value;
    }

    /**
     * Guest method name for relation.
     *
     * @return string
     */
    private function guestRelationMethod()
    {
        return str_replace('_id', '', $this->getColumn());
    }

    /**
     * Resolve relation entity
     *
     * @return Entity
     */
    private function resolveRelationEntity()
    {
        return Larapid::resolveEntity($this->guestRelationMethod());
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

