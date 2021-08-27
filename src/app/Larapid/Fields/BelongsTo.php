<?php

namespace App\Larapid\Fields;

use App\Larapid\Facades\Larapid;

class BelongsTo extends Field
{
    /**
     * Construct a field.
     *
     * @param string $label
     * @param string $column
     */
    public function __construct($label, $column)
    {
        parent::__construct($label, $column);

        $this->column .= '_id';
    }

    /**
     * Get select options.
     *
     * @return array
     */
    public function options()
    {
        $entity = Larapid::resolveEntity(strtolower($this->label));

        if ($entity) {
            $model = $entity->model();

            return $model->pluck($entity::$title, $model->getKeyName())->all();
        }

        return [];
    }
}

