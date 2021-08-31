<?php

namespace Internexus\Larapid\Entities;

abstract class Entity
{
    /**
     * Entity related model.
     *
     * @var string
     */
    public static $model;

    /**
     * Entity title.
     *
     * @var string
     */
    public static $title = 'Entity';

    /**
     * Entity title column.
     *
     * @var string
     */
    public static $titleColumn = 'name';

    /**
     * Indicates if the resource should be displayed in the sidebar.
     *
     * @var bool
     */
    public static $displayInNavigation = true;

    /**
     * The logical group associated with the entity.
     *
     * @var string
     */
    public static $group;

    /**
     * Define entity fields.
     *
     * @return array
     */
    public function fields()
    {
        return [];
    }

    /**
     * Get route URL.
     *
     * @param int|null $id
     * @param string $action
     * @return string
     */
    public function route($id = null, $action = 'index')
    {
        $requiredId = $action == 'update' || $action == 'edit' || $action == 'destroy';

        if ($id && $requiredId) {
            return route("larapid.{$action}", [$this::slug(), $id]);
        }

        return route("larapid.{$action}", [$this::slug()]);
    }

    /**
     * Instantiate model.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function model()
    {
        return new static::$model;
    }

    /**
     * Get entity slug.
     *
     * @return string
     */
    public static function slug()
    {
        $classname = strtolower(get_called_class());
        $classpath = explode('\\', str_replace('entity', '', $classname));

        return array_pop($classpath);
    }

    /**
     * Get entity headers.
     *
     * @return array
     */
    public function headers()
    {
        $headers = [];

        foreach ($this->fields() as $field) {
            $headers[$field->column] = $field->label;
        }

        return $headers;
    }

    /**
     * Render entity form.
     *
     * @param mixed $model
     * @return string
     */
    public function getFields($model = null)
    {
        $fields = [];

        foreach ($this->fields() as $field) {
            if ($model) {
                $field->value($model->{$field->column} ?? null);
            }

            $fields[$field->column] = $field->getProps();
        }

        return $fields;
    }

    /**
     * Get entity validators rules.
     *
     * @return array
     */
    public function rules($method)
    {
        $validators = [];

        foreach ($this->fields() as $field) {
            if ($field->rules) {
                $rules = $field->rules;

                if ($method == 'POST' && $field->creationRules) {
                    $rules =  array_merge($rules, $field->creationRules);
                } else if ($method == 'PUT' && $field->creationRules) {
                    $rules =  array_merge($rules, $field->updateRules);
                }

                $validators[$field->column] = $rules;
            }
        }

        return $validators;
    }
}
