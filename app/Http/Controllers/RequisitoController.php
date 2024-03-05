<?php

namespace App\Http\Controllers;

use App\Http\Requests\Requisito\RequisitoRequest;
use App\Http\Resources\Requisito\RequisitoResource;
use App\Services\Requisito\CreateRequisitoService;
use App\Services\Requisito\ListRequisitoService;
use App\Services\Requisito\ShowRequisitoService;
use App\Http\Response\Response;
use App\Services\Requisito\DeleteRequisitoService;
use App\Services\Requisito\UpdateRequisitoService;

class RequisitoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ListRequisitoService $listService)
    {

        return Response::res('Requisitos listados', RequisitoResource::collection($listService->list()), 200);
        //return response()->json(['msg' => 'Requisitos listados', 'detalle' => RequisitoResource::collection($listService->list())]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(RequisitoRequest $request, CreateRequisitoService $createService)
    {
        return Response::res('Requisito registrado', RequisitoResource::make($createService->create($request->validated())));
    }

    public function show($id, ShowRequisitoService $showRequisitoService)
    {
        return Response::res('Requisito filtrado', RequisitoResource::make($showRequisitoService->show($id)));
    }

    public function update($id, RequisitoRequest $request, UpdateRequisitoService $updateRequisitoService)
    {
        return Response::res('Datos de Requisitos actualizado satisfactoriamente', RequisitoResource::make($updateRequisitoService->update($request->validated(), $id)));
    }

    public function destroy($id, DeleteRequisitoService $deleteRequisitoService)
    {
        return Response::res('Requisitos eliminado', RequisitoResource::make($deleteRequisitoService->delete($id)));
    }
}
