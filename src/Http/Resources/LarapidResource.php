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
            return $parts[1];
        }

        return null;
    }

    /**
     * Get routes.
     *
     * @param mixed $primaryKey
     * @param Entity $entity
     * @return array
     */
    protected function routes($primaryKey, $request)
    {
        $routes = [];
        $entity = $request->entity;
        $actions = ['edit', 'detail', 'destroy'];

        foreach ($actions as $action) {
            $route = $entity->route($primaryKey, $action);

            if ($entity->enableAction($action, $this->resource) && $route) {
                if ($entity::$parentEntity) {
                    $route .= "?relatedId={$request->id}&relatedEntity={$entity::$parentEntity::slug()}";
                }

                $routes[$action] = $route;
            }
        }

        return $routes;
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
        $page = $request->entity->getPageMethod($this->page($request));

        foreach ($request->entity->getColumns($page) as $field) {
            if ($field->isVisibleOn($page)) {
                $value = $field->displayOn($page, $this->resource);

                $data[$field->getColumn()] = $value;
            }

            $id = $this->id;

            if ($request->entity::$parentEntity && $this->pivot) {
                $id = $this->pivot->id;
            }

            if ($id) {
                $data['id'] = $id;

                $data['larapid'] = [
                    'routes' => $this->routes($id, $request),
                ];
            }
        }

        return $data;
    }
}
