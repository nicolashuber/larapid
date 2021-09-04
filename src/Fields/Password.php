<?php

namespace Internexus\Larapid\Fields;

class Password extends Field
{
    /**
     * Field component name.
     *
     * @var string
     */
    public static $component = 'password';

    /**
     * Show field only on index.
     *
     * @var boolean
     */
    protected $showOnIndex = false;

    /**
     * Show field only on detail.
     *
     * @var boolean
     */
    protected $showOnDetail = false;
}

