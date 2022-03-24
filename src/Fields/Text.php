<?php

namespace Internexus\Larapid\Fields;

class Text extends Field
{
    /**
     * Field mask.
     *
     * @var string|array
     */
    protected $mask;

    /**
     * Field component name.
     *
     * @var string
     */
    public static $component = 'text';

    /**
     * Set field mask.
     *
     * @param string|array $mask
     * @return self
     */
    public function mask($mask)
    {
        $this->mask = $mask;

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
            'mask' => $this->mask
        ];
    }
}

