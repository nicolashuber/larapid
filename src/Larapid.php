<?php

namespace Internexus\Larapid;

use Illuminate\Support\Str;
use Internexus\Larapid\Entities\Entity;
use Internexus\Larapid\Exceptions\EntityNotFoundException;
use Internexus\Larapid\Metrics\Metric;

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
        'upload_maxsize' => 16777216,
        'image_driver' => 'gd',
        'image_encode' => 'jpg',
        'image_quality' => 80,
        'image_accept' => ['jpg', 'png', 'svg'],
        'powered_by_url' => null,
        'powered_by_name' => 'Larapid',
    ];

    /**
     * Application entities.
     *
     * @var array
     */
    private $entities = [];

    /**
     * Application metrics.
     *
     * @var array
     */
    private $metrics = [];

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
     * Set application metrics.
     *
     * @param array $metrics
     * @return void
     */
    public function metrics(array $metrics)
    {
        $this->metrics = $metrics;
    }

    /**
     * Resolve route bind.
     *
     * @param string $entitySlug
     * @throws EntityNotFoundException
     * @return Entity
     */
    public function resolveEntity($className)
    {
        $namespace = strtolower($className);

        foreach ($this->entities as $entity) {
            if (Str::endsWith(strtolower($entity), $namespace)) {
                $instance = new $entity();

                if ($instance instanceof Entity) {
                    return $instance;
                }
            }
        }

        throw new EntityNotFoundException($className);
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
        $request = request();

        $items = [[
            'route' => route('larapid.dash'),
            'label' => 'Dashboard',
            'active' => $request->route()->getName() == 'larapid.dash',
        ]];

        foreach ($this->entities as $entity) {
            if ($entity::$displayInNavigation) {
                $route = route('larapid.index', [$entity::slug()]);
                $current = $request->entity;

                $item = [
                    'route' => $route,
                    'label' => $entity::$title,
                    'active' => $current && is_object($current) ? get_class($current) == $entity : false,
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

    /**
     * Get dashboard metrics.
     *
     * @return array
     */
    public function dashboard()
    {
        $data = [];

        foreach ($this->metrics as $metric) {
            if (method_exists($metric, 'make')) {
                $instance = $metric::make();

                if ($instance instanceof Metric) {
                    $data[] = $instance->display();
                }
            }
        }

        return $data;
    }
}
