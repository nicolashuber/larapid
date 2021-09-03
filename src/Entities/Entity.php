<?php

namespace Internexus\Larapid\Entities;

use Illuminate\Database\Eloquent\Model;

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
     * Define entity fields for index.
     *
     * @return array
     */
    public function fieldsForIndex()
    {
        return [];
    }

    /**
     * Define entity fields for detail.
     *
     * @return array
     */
    public function fieldsForDetail()
    {
        return [];
    }

    /**
     * Define entity fields for create.
     *
     * @return array
     */
    public function fieldsForCreate()
    {
        return [];
    }

    /**
     * Define entity fields for update.
     *
     * @return array
     */
    public function fieldsForUpdate()
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
     * Get entity columnns.
     *
     * @return array
     */
    public function getHeaders()
    {
        $headers = [];

        foreach ($this->fields() as $field) {
            if ($field->isVisibleOnIndex()) {
                $headers[$field->getColumn()] = $field->getLabel();
            }
        }

        return $headers;
    }

    /**
     * Filter fields by visibility.
     *
     * @param array $fields
     * @param string|null $page
     * @param Model|null $model
     * @return array
     */
    private function filterFields($fields, $page = null, Model $model = null)
    {
        $data = [];
        $fields = count($fields) > 0 ? $fields : $this->fields();
        $visibilityMethod = 'isVisibleOn' . ucfirst($page);

        foreach ($fields as $field) {
            $column = $field->getColumn();

            if ($model) {
                $field->value($model->{$column} ?? null);
            }

            if ($page && $field->{$visibilityMethod}()) {
                $data[$column] = $field->getProps();
            }
        }

        return $data;
    }

    /**
     * Get all fields.
     *
     * @param Model $model
     * @return array
     */
    public function getFields(Model $model = null)
    {
        return $this->filterFields($this->fields(), null, $model);
    }

    /**
     * Get fields for index.
     *
     * @param Model $model
     * @return array
     */
    public function getIndexFields(Model $model)
    {
        return $this->filterFields($this->fieldsForIndex(), 'index', $model);
    }

    /**
     * Get fields for detail.
     *
     * @param Model $model
     * @return array
     */
    public function getDetailFields(Model $model)
    {
        return $this->filterFields($this->fieldsForDetail(), 'detail', $model);
    }

    /**
     * Get fields when creating.
     *
     * @return array
     */
    public function getCreatingFields()
    {
        return $this->filterFields($this->fieldsForCreate(), 'creating');
    }

    /**
     * Get fields when updating.
     *
     * @param Model $model
     * @return array
     */
    public function getUpdatingFields(Model $model)
    {
        return $this->filterFields($this->fieldsForUpdate(), 'updating', $model);
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
            $rules = $field->getRules();

            if ($rules) {
                if ($method == 'POST') {
                    $rules =  array_merge($rules, $field->getCreationRules());
                } else if ($method == 'PUT') {
                    $rules =  array_merge($rules, $field->getUpdateRules());
                }

                $validators[$field->getColumn()] = $rules;
            }
        }

        return $validators;
    }
}
