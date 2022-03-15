<?php

namespace Internexus\Larapid\Services\Media;

use Internexus\Larapid\Models\Media;
use Internexus\Larapid\Models\MediaGroup;
use Internexus\Larapid\Services\Media\Contracts\ImageProcessServiceContract;
use Internexus\Larapid\Services\Media\Contracts\MediaServiceContract;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaService implements MediaServiceContract
{
    /**
     * Media configuration
     *
     * @var array
     */
    protected $config;

    /**
     * Media model instance
     *
     * @var Media
     */
    protected $media;

    /**
     * Media group model instance
     *
     * @var Group
     */
    protected $group;

    /**
     * Media process ID
     *
     * @var string
     */
    protected $processId;

    /**
     * Image process service instance.
     *
     * @var ImageProcessServiceContract
     */
    protected $imageProcess;

    /**
     * Constructor.
     *
     * @param array $config
     * @param Media $media
     * @param MediaGroup $group
     * @param ImageProcessServiceContract $imageProcess
     */
    public function __construct(array $config, Media $media, MediaGroup $group, ImageProcessServiceContract $imageProcess)
    {
        $this->config = $config;
        $this->media = $media;
        $this->group = $group;
        $this->processId = '_' . Str::random(5) . '_';
        $this->imageProcess = $imageProcess;
    }

    /**
     * Gerinic file upload.
     *
     * @param UploadedFile $file
     * @param MediaGroup $mediaGroup
     * @throws \Exception
     * @return Media
     */
    public function upload(UploadedFile $file, MediaGroup $mediaGroup = null)
    {
        $mimeType = $file->getMimeType();

        if (Str::startsWith($mimeType, 'image/svg+xml')) {
            return $this->uploadFile($file, $mediaGroup);
        }

        if (Str::startsWith($mimeType, 'image/')) {
            if (! $mediaGroup) {
                return $this->uploadImage($file);
            }

            return $this->uploadImageAndResize($file, $mediaGroup);
        }

        return $this->uploadFile($file, $mediaGroup);
    }

    /**
     * File upload.
     *
     * @param UploadedFile $file
     * @param MediaGroup $mediaGroup
     * @throws \Exception
     */
    protected function uploadFile(UploadedFile $file, MediaGroup $mediaGroup = null)
    {
        $slug = $mediaGroup ? $mediaGroup->slug : 'general';
        $path = $file->store(
            $this->getPathname($file, $slug)
        );

        return $this->media->create([
            'url' => $path,
            'name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'filesize' => Storage::size($path),
        ]);
    }

    /**
     * Get image data.
     *
     * @param UploadedFile $file
     * @param MediaGroup $mediaGroup
     * @return array
     */
    protected function getImageData(UploadedFile $file, MediaGroup $mediaGroup = null)
    {
        $slug = $mediaGroup ? $mediaGroup->slug : 'general';

        $pathname = $this->getPathname($file, $slug);
        $original = $this->imageProcess->make($file->path());

        return [
            'url' => $this->saveToStorage($pathname, $original->stream()),
            'name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'width' => $original->width(),
            'height' => $original->height(),
            'filesize' => $original->filesize(),
        ];
    }

    /**
     * Upload a image.
     *
     * @param UploadedFile $file
     * @return Media
     */
    protected function uploadImage(UploadedFile $file)
    {
        return $this->media->create($this->getImageData($file));
    }

    /**
     * Image upload and resize.
     *
     * @param UploadedFile $file
     * @param MediaGroup $mediaGroup
     * @throws \Exception
     * @return Media
     */
    protected function uploadImageAndResize(UploadedFile $file, MediaGroup $mediaGroup)
    {
        $media = $mediaGroup->media()->create($this->getImageData($file, $mediaGroup));

        $encode = $this->config['image_encode'];
        $quality = $this->config['image_quality'];

        foreach ($mediaGroup->sizes as $size) {
            $resized = $this->imageProcess->resize($file->path(), $size->width, $size->height);
            $resizedPathname = $this->getPathname($file, $mediaGroup->slug, "{$size->width}x{$size->height}");

            $url = $this->saveToStorage($resizedPathname, $resized->encode($encode, $quality));

            $media->resizes()->create([
                'url' => $url,
                'width' => $resized->width(),
                'height' => $resized->height(),
                'size_id' => $size->id,
            ]);
        }

        return $media;
    }

    /**
     * Save file to Storage.
     *
     * @param string $pathname
     * @param string $content
     * @return string
     */
    protected function saveToStorage($pathname, $content)
    {
        Storage::put($pathname, $content);

        return $pathname;
    }

    /**
     * Get file path name.
     *
     * @param UploadedFile $file
     * @param string $directory
     * @param string $dimension
     * @return string
     */
    protected function getPathname($file, $directory = '', $dimension = '')
    {
        $now = now();
        $filename = $file->getClientOriginalName();
        $year = $now->format('Y');
        $month = $now->format('m');
        $extension = $file->getClientOriginalExtension();
        $name = Str::slug(str_replace($extension, '', $filename)) . $this->processId . ".{$extension}";

        if ($dimension) {
            $name = str_replace(".{$extension}", '', $name) . "_{$dimension}.{$extension}";
        }

        return rtrim("{$directory}/${year}/{$month}/$name", '/');
    }

    /**
     * Destroy and delete all resized files.
     *
     * @param int $mediaId
     * @return void
     */
    public function destroy(int $mediaId)
    {
        $media = $this->media->with('resizes')->findOrFail($mediaId);

        $files = $media->resizes->filter(function ($item) {
            return ! Str::startsWith($item->url, 'http');
        })->pluck('url');

        if (! Str::startsWith($media->url, 'http')) {
            $files->add($media->url);
        }

        if ($files->count() > 0) {
            Storage::delete($files->all());
        }

        $media->delete();
    }
}
