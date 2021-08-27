<?php

namespace Internexus\Larapid\Fields;

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
}

