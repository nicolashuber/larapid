<?php

namespace App\Larapid\Fields;

use Illuminate\Support\Str;

abstract class Field
{
    /**
     * Field label.
     *
     * @var string
     */
    public $label;

    /**
     * Field column.
     *
     * @var string
     */
    public $column;

    /**
     * Field value.
     *
     * @var string
     */
    public $value;

    /**
     * Field placeholder.
     *
     * @var string
     */
    public $placeholder;

    /**
     * Field validators.
     *
     * @var array
     */
    public $validators;

    /**
     * Construct a field.
     *
     * @param string $label
     * @param string $column
     */
    public function __construct($label, $column)
    {
        $this->label = $label;
        $this->column = $column ?? Str::snake(Str::lower($label));
    }

    /**
     * Instantiate a field.
     *
     * @param string $label
     * @param string $column
     * @return self
     */
    public static function make($label, $column = null)
    {
        return new static($label, $column);
    }

    /**
     * Set a value to field.
     *
     * @param string $value
     * @return self
     */
    public function value($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Set a placeholder to field.
     *
     * @param string $placeholder
     * @return self
     */
    public function placeholder($placeholder)
    {
        $this->placeholder = $placeholder;

        return $this;
    }

    /**
     * Set validators to field.
     *
     * @param string $validators
     * @return self
     */
    public function validators($validators)
    {
        $this->validators = $validators;

        return $this;
    }

    /**
     * Render field.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        $namespaces = explode('\\', get_class($this));
        $bladeName = lcfirst(array_pop($namespaces));

        return view('larapid::fields.' . $bladeName, [
            'field' => $this
        ]);
    }
}
