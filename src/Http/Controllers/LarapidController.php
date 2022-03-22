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
            $entity->getSearchableColumns(),
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
    public function create(Entity $entity)
    {
        return Inertia::render('Create', [
            'route' => $entity->route(null, 'store'),
            'fields' => $entity->getCreatingFieldsProps()
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
        $data = $request->all();
        $repo = new LarapidRepository($entity->model());
        $isRelation = $request->has('relatedId') && $request->has('relatedColumn');

        if ($isRelation) {
            $data = array_merge($data, [
                $request->relatedColumn => $request->relatedId
            ]);
        }

        $repo->store($data);

        if ($isRelation) {
            return redirect()->route('larapid.detail', [$request->relatedEntity, $request->relatedId]);
        }

        return redirect()->route('larapid.index', [$entity::slug()]);
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
            'relations' => $entity->getRelations($data)
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
            'route' => $entity->route($id, 'update')
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
        $repo->update($id, $request->all());

        return redirect()->route('larapid.edit', [$entity::slug(), $id]);
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
        $repo->destroy($id);

        return redirect()->route('larapid.index', [$entity::slug()]);
    }
}
