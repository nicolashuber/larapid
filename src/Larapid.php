<?php

namespace Internexus\Larapid;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;
use Internexus\Larapid\Entities\Entity;

class Larapid
{
    /**
     * Default configuration.
     *
     * @var array
     */
    const DEFAULT_CONFIG = [
        'currency' => 'BRL',
        'currency_symbol' => 'R$',
        'date_mask' => '##/##/####',
        'date_format' => 'd/m/Y',
        'datetime_mask' => '##/##/#### ##:##',
        'datetime_format' => 'd/m/Y H:i',
        'bool_true' => 'Sim',
        'bool_false' => 'Não',
    ];

    /**
     * Application entities.
     *
     * @var array
     */
    private $entities = [];

    /**
     * Constructor.
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = array_merge(self::DEFAULT_CONFIG, $config);
    }

    /**
     * Get config value by name.
     *
     * @param string $name
     * @return mixed
     */
    public function getConfig($name)
    {
        return $this->config[$name] ?? null;
    }

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
    public function resolveEntity($className)
    {
        $className = strtolower($className);

        foreach ($this->entities as $entity) {
            if (Str::endsWith(strtolower($entity), $className)) {
                $instance = new $entity();

                if ($instance instanceof Entity) {
                    return $instance;
                }
            }
        }

        throw new ModelNotFoundException;
    }

    public function guestEntity($entitySlug)
    {
        return $this->resolveEntity(
            ucfirst($entitySlug) . 'Entity'
        );
    }

    /**
     * Get entities menu items.
     *
     * @return array
     */
    public function menu()
    {
        $items = [];

        foreach ($this->entities as $entity) {
            if ($entity::$displayInNavigation) {
                $item = [
                    'route' => route('larapid.index', [$entity::slug()]),
                    'label' => $entity::$title
                ];

                if ($entity::$group) {
                    $items[$entity::$group]['subMenu'][] = $item;
                } else {
                    $items[$entity::$title] = $item;
                }
            }
        }

        return $items;
    }
}
