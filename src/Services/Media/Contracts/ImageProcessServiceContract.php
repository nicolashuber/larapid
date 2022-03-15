<?php

namespace Internexus\Larapid\Services\Media\Contracts;

interface ImageProcessServiceContract
{
    /**
     * Create Intervention Image instance.
     *
     * @return \Intervention\Image\Image
     */
    public function make(string $path);

    /**
     * Resize original image.
     *
     * @param string $path
     * @param int $width
     * @param int $height
     * @return \Intervention\Image\Image
     */
    public function resize(string $path, int $width, int $height);
}
