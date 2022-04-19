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

    /**
     * Set field min number.
     *
     * @param int $max
     * @return self
     */
    public function min(int $min)
    {
        $this->min = $min;

        return $this;
    }

    /**
     * Set field max number.
     *
     * @param int $max
     * @return self
     */
    public function max(int $max)
    {
        $this->max = $max;

        return $this;
    }

    /**
     * Get field options.
     *
     * @return array
     */
    public function getOptions()
    {
        return [
            'min' => $this->min,
            'max' => $this->max,
        ];
    }
}

