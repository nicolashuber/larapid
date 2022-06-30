<?php

namespace Internexus\Larapid\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use Internexus\Larapid\Entities\Entity;
use Internexus\Larapid\Facades\Larapid;
use Internexus\Larapid\Http\Requests\LarapidRequest;
use Internexus\Larapid\Http\Resources\LarapidResource;
use Internexus\Larapid\Repos\LarapidRepository;

class LarapidController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Display the dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        return Inertia::render('Dashboard', [
            'metrics' => Larapid::dashboard()
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Entity $entity
     * @return \Illuminate\Http\Response
     */
    public function index(Entity $entity, Request $request)
    {
        $repo = new LarapidRepository($entity->model());
        $data = $repo->filter(
            $request->input('query'),
            $entity->searchableColumns(),
            $request->input('perPage', 25),
            $request->input('sort')
        );

        return Inertia::render('Index', [
            'data' => LarapidResource::collection($data),
            'headers' => $entity->getIndexColumns(),
            'createRoute' => $entity->enableCreating() ? $entity->route(null, 'create') : null
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Entity $entity
     * @return \Illuminate\Http\Response
     */
    public function create(Entity $entity, Request $request)
    {
        $route = $entity->route(null, 'index');

        if ($request->has('relatedId') && $request->has('relatedEntity')) {
            $route = route('larapid.detail', [$request->relatedEntity, $request->relatedId]);
        }

        return Inertia::render('Create', [
            'route' => $entity->route(null, 'store'),
            'fields' => $entity->getCreatingFieldsProps(),
            'backRoute' => $route,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Entity $entity
     * @param LarapidRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Entity $entity, LarapidRequest $request)
    {
        $data = $entity->beforeSaving($request->all());
        $repo = new LarapidRepository($entity->model());
        $isRelation = $request->has('relatedId') && $request->has('relatedColumn');

        if ($isRelation) {
            $data = array_merge($data, [
                $request->relatedColumn => $request->relatedId
            ]);
        }

        $model = $repo->store($data);
        $entity->afterCreated($model);

        $route = $entity->redirectAfterCreate($model);

        if ($isRelation) {
            return redirect($route ?? route('larapid.detail', [$request->relatedEntity, $request->relatedId]));
        }

        $route = $rotue ?? route('larapid.index', [$entity::slug()]);

        return redirect($route)->with('flash:type', 'success')
                               ->with('flash:message', trans('larapid.store'));
    }

    /**
     * Display the specified resource.
     *
     * @param Entity $entity
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function detail(Entity $entity, $id, Request $request)
    {
        $repo = new LarapidRepository($entity->model());
        $data = $repo->find($id);

        $resource = new LarapidResource($data);

        return Inertia::render('Detail', [
            'data' => $resource->toArray($request),
            'columns' => $entity->getDetailColumns(),
            'relations' => $entity->getRelations($data),
            'backRoute' => $entity->route(null, 'index')
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Entity $entity
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function attach(Entity $entity, $id, Request $request)
    {
        return Inertia::render('Attach', [
            'field' => [
                'name' => $request->relatedColumn,
                'entity' => $request->relatedEntity,
            ],
            'route' => $entity->route($id, 'attach'),
            'backRoute' => $entity->route($id, 'detail')
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Entity $entity
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function postAttach(Entity $entity, $id, Request $request)
    {
        $request->validate([
            'field' => 'required',
            'entity' => 'required',
            'entity_id' => 'required',
        ]);

        $related = Larapid::resolveEntity($request->entity . 'Entity');
        $repo = new LarapidRepository($related->model());

        $repo->update($request->entity_id, [
            $request->field => $id
        ]);

        $route = $entity->route($id, 'detail');

        return redirect($route)->with('flash:type', 'success')
                               ->with('flash:message', trans('larapid.attach'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Entity $entity
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function edit(Entity $entity, $id, Request $request)
    {
        $repo = new LarapidRepository($entity->model());
        $data = $repo->find($id);
        $goBack = $entity->route(null, 'index');

        $resource = new LarapidResource($data);

        if ($request->has('relatedId') && $request->has('relatedEntity')) {
            $goBack = route('larapid.detail', [$request->relatedEntity, $request->relatedId]);
        }

        return Inertia::render('Edit', [
            'data' => $resource->toArray($request),
            'fields' => $entity->getUpdatingFieldsProps($data),
            'route' => $entity->route($id, 'update'),
            'backRoute' => $goBack
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Entity $entity
     * @param int $id
     * @param LarapidRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update($entity, $id, LarapidRequest $request)
    {
        $repo = new LarapidRepository($entity->model());
        $data = $entity->beforeSaving($request->all());

        $model = $repo->update($id, $data);
        $entity->afterUpdated($model);
        $route = $entity->redirectAfterUpdate($model) ?? route('larapid.edit', [$entity::slug(), $id]);

        return redirect($route)->with('flash:type', 'success')
                               ->with('flash:message', trans('larapid.update'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Entity $entity
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($entity, $id)
    {
        $repo = new LarapidRepository($entity->model());
        $model = $repo->find($id);

        $entity->beforeDestroy($model);

        try {
            $repo->destroy($id);
        } catch (ModelNotFoundException $e) {
            // Do nothing if the model has already been deleted
        }

        $entity->afterDestroy($model);

        $route = $entity->redirectAfterDelete($model) ?? route('larapid.index', [$entity::slug()]);

        return redirect($route)->with('flash:type', 'success')
                               ->with('flash:message', trans('larapid.destroy'));
    }
}
