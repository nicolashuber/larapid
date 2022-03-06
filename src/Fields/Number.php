<?php

namespace Internexus\Larapid\Fields;

class Number extends Field
{
    /**
     * The minimum value to accept.
     *
     * @var int
     */
    protected $min;

    /**
     * The maximum value to accept.
     *
     * @var int
     */
    protected $max;

    /**
     * Field component name.
     *
     * @var string
     */
    public static $component = 'number';

    public function min(int $min)
    {
        $this->min = $min;

        return $this;
    }

    public function max(int $max)
    {
        $this->max = $max;

        return $this;
    }
}

