<?php

namespace Internexus\Larapid\Fields;

use Internexus\Larapid\Entities\Entity;
use Internexus\Larapid\Facades\Larapid;

abstract class Relational extends Field
{
    /**
     * The relation entity.
     *
     * @var string
     */
    protected $entity;

    /**
     * The relation method.
     *
     * @var string
     */
    protected $method;

    /**
     * Construct a field.
     *
     * @param string $label
     * @param string $column
     * @param string $entity
     * @param string $method
     */
    public function __construct($label, $column, $entity = null, $method = null)
    {
        parent::__construct($label, $column);

        $this->entity = $entity;
        $this->method = $method;
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

        return Str::snake(Str::lower($this->label)) . '_id';
    }

    /**
     * Resolve relation entity
     *
     * @return Entity
     */
    public function resolveRelationEntity()
    {
        if ($this->entity) {
            return Larapid::resolveEntity($this->entity);
        }

        return Larapid::guestEntity($this->guestRelationMethod());
    }

    /**
     * Guest method name for relation.
     *
     * @return string
     */
    public function guestRelationMethod()
    {
        return str_replace('_id', '', $this->getColumn());
    }
}
