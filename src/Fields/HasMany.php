<?php

namespace Internexus\Larapid\Fields;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Internexus\Larapid\Facades\Larapid;
use Internexus\Larapid\Http\Resources\LarapidResource;

class HasMany extends Field
{
    /**
     * Field component name.
     *
     * @var string
     */
    public static $component = 'has-many';

    /**
     * Show field only on index.
     *
     * @var boolean
     */
    protected $showOnIndex = false;

    /**
     * Show field only on creating.
     *
     * @var boolean
     */
    protected $showOnCreating = false;

    /**
     * Show field only on updating.
     *
     * @var boolean
     */
    protected $showOnUpdating = false;

    /**
     * Show field only on detail.
     *
     * @var boolean
     */
    protected $showOnDetail = false;

    /**
     * Get field options.
     *
     * @return mixed
     */
    public function getRelation(Model $model)
    {
        $data = [];
        $method = lcfirst($this->label);
        $entity = Larapid::guestEntity(Str::of($method)->singular());

        if (isset($model->{$method})) {
            $data = $model->{$method}()->paginate();
        }

        $request = request();
        $request->entity = $entity;

        LarapidResource::collection($data);

        return [
            'data' => $data,
            'title' => $entity::$title,
            'columns' => $entity->getIndexColumns(),
            'fields' => $entity->getCreatingFieldsProps()
        ];
    }

}

