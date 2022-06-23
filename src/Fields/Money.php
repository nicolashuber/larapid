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
     * Get field options.
     *
     * @return array
     */
    public function getOptions()
    {
        return [
            'currency' => Larapid::getConfig('currency'),
            'locale' => Larapid::getConfig('currency_locale'),
        ];
    }

    public function formatted($value)
    {
        if (! $value) {
            return null;
        }

        if ($value > 0) {
            $value /= 100;
        }

        $locale = Larapid::getConfig('currency_locale');
        $currency = Larapid::getConfig('currency');

        $formatter = new NumberFormatter($locale, NumberFormatter::CURRENCY);

        return $formatter->formatCurrency($value, $currency);
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

