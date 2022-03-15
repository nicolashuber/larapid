<?php

namespace Internexus\Larapid\Http\Controllers;

use Illuminate\Routing\Controller;
use Internexus\Larapid\Http\Requests\MediaRequest;
use Internexus\Larapid\Http\Resources\MediaResource;
use Internexus\Larapid\Models\MediaGroup;
use Internexus\Larapid\Services\Media\Contracts\MediaServiceContract;

class MediaController extends Controller
{
    public function store(MediaServiceContract $mediaService, MediaRequest $request, MediaGroup $mediaGroup = null)
    {
        return new MediaResource(
            $mediaService->upload($request->file, $mediaGroup)
        );
    }
}
