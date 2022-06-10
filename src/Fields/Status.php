<?php

namespace Internexus\Larapid\Fields;

use Illuminate\Database\Eloquent\Model;

class Status extends Select
{
    /**
     * Show field only on creating.
     *
     * @var boolean
     */
    protected $showOnCreating = false;

    /**
     * Show field only on updating.
     *
     * @var boolean
     */
    protected $showOnUpdating = false;

    protected $colors = [];

    protected function getVariant($value)
    {
        if (in_array($value, array_keys($this->colors))) {
            return $this->colors[$value];
        }

        return 'secondary';
    }

    public function colors($colors)
    {
        $this->colors = $colors;

        return $this;
    }

    /**
     * Get selected option.
     *
     * @param Model $model
     * @return string|null
     */
    protected function getSelected(Model $model)
    {
        $value = parent::getSelected($model);
        $variant = $this->getVariant($this->display($model));

        if ($value) {
            return sprintf('<span class="badge bg-%s">%s</span>', $variant, $value);
        }

        return null;
    }
}

