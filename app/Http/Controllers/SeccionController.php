<?php

namespace App\Http\Controllers;

use App\Models\Seccion;
use Illuminate\Http\Request;

class SeccionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['msg' => 'Seccion', 'detalle' => RequisitoResource::collection($listService->list())]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(CreateSeccionRequest $request, CreateSeccionService $createSeccion): SeccionResource
    {
        return SeccionResource::make($createService->create($request->validated()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Seccion  $seccion
     * @return \Illuminate\Http\Response
     * OJOOO
     * --->REEVALUAR LA UTILIDAD DEL SHOW EN SECCIONES
     * -------------------NO OLVIDAR------------------------
     */
    public function show($id)
    {
        $seccion = Seccion::findDA($id);
        if (!$seccion) {
            return response()->json(['msg' => 'Seccion no encontrada', 'detalle' => null], 404);
        }
        return response()->json(['msg' => 'Secciones', 'detalle' => $seccion]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Seccion  $seccion
     * @return \Illuminate\Http\Response
     */
    public function edit(Seccion $seccion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Seccion  $seccion
     * @return \Illuminate\Http\Response
     */
    public function update(CreateSeccionRequest $request, $id)
    {
        $data = $request->all();
        $seccion = Seccion::where([
            ['id', '=', $id],
            ['status_id', '!=', 1]
        ])->first();
        $seccion->update($data);
        return response()->json(['msg' => 'Datos de Secciones actualizado satisfactoriamente', 'detalle' => $seccion], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Seccion  $seccion
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $seccion = Seccion::find($id);
        if (!$seccion) {
            return response()->json(['msg' => 'Seccion no encontrada', 'detalle' => null], 404);
        }

        $seccion->delete();

        return response()->json(['msg' => 'Requisitos eliminado', 'detalle' => $seccion], 200);
    }
}
