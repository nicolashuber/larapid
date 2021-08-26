<?php

namespace App\Larapid;

use App\Larapid\Entities\Entity;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use ReflectionClass;

class Larapid
{
    /**
     * Application entities.
     *
     * @var array
     */
    private $entities = [];

    /**
     * Set application entities.
     *
     * @param array $entities
     * @return void
     */
    public function entities(array $entities)
    {
        $this->entities = $entities;
    }

    /**
     * Resolve route bind.
     *
     * @param string $entitySlug
     * @throws ModelNotFoundException
     * @return Entity
     */
    public function resolveEntity($entitySlug)
    {
        $className = ucfirst($entitySlug) . 'Entity';

        foreach ($this->entities as $entity) {
            $reflect = new ReflectionClass($entity);

            if ($reflect->getShortName() == $className) {
                $instance = new $entity();

                if ($instance instanceof Entity) {
                    return $instance;
                }
            }
        }

        throw new ModelNotFoundException;
    }
}
