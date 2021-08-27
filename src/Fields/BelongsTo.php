<?php

namespace Internexus\Larapid\Fields;

use Internexus\Larapid\Facades\Larapid;

class BelongsTo extends Field
{
    /**
     * Field component name.
     *
     * @var string
     */
    public static $component = 'belongsTo';

    /**
     * Construct a field.
     *
     * @param string $label
     * @param string $column
     */
    public function __construct($label, $column = null)
    {
        parent::__construct($label, $column);

        if (empty($column)) {
            $this->column .= '_id';
        }
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
