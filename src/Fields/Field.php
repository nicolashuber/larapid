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
    protected $label;

    /**
     * Field column.
     *
     * @var string
     */
    protected $column;

    /**
     * Field value.
     *
     * @var string
     */
    protected $value;

    /**
     * Field placeholder.
     *
     * @var string
     */
    protected $placeholder;

    /**
     * Field rules.
     *
     * @var array
     */
    protected $rules = [];

    /**
     * Field rules to creation.
     *
     * @var array
     */
    protected $creationRules = [];

    /**
     * Field rules to update.
     *
     * @var array
     */
    protected $updateRules = [];

    /**
     * Field helper text.
     *
     * @var array
     */
    protected $help;

    /**
     * Display field callback.
     *
     * @var array
     */
    protected $displayUsing;

    /**
     * Field component name.
     *
     * @var string
     */
    protected static $component;

    /**
     * Show field only on index.
     *
     * @var boolean
     */
    protected $showOnIndex = true;

    /**
     * Show field only on detail.
     *
     * @var boolean
     */
    protected $showOnDetail = true;

    /**
     * Show field only on creating.
     *
     * @var boolean
     */
    protected $showOnCreating = true;

    /**
     * Show field only on updating.
     *
     * @var boolean
     */
    protected $showOnUpdating = true;

    /**
     * Construct a field.
     *
     * @param string $label
     * @param string $column
     */
    public function __construct($label, $column)
    {
        $this->label = $label;
        $this->column = $column;
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
     * Set callback to display field value.
     *
     * @param callable $callback
     * @return self
     */
    public function displayUsing(callable $callback)
    {
        $this->displayUsing = $callback;

        return $this;
    }

    /**
     * Get field column name.
     *
     * @return string
     */
    public function getColumn()
    {
        if ($this->column) {
            return $this->column;
        }

        return Str::snake(Str::lower($this->label));
    }

    /**
     * Get field label.
     *
     * @return mixed
     */
    public function getLabel()
    {
        $label = $this->label;

        if (is_callable($label)) {
            return $label();
        }

        return $label;
    }

    /**
     * Get field value.
     *
     * @return mixed
     */
    public function getValue()
    {
        $value = $this->value;

        if (is_callable($value)) {
            return $value();
        }

        return $value;
    }

    /**
     * Get field help.
     *
     * @return mixed
     */
    public function getHelp()
    {
        $help = $this->help;

        if (is_callable($help)) {
            return $help();
        }

        return $help;
    }

    /**
     * Get field placeholder.
     *
     * @return mixed
     */
    public function getPlaceholder()
    {
        $placeholder = $this->placeholder;

        if (is_callable($placeholder)) {
            return $placeholder();
        }

        return $placeholder;
    }

    /**
     * Get field options.
     *
     * @return mixed
     */
    public function getOptions()
    {
        //
    }

    /**
     * Get field rules.
     *
     * @return mixed
     */
    public function getRules()
    {
        return $this->rules;
    }

    /**
     * Get field rules for creation.
     *
     * @return mixed
     */
    public function getCreationRules()
    {
        return $this->creationRules;
    }

    /**
     * Get field rules for update.
     *
     * @return mixed
     */
    public function getUpdateRules()
    {
        return $this->updateRules;
    }

    /**
     * Get field props.
     *
     * @return array
     */
    public function getProps()
    {
        return [
            'name' => $this->getColumn(),
            'label' => $this->getLabel(),
            'value' => $this->getValue(),
            'help' => $this->getHelp(),
            'component' => static::$component,
            'placeholder' => $this->getPlaceholder(),
            'options' => $this->getOptions(),
        ];
    }

    /**
     * Show field on index.
     *
     * @return self
     */
    public function showOnIndex()
    {
        $this->showOnIndex = true;

        return $this;
    }

    /**
     * Show field on detail.
     *
     * @return self
     */
    public function showOnDetail()
    {
        $this->showOnDetail = true;

        return $this;
    }

    /**
     * Show field when creating.
     *
     * @return self
     */
    public function showOnCreating()
    {
        $this->showOnCreating = true;

        return $this;
    }

    /**
     * Show field when updating.
     *
     * @return self
     */
    public function showOnUpdating()
    {
        $this->showOnUpdating = true;

        return $this;
    }

    /**
     * Hide on index.
     *
     * @return self
     */
    public function hideFromIndex()
    {
        $this->showOnIndex = false;

        return $this;
    }

    /**
     * Hide on detail.
     *
     * @return self
     */
    public function hideFromDetail()
    {
        $this->showOnDetail = false;

        return $this;
    }

    /**
     * Hide field when creating.
     *
     * @return self
     */
    public function hideWhenCreating()
    {
        $this->showOnCreating = false;

        return $this;
    }

    /**
     * Hide field when creating.
     *
     * @return self
     */
    public function hideWhenUpdating()
    {
        $this->showOnUpdating = false;

        return $this;
    }

    /**
     * Show field only on index.
     *
     * @return self
     */
    public function onlyOnIndex()
    {
        $this->showOnIndex = true;
        $this->showOnDetail = false;
        $this->showOnCreating = false;
        $this->showOnUpdating = false;

        return $this;
    }

    /**
     * Show field only on detail.
     *
     * @return self
     */
    public function onlyOnDetail()
    {
        $this->showOnIndex = false;
        $this->showOnDetail = true;
        $this->showOnCreating = false;
        $this->showOnUpdating = false;

        return $this;
    }

    /**
     * Show field when creating or updating.
     *
     * @return self
     */
    public function onlyOnForms()
    {
        $this->showOnIndex = false;
        $this->showOnDetail = false;
        $this->showOnCreating = true;
        $this->showOnUpdating = true;

        return $this;
    }

    /**
     * Hide field when creating or updating.
     *
     * @return self
     */
    public function exceptOnForms()
    {
        $this->showOnIndex = true;
        $this->showOnDetail = true;
        $this->showOnCreating = false;
        $this->showOnUpdating = false;

        return $this;
    }

    /**
     * The field is visible on index.
     *
     * @return boolean
     */
    public function isVisibleOnIndex()
    {
        return $this->showOnIndex;
    }

    /**
     * The field is visible on detail.
     *
     * @return boolean
     */
    public function isVisibleOnDetail()
    {
        return $this->showOnDetail;
    }

    /**
     * The field is visible when creating.
     *
     * @return boolean
     */
    public function isVisibleOnCreating()
    {
        return $this->showOnCreating;
    }

    /**
     * The field is visible when updating.
     *
     * @return boolean
     */
    public function isVisibleOnUpdating()
    {
        return $this->showOnUpdating;
    }
}
