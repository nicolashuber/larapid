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
            $page = $request->id ? 'Detail' : 'Index';

            if ($field->isVisibleOn($page)) {
                if ($page === 'Index') {
                    $value = $field->displayOnIndex($this->resource);
                } else {
                    $value = $field->display($this->resource);
                }

                $data[$field->getColumn()] = $value;
            }

            if ($this->id) {
                $data['routes'] = [
                    'edit' => $request->entity->route($this->id, 'edit'),
                    'detail' => $request->entity->route($this->id, 'detail'),
                    'destroy' => $request->entity->route($this->id, 'destroy'),
                ];
            }
        }

        return $data;
    }
}
