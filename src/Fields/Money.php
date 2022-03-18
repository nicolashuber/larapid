<?php

namespace Internexus\Larapid\Fields;

use Illuminate\Database\Eloquent\Model;
use Internexus\Larapid\Facades\Larapid;
use NumberFormatter;

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
    public function display(Model $model)
    {
        $value = $model->{$this->getColumn()} ?? null;

        if ($value > 0) {
            return $value / 100;
        }

        return $value;
    }

    public function formatted($value)
    {
        if (! $value) {
            return null;
        }

        $formatter = new NumberFormatter('pt_BR', NumberFormatter::DECIMAL);
        $currency = Larapid::getConfig('currency');
        $symbol = Larapid::getConfig('currency_symbol');

        return $symbol . ' ' . $formatter->formatCurrency(
            $value,
            $currency
        );
    }

    /**
     * Display field value on detail.
     *
     * @param Model $model
     * @return mixed
     */
    public function displayOnDetail(Model $model)
    {
        return $this->formatted(
            $this->display($model)
        );
    }

    /**
     * Display field value on index.
     *
     * @param Model $model
     * @return mixed
     */
    public function displayOnIndex(Model $model)
    {
        return $this->formatted(
            $this->display($model)
        );
    }
}

