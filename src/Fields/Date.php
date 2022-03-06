<?php

namespace Internexus\Larapid\Fields;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Internexus\Larapid\Facades\Larapid;

class Date extends Field
{
    /**
     * Field component name.
     *
     * @var string
     */
    public static $component = 'date';

    /**
     * Date format.
     *
     * @var string
     */
    public $format;

    /**
     * Display field value.
     *
     * @param Model $model
     * @return mixed
     */
    public function display(Model $model)
    {
        $value = $model->{$this->getColumn()};

        return $value ? $this->formatted($value) : null;
    }

    /**
     * Set date format string.
     *
     * @param string $format
     * @return self
     */
    public function format($format)
    {
        $this->format = $format;

        return $this;
    }

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
     * Get formatted value.
     *
     * @param mixed $value
     * @return string
     */
    public function formatted($value)
    {
        if ($value instanceof Carbon) {
            return $value->format($this->getFormat());
        }

        return $value;
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
