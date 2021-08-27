<?php

namespace Internexus\Larapid\Fields;

class Date extends Field
{
    /**
     * Field component name.
     *
     * @var string
     */
    public static $component = 'date';

    public function format($format)
    {
        $this->format = $format;

        return $this;
    }

    public function formatted()
    {
        //
    }
}
