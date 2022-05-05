<?php

namespace Internexus\Larapid\Query;

use Illuminate\Database\Eloquent\Builder;
use Internexus\Larapid\Query\Contracts\QueryContract;

class SearchableRelation implements QueryContract
{
    /**
     * The relation method name.
     *
     * @var string
     */
    protected $method;

    /**
     * The relation column name.
     *
     * @var string
     */
    protected $column;

    /**
     * Constructor.
     *
     * @param string $method
     * @param string $column
     */
    public function __construct($method, $column)
    {
        $this->method = $method;
        $this->column = $column;
    }

    /**
     * Run query.
     *
     * @param Builder $query
     * @param string $term
     * @return Builder
     */
    public function runQuery(Builder $query, $term)
    {
        return $query->orWhereHas($this->method, function($query) use ($term) {
            $query->where($this->column, 'LIKE', "%{$term}%");
        });
    }
}
