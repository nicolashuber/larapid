<?php

namespace Internexus\Larapid\Fields;

class Id extends Field
{
    /**
     * Field component name.
     *
     * @var string
     */
    public static $component = 'id';

    /**
     * Show field only on detail.
     *
     * @var boolean
     */
    protected $showOnDetail = false;

    /**
     * Instantiate a field.
     *
     * @param string $label
     * @param string $column
     * @return self
     */
    public static function make($label = '#', $column = 'id')
    {
        return new static($label, $column);
    }
}
