<?php

namespace Internexus\Larapid\Http;

use Internexus\Larapid\Entities\Entity;
use Internexus\Larapid\Repos\LarapidRepository;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;

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

        return view('larapid::index', [
            'items' => $repo->list(),
            'entity' => $entity,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($entity)
    {
        return view('larapid::create', [
            'route' => $entity->route(null, 'store'),
            'fields' => $entity->renderForm(),
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
        $item = $repo->find($id);

        return view('larapid::edit', [
            'item' => $item,
            'route' => $entity->route($id, 'update'),
            'fields' => $entity->renderForm($item),
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
