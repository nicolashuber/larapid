<?php

namespace Internexus\Larapid\Entities;

use Illuminate\Database\Eloquent\Model;
use Internexus\Larapid\Fields\HasMany;

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
    public static $group = '';

    /**
     * Parent entity.
     *
     * @param Entity
     */
    public static $parentEntity;

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
    public function fieldsForCreating()
    {
        return [];
    }

    /**
     * Define entity fields for update.
     *
     * @return array
     */
    public function fieldsForUpdating()
    {
        return [];
    }

    /**
     * Get route URL.
     *
     * @param int|null $id
     * @param string $action
     * @return string|null
     */
    public function route($id = null, $action = 'index')
    {
        $requiredId = in_array($action, ['update', 'edit', 'destroy', 'detail', 'attach']);

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
     * Enables edit an entity
     *
     * @return boolean
     */
    public function enableEditing(Model $model)
    {
        return true;
    }

    /**
     * Enables viewing details of an entity
     *
     * @return boolean
     */
    public function enableDetail(Model $model)
    {
        return true;
    }

    /**
     * Enables delete an entity
     *
     * @return boolean
     */
    public function enableDeleting(Model $model)
    {
        return true;
    }

    /**
     * Hook before saving a record.
     *
     * @param array $data
     * @return array
     */
    public function beforeSaving($data)
    {
        return $data;
    }

    /**
     * Hook after created a record.
     *
     * @param Model $model
     * @return void
     */
    public function afterCreated(Model $model)
    {
        //
    }

    /**
     * Hook after updated a record.
     *
     * @param Model $model
     * @return void
     */
    public function afterUpdated(Model $model)
    {
        //
    }

    /**
     * Hook before destroy a record.
     *
     * @param Model $model
     * @return void
     */
    public function beforeDestroy(Model $model)
    {
        //
    }

    /**
     * Hook after destroy a record.
     *
     * @param Model $model
     * @return void
     */
    public function afterDestroy(Model $model)
    {
        //
    }

    /**
     * Enables action on entity.
     *
     * @param string $action
     * @param Model $model
     * @return boolean
     */
    public function enableAction($action, Model $resource)
    {
        $method = 'enable' . $this->getPageMethod($action);

        if (method_exists($this, $method)) {
            return $this->$method($resource);
        }

        return true;
    }

    /**
     * Get columns for page.
     *
     * @param string $page
     * @return array
     */
    public function getColumns($page)
    {
        $method = 'fieldsFor' . $this->getPageMethod($page);
        $fields = $this->$method();

        if (count($fields) == 0) {
            return $this->fields();
        }

        return $fields;
    }

    /**
     * Get entity columnns for index.
     *
     * @return array
     */
    public function getIndexColumns()
    {
        $headers = [];

        foreach ($this->getColumns('index') as $field) {
            if ($field->isVisibleOnIndex()) {
                $headers[$field->getColumn()] = [
                    'label' => $field->getLabel(),
                    'column' => $field->getColumn(),
                    'sortable' => $field->isSortable()
                ];
            }
        }

        return $headers;
    }

    /**
     * Get entity columnns for detail.
     *
     * @return array
     */
    public function getDetailColumns()
    {
        $headers = [];

        foreach ($this->getColumns('detail') as $field) {
            if ($field->isVisibleOnDetail()) {
                $headers[$field->getColumn()] = $field->getLabel();
            }
        }

        return $headers;
    }

    /**
     * Get fields for page.
     *
     * @param string $page
     * @return array
     */
    private function getFields($page)
    {
        $data = [];

        foreach ($this->getFieldsForPage($page) as $field) {
            $column = $field->getColumn();

            if ($field->isVisibleOn($page)) {
                $data[$column] = $field;
            }
        }

        return $data;
    }

    /**
     * Get page method.
     *
     * @param string $page
     * @return string
     */
    public function getPageMethod($page)
    {
        $replace = [
            'index' => 'Index',
            'detail' => 'Detail',
            'edit' => 'Updating',
            'create' => 'Creating',
            'destroy' => 'Deleting'
        ];

        return str_replace(
            array_keys($replace),
            array_values($replace),
            $page
        );
    }

    /**
     * Get fields for specified page.
     *
     * @param string $page
     * @return array
     */
    private function getFieldsForPage($page)
    {
        $fields = [];
        $fieldsMethod = 'fieldsFor' . ucfirst($page);

        if (method_exists($this, $fieldsMethod)) {
            $fields = $this->{$fieldsMethod}();
        }

        return count($fields) > 0 ? $fields : $this->fields();
    }

    /**
     * Get fields for index.
     *
     * @return array
     */
    public function getIndexFields()
    {
        return $this->getFields('index');
    }

    /**
     * Get fields for detail.
     *
     * @return array
     */
    public function getDetailFields()
    {
        return $this->getFields('detail');
    }

    /**
     * Get fields when creating.
     *
     * @return array
     */
    public function getCreatingFields()
    {
        return $this->getFields('creating');
    }

    /**
     * Get fields when updating.
     *
     * @return array
     */
    public function getUpdatingFields()
    {
        return $this->getFields('updating');
    }

    /**
     * Get fields props.
     *
     * @param string $page
     * @param Model $model
     * @return array
     */
    public function getFieldsProps($page, Model $model = null)
    {
        $data = [];

        foreach ($this->getFields($page) as $column => $field) {
            if ($model) {
                $field->defaultValue($model);
            }

            $data[$column] = $field->getProps();
        }

        return $data;
    }

    /**
     * Get fields when creating.
     *
     * @return array
     */
    public function getCreatingFieldsProps()
    {
        return $this->getFieldsProps('creating');
    }

    /**
     * Get fields when updating.
     *
     * @param Model $model
     * @return array
     */
    public function getUpdatingFieldsProps(Model $model)
    {
        return $this->getFieldsProps('updating', $model);
    }

    /**
     * Get searchable columns.
     *
     * @return array
     */
    public function searchableColumns()
    {
        $fields = [];

        foreach ($this->getFieldsForPage('index') as $field) {
            if ($field->isSearchable()) {
                $fields[] = $field->getColumn();
            }
        }

        return $fields;
    }

    /**
     * Get sortable columns.
     *
     * @return array
     */
    public function getSortableColumns()
    {
        $fields = [];

        foreach ($this->getFieldsForPage('index') as $field) {
            if ($field->isSortable()) {
                $fields[] = $field->getColumn();
            }
        }

        return $fields;
    }

    /**
     * Get entity relations.
     *
     * @param Model $model
     * @return array
     */
    public function getRelations(Model $model)
    {
        $fields = [];
        $relationable = [HasMany::class];

        foreach ($this->fields() as $field) {
            if (in_array(get_class($field), $relationable)) {
                $fields[] = $field->getResource($model);
            }
        }

        return $fields;
    }

    /**
     * Redirect after create an entity.
     *
     * @param Model $model
     * @return string|null
     */
    public function redirectAfterCreate(Model $model)
    {
        //
    }

    /**
     * Redirect after update an entity.
     *
     * @param Model $model
     * @return string|null
     */
    public function redirectAfterUpdate(Model $model)
    {
        //
    }

    /**
     * Redirect after update an entity.
     *
     * @param Model $model
     * @return string|null
     */
    public function redirectAfterDelete(Model $model)
    {
        //
    }

    /**
     * Get entity title for relation option.
     *
     * @param Model $model
     * @return mixed
     */
    public function title(Model $model)
    {
        $column = self::$titleColumn;

        return $model->$column;
    }
}
