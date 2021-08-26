<?php

namespace App\Larapid\Entities;

abstract class Entity
{
    /**
     * Entity related model.
     *
     * @var string
     */
    public static $model;

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
            return route("larapid.{$action}", [$this->slug(), $id]);
        }

        return route("larapid.{$action}", [$this->slug()]);
    }

    /**
     * Get entity slug.
     *
     * @return string
     */
    public function slug()
    {
        $classname = strtolower(get_class($this));
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
    public function renderForm($model = null)
    {
        $html = '';

        foreach ($this->fields() as $field) {
            if ($model) {
                $value = $model->{$field->column} ?? null;
                $field->value($value);
            }

            $html .= $field->render();
        }

        return $html;
    }

    /**
     * Get entity validators.
     *
     * @return array
     */
    public function validators()
    {
        $validators = [];

        foreach ($this->fields() as $field) {
            if ($field->validators) {
                $validators[$field->column] = $field->validators;
            }
        }

        return $validators;
    }
}
