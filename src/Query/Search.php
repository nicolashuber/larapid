<?php

namespace Internexus\Larapid\Query;

use Illuminate\Database\Eloquent\Builder;
use Internexus\Larapid\Query\Contracts\QueryContract;

class Search implements QueryContract
{
    /**
     * Sort by.
     *
     * @var string
     */
    protected $sortBy;

    /**
     * Searchable fields.
     *
     * @var array
     */
    protected $searchableFields;

    /**
     * Constructor.
     *
     * @param array $searchableFields
     * @param string $sortBy
     */
    public function __construct(array $searchableFields, $sortBy)
    {
        $this->sortBy = $sortBy;
        $this->searchableFields = $searchableFields;
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
        $newQuery = $query;

        if (! empty($term)) {
            foreach ($this->searchableFields as $field) {
                if ($field instanceof QueryContract) {
                    $newQuery = $field->runQuery($newQuery, $term);
                } else {
                    $newQuery = $newQuery->orWhere($field, 'LIKE', "%{$term}%");
                }
            }
        }

        if ($this->sortBy) {
            list($order, $field) = explode(':', $this->sortBy);

            $newQuery = $newQuery->orderBy($field, $order);
        } else {
            $newQuery = $newQuery->orderBy('id', 'desc');
        }

        return $newQuery;
    }
}
