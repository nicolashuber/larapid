<?php

namespace Internexus\Larapid\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaResource extends JsonResource
{
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
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'url' => $this->url($this->url),
            'name' => $this->name,
            'filesize' => $this->filesize,
        ];
    }
}
