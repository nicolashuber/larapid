<?php

namespace Internexus\Larapid\Fields;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Media extends Field
{
    /**
     * Media group.
     *
     * @var string
     */
    protected $group = '';

    /**
     * Media relation.
     *
     * @var string
     */
    protected $relation;

    /**
     * Field component name.
     *
     * @var string
     */
    public static $component = 'media';

    /**
     * Construct a field.
     *
     * @param string $label
     * @param string $column
     * @param string $relation
     */
    public function __construct($label, $column = 'media_id', $relation = 'media')
    {
        parent::__construct($label, $column);

        $this->relation = $relation;
    }

    /**
     * Set media group.
     *
     * @param string $group
     * @return self
     */
    public function group($group)
    {
        $this->group = $group;

        return $this;
    }

    /**
     * Get media URL.
     *
     * @param string $path
     * @return string
     */
    protected function url($path)
    {
        if (Str::startsWith($path, 'http')) {
            return $path;
        }

        return Storage::url($path);
    }
    /**
     * Get media URL.
     *
     * @return string
     */
    protected function getPreviewUrl()
    {
        $value = $this->getValue();

        if ($value && $value->{$this->column}) {
            if (method_exists($value, $this->relation)) {
                $media = $value->{$this->relation};

                return $this->url($media->url);
            }
        }
    }

    /**
     * Get field options.
     *
     * @return array
     */
    public function getOptions()
    {
        return [
            'previewUrl' => $this->getPreviewUrl(),
            'mediaGroup' => $this->group
        ];
    }
}
