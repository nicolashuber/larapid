<?php

namespace App\Larapid\Fields;

class Date extends Field
{
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
