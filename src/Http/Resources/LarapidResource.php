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
     * Get page verb from request.
     *
     * @param \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function page($request)
    {
        $route = $request->route()->getName();
        $parts = explode('.', $route);

        if (count($parts) > 1) {
            return ucfirst($parts[1]);
        }

        return null;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data = [];
        $page = $this->page($request);

        foreach ($request->entity->getColumns($page) as $field) {
            if ($field->isVisibleOn($page)) {
                $value = $field->displayOn($page, $this->resource);

                $data[$field->getColumn()] = $value;
            }

            if ($this->id) {
                $data['id'] = $this->id;

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
