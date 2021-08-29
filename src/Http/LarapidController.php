<?php

namespace Internexus\Larapid\Http;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use Internexus\Larapid\Entities\Entity;
use Internexus\Larapid\Repos\LarapidRepository;

class LarapidController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Entity $entity)
    {
        $repo = new LarapidRepository($entity->model());

        return Inertia::render('Index', [
            'data' => $repo->list(),
            'headers' => $entity->headers(),
            'createRoute' => $entity->route(null, 'create')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($entity)
    {
        return Inertia::render('Create', [
            'route' => $entity->route(null, 'store'),
            'fields' => $entity->getFields()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Entity $entity
     * @param LarapidRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store($entity, LarapidRequest $request)
    {
        $repo = new LarapidRepository($entity->model());
        $repo->store($request->all());

        return redirect()->route("larapid.index", [$entity->slug()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Entity $entity
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($entity, $id)
    {
        $repo = new LarapidRepository($entity->model());
        $data = $repo->find($id);

        return Inertia::render('Edit', [
            'data' => $data,
            'fields' => $entity->getFields(),
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

        return redirect()->route("larapid.edit", [$entity->slug(), $id]);
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

        return redirect()->route("larapid.index", [$entity->slug()]);
    }
}
