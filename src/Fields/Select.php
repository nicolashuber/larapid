<?php

namespace Internexus\Larapid\Fields;

use Illuminate\Database\Eloquent\Model;

class Select extends Field
{
    /**
     * Field component name.
     *
     * @var string
     */
    public static $component = 'select';

    /**
     * Select option.
     *
     * @var array
     */
    public $options;

    /**
     * Set select options.
     *
     * @return array
     */
    public function options(array $options)
    {
        $this->options = $options;

        return $this;
    }

    /**
     * Get field options.
     *
     * @return mixed
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Display on index
     */
    public function displayOnIndex(Model $model)
    {
        $value = $this->display($model);
        $options = $this->getOptions();

        if (in_array($value, array_keys($options))) {
            return $options[$value];
        }

        return null;
    }
}

