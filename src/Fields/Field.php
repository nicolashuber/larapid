<?php

namespace Internexus\Larapid\Fields;

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
     * Field rules.
     *
     * @var array
     */
    public $rules = [];

    /**
     * Field rules to creation.
     *
     * @var array
     */
    public $creationRules = [];

    /**
     * Field rules to update.
     *
     * @var array
     */
    public $updateRules = [];

    /**
     * Field helper text.
     *
     * @var array
     */
    public $help;

    /**
     * Field component name.
     *
     * @var string
     */
    public static $component;

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
     * Set rules to field.
     *
     * @param string $rules
     * @return self
     */
    public function rules($rules)
    {
        $this->rules = $rules;

        return $this;
    }

    /**
     * Set rules to creation.
     *
     * @param string $rules
     * @return self
     */
    public function creationRules($rules)
    {
        $this->creationRules = $rules;

        return $this;
    }

    /**
     * Set rules to update.
     *
     * @param string $rules
     * @return self
     */
    public function updateRules($rules)
    {
        $this->updateRules = $rules;

        return $this;
    }

    /**
     * Set field helper text.
     *
     * @param string $help
     * @return self
     */
    public function help($help)
    {
        $this->help = $help;

        return $this;
    }

    /**
     * Render field.
     *
     * @return \Illuminate\View\View
     */
    public function getProps()
    {
        return [
            'name' => $this->column,
            'label' => $this->label,
            'value' => $this->value,
            'help' => $this->help,
            'component' => static::$component,
            'placeholder' => $this->placeholder
        ];
    }
}
