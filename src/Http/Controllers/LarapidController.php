<?php

namespace Internexus\Larapid\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use Internexus\Larapid\Entities\Entity;
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
        return Inertia::render('Dashboard');
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
            'createRoute' => $entity->route(null, 'create')
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

        $resource = new LarapidResource($data);

        return Inertia::render('Edit', [
            'data' => $resource->toArray($request),
            'fields' => $entity->getUpdatingFieldsProps($data),
            'route' => $entity->route($id, 'update'),
            'backRoute' => $entity->route(null, 'index')
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
        $repo->destroy($id);
        $entity->afterDestroy($model);

        $route = $entity->redirectAfterDelete($model) ?? route('larapid.index', [$entity::slug()]);

        return redirect($route)->with('flash:type', 'success')
                               ->with('flash:message', trans('larapid.destroy'));
    }
}
