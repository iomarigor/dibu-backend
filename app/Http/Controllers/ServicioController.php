<?php

namespace App\Http\Controllers;

use App\Http\Requests\Servicio\ServicioRequest;
use App\Http\Resources\Servicio\ServicioResource;
use App\Models\Servicio;
use App\Services\Servicio\UpdateServicioService;
use App\Services\Servicio\CreateServicioService;
use App\Services\Servicio\ListServicioService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServicioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ListServicioService $listServicioService)
    {
        return response()->json(['msg' => 'Servicios listados satisfactoriamente','detalle' => ServicioResource::collection($listServicioService->list())],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(ServicioRequest $request, CreateServicioService $createService)
    {
        return response()->json(['msg' => 'Servicio registrado satisfactoriamente','detalle' => ServicioResource::make($createService->create($request->validated()))],200);
    }

    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Servicio  $servicio
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $servicio = Servicio::find($id);
        if (!$servicio) {
            return response()->json(['msg' => 'Servicio no encontrado', 'detalle' => null], 404);
        }
        return response()->json(['msg' => 'Servicio', 'detalle' => $servicio]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Servicio  $servicio
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Servicio $servicio)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Servicio  $servicio
     * @return \Illuminate\Http\Response
     */
    public function update(ServicioRequest $request, UpdateServicioService $updateService, $id)
    {
        $servicio = Servicio::findOrFail($id);
        $servicio = $updateService->update($servicio, $request->validated());
        return response()->json(['msg' => 'Servicio actualizado satisfactoriamente','detalle' => ServicioResource::make($servicio)],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Servicio  $servicio
     * @return \Illuminate\Http\Response
     */
    public function destroy(Servicio $servicio)
    {
        //
        
    }
}
