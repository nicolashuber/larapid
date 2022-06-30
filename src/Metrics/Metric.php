<?php

namespace Internexus\Larapid\Metrics;

use InvalidArgumentException;

abstract class Metric
{
    /**
     * Metric title.
     *
     * @var string
     */
    public $title;

    /**
     * Metric model.
     *
     * @var \Illuminate\Database\Eloquent\Model;
     */
    public $model;

    /**
     * Instantiate a metric.
     *
     * @param mixed $arguments
     * @return self
     */
    public static function make(...$arguments)
    {
        return new static(...$arguments);
    }

    /**
     * Get the model query builder.
     *
     * @throws InvalidArgumentException
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function getQuery()
    {
        if (! method_exists($this->model, 'query')) {
            throw new InvalidArgumentException('Invalid Laravel Model ' . $this->model);
        }

        return $this->model::query();
    }

    /**
     * Execute the query and count results.
     *
     * @throws InvalidArgumentException
     * @return int
     */
    protected function count(callable $queryCb = null)
    {
        $query = $this->getQuery();

        if ($queryCb) {
            $query = call_user_func($queryCb, $query);
        }

        return $query->count();
    }

    /**
     * Execute the query and get count results.
     *
     * @throws InvalidArgumentException
     * @return int
     */
    public function calculate()
    {
        return $this->count();
    }

    /**
     * Get metric data to display.
     *
     * @throws InvalidArgumentException
     * @return array
     */
    public function display()
    {
        return [
            'title' => $this->title,
            'value' => $this->calculate(),
        ];
    }
}
