<?php

namespace Internexus\Larapid\Fields;

use Illuminate\Database\Eloquent\Model;
use Internexus\Larapid\Facades\Larapid;

class Boolean extends Field
{
    /**
     * Field component name.
     *
     * @var string
     */
    public static $component = 'boolean';

    /**
     * Get text value from boolean
     *
     * @param boolean $boolean
     * @return string
     */
    protected function getText($boolean)
    {
        return Larapid::getConfig('bool_' . json_encode(boolval($boolean)));
    }

    /**
     * Display field value.
     *
     * @param Model $model
     * @return mixed
     */
    public function displayOnIndex(Model $model)
    {
        return sprintf(
            '<span class="badge bg-secondary">%s</span>',
            $this->getText($this->display($model))
        );
    }

    /**
     * Get field options.
     *
     * @return mixed
     */
    public function getOptions()
    {
        return [
            'choices' => [
                [
                    'label' => Larapid::getConfig('bool_true'),
                    'value' => 1,
                ],
                [
                    'label' => Larapid::getConfig('bool_false'),
                    'value' => 2,
                ]
            ]
        ];
    }
}
