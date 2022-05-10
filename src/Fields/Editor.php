<?php

namespace Internexus\Larapid\Fields;

class Editor extends Field
{
    /**
     * Field component name.
     *
     * @var string
     */
    public static $component = 'editor';

    /**
     * Set editor as simple toolbar.
     *
     * @var bool
     */
    protected $simpleToolbar = false;

    /**
     * Set editor as simple toolbar.
     *
     * @return self
     */
    public function simpleToolbar()
    {
        $this->simpleToolbar = true;

        return $this;
    }

    /**
     * Get field options.
     *
     * @return array
     */
    public function getOptions()
    {
        return [
            'simpleToolbar' => $this->simpleToolbar,
        ];
    }
}

