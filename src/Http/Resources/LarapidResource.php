<?php

namespace Internexus\Larapid\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LarapidResource extends JsonResource
{
    /**
     * The "data" wrapper that should be applied.
     *
     * @var string|null
     */
    public static $wrap = '';

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data = [];

        foreach ($request->entity->fields() as $field) {
            if ($field->isVisibleOn($request->id ? 'Detail' : 'Index')) {
                $data[$field->getColumn()] = $field->display($this->resource);
            }

            if (! $request->id) {
                $data['routes'] = [
                    'edit' => $request->entity->route($this->id, 'edit'),
                    'detail' => $request->entity->route($this->id, 'detail')
                ];
            }
        }

        return $data;
    }
}
