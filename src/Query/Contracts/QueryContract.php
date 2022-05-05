<?php

namespace Internexus\Larapid\Query\Contracts;

use Illuminate\Database\Eloquent\Builder;

interface QueryContract
{
    /**
     * Run query.
     *
     * @param Builder $query
     * @param string $term
     * @return Builder
     */
    public function runQuery(Builder $query, $term);
}
