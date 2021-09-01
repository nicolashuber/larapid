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
    public static $component = 'belongs-to';

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
     * Get field value.
     *
     * @return mixed
     */
    public function getValue()
    {
        $data = $this->getOptions();

        if (isset($data[$this->value])) {
            return $data[$this->value];
        }
    }

    /**
     * Get select options.
     *
     * @return array
     */
    public function getOptions()
    {
        $entity = Larapid::resolveEntity(strtolower($this->label));

        if ($entity) {
            $model = $entity->model();

            return $model->pluck($entity::$titleColumn, $model->getKeyName())->all();
        }

        return [];
    }
}

