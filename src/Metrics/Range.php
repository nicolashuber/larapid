<?php

namespace Internexus\Larapid\Metrics;

class Range extends Metric
{
    /**
     * Metric range in days.
     *
     * @var int
     */
    public $range = 7;

    /**
     * Execute the query and count results.
     *
     * @throws InvalidArgumentException
     * @return int
     */
    protected function count(callable $queryCb = null)
    {
        $end = now();
        $start = now()->subDays($this->range);

        $query = $this->getQuery()->whereBetween('created_at', [$start, $end]);

        if ($queryCb) {
            $query = call_user_func($queryCb, $query);
        }

        return $query->count();
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
            'range' => $this->range,
            'value' => $this->calculate(),
        ];
    }
}
