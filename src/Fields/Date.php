<?php

namespace Internexus\Larapid\Fields;

use Internexus\Larapid\Facades\Larapid;

class Date extends Timestamp
{
    /**
     * Field component name.
     *
     * @var string
     */
    public static $component = 'date';

    /**
     * Get date format.
     *
     * @return string
     */
    public function getFormat()
    {
        return $this->format ?? Larapid::getConfig('date_format');
    }

    /**
     * Get field options.
     *
     * @return array
     */
    public function getOptions()
    {
        return [
            'mask' => Larapid::getConfig('date_mask')
        ];
    }
}
