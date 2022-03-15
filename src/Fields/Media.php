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
     * Media accept extensions.
     *
     * @var array
     */
    protected $accept;

    /**
     * Media min width.
     *
     * @var int
     */
    protected $minWidth;

    /**
     * Media min height.
     *
     * @var int
     */
    protected $minHeight;

    /**
     * Media max width.
     *
     * @var int
     */
    protected $maxWidth;

    /**
     * Media max height.
     *
     * @var int
     */
    protected $maxHeight;

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
     * Set minimum image dimensions.
     *
     * @param int $width
     * @param int $height
     * @return self
     */
    public function minDimension(int $width, int $height)
    {
        $this->minWidth = $width;
        $this->minHeight = $height;

        return $this;
    }

    /**
     * Set maximum image dimensions.
     *
     * @param int $width
     * @param int $height
     * @return self
     */
    public function maxDimension(int $width, int $height)
    {
        $this->maxWidth = $width;
        $this->maxHeight = $height;

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

    /**
     * Get image accept mimes.
     *
     * @return array;
     */
    public function getAccept()
    {
        if ($this->accept) {
            return $this->accept;
        }

        return Larapid::getConfig('image_accept');
    }

    /**
     * Get max upload size.
     *
     * @return int
     */
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
            'mimes' => $this->getAccept(),
            'dimensions' => [
                'minWidth' => $this->minWidth,
                'minHeight' => $this->minHeight,
                'maxWidth' => $this->maxWidth,
                'maxHeight' => $this->maxHeight,
            ],
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

        $url = $this->getPreviewUrl();

        return sprintf('<img src="%s" class="media-display" />', $url ?? asset('vendor/larapid/img/placeholder.png'));
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
