<?php

namespace Internexus\Larapid\Fields;

use Illuminate\Database\Eloquent\Model;
use \NumberFormatter;

class Money extends Field
{
    /**
     * Field component name.
     *
     * @var string
     */
    public static $component = 'money';

    /**
     * Display field value.
     *
     * @param Model $model
     * @return mixed
     */
    public function displayOnIndex(Model $model)
    {
        $value = $this->display($model);

        if (! $value) {
            return null;
        }

        $formatter = new NumberFormatter('pt_BR', NumberFormatter::DECIMAL);

        return $formatter->formatCurrency(
            $value / 100,
            'BRL'
        );
    }
}

