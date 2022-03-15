<?php

namespace Internexus\Larapid\Fields;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Internexus\Larapid\Facades\Larapid;

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
     * Media accept.
     *
     * @var int
     */
    protected $accept;

    /**
     * Media max size.
     *
     * @var int
     */
    protected $maxSize;

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
     * Set media accept.
     *
     * @param array $accept
     * @return self
     */
    public function accept(array $accept)
    {
        $this->accept = $accept;

        return $this;
    }

    /**
     * Set media max size.
     *
     * @param int $size
     * @return self
     */
    public function maxSize($size)
    {
        $this->maxSize = $size;

        return $this;
    }

    public function getAccept()
    {
        if ($this->accept) {
            return $this->accept;
        }

        return Larapid::getConfig('image_accept');
    }

    public function getMaxSize()
    {
        if ($this->maxSize) {
            return $this->maxSize;
        }

        return Larapid::getConfig('upload_maxsize');
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
            'accept' => $this->getAccept(),
            'maxSize' => $this->getmaxSize(),
            'mediaGroup' => $this->group,
            'previewUrl' => $this->getPreviewUrl(),
        ];
    }

    /**
     * Display image element.
     *
     * @param Model $model
     * @return string
     */
    public function displayImage(Model $model)
    {
        $this->defaultValue($model);

        return sprintf('<img src="%s" class="media-display" />', $this->getPreviewUrl());
    }

    /**
     * Display field value on detail.
     *
     * @param Model $model
     * @return string
     */
    public function displayOnDetail(Model $model)
    {
        return $this->displayImage($model);
    }

    /**
     * Display field value on index.
     *
     * @param Model $model
     * @return string
     */
    public function displayOnIndex(Model $model)
    {
        return $this->displayImage($model);
    }
}
