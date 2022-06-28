<?php

namespace Internexus\Larapid\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Internexus\Larapid\Entities\Entity;

class DataController extends Controller
{
    public function search(Entity $entity, Request $request)
    {
        $query = $request->input('query');

        return $entity::$model::where($entity::$titleColumn, 'LIKE', "%$query%")->paginate(8)->mapWithKeys(function($item) use ($entity) {
            return [$item->id => $entity->title($item)];
        });
    }
}
