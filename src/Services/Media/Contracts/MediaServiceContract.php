<?php

namespace Internexus\Larapid\Services\Media\Contracts;

use Internexus\Larapid\Models\MediaGroup;
use Internexus\Larapid\Models\Media;
use Illuminate\Http\UploadedFile;

interface MediaServiceContract
{
    /**
     * Gerinic file upload.
     *
     * @param UploadedFile $file
     * @param MediaGroup $mediaGroup
     * @throws \Exception
     * @return Media
     */
    public function upload(UploadedFile $file, MediaGroup $mediaGroup = null);

    /**
     * Destroy and delete all resized files.
     *
     * @param int $mediaId
     * @return void
     */
    public function destroy(int $mediaId);
}
