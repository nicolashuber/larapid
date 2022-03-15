<?php

namespace Internexus\Larapid\Services\Media;

use Internexus\Larapid\Services\Media\Contracts\ImageProcessServiceContract;
use Intervention\Image\ImageManager;

class ImageProcessService implements ImageProcessServiceContract
{
    /**
     * Intervention Image Manager.
     *
     * @var ImageManager
     */
    protected $image;

    /**
     * Constructor.
     *
     * @param ImageManager $image
     */
    public function __construct(ImageManager $image)
    {
        $this->image = $image;
    }

    /**
     * Create Intervention Image instance.
     *
     * @return \Intervention\Image\Image
     */
    public function make(string $path)
    {
        return $this->image->make($path);
    }

    /**
     * Resize original image.
     *
     * @param string $path
     * @param int $width
     * @param int $height
     * @return \Intervention\Image\Image
     */
    public function resize(string $path, ?int $width, ?int $height, $aspectRatio = true)
    {
        $original = $this->make($path);

        return $original->resize($width, $height, function ($constraint) use ($aspectRatio) {
            if ($aspectRatio) {
                $constraint->aspectRatio();
            }
        });
    }
}
