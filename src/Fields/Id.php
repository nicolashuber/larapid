<?php

namespace Internexus\Larapid\Fields;

class Id extends Field
{
    /**
     * Field component name.
     *
     * @var string
     */
    public static $component = 'id';

    /**
     * Show field only on index.
     *
     * @var boolean
     */
    protected $showOnIndex = true;

    /**
     * Show field only on detail.
     *
     * @var boolean
     */
    protected $showOnDetail = true;

    /**
     * Show field only on creating.
     *
     * @var boolean
     */
    protected $showOnCreating = false;

    /**
     * Show field only on updating.
     *
     * @var boolean
     */
    protected $showOnUpdating = false;

    /**
     * Field is sortable.
     *
     * @var boolean
     */
    protected $sortable = true;

    /**
     * Construct a field.
     *
     * @param string $label
     * @param string $column
     */
    public function __construct($label = 'ID', $column = 'id')
    {
        parent::__construct($label, $column);
    }
}
