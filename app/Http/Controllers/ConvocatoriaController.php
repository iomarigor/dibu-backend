<?php

namespace App\Http\Controllers;

use App\Models\Convocatoria;
use App\Http\Controllers\Controller;
use App\Http\Requests\Convocatoria\ConvocatoriaRequest;
use App\Http\Resources\Convocatoria\ConvocatoriaResource;
use App\Services\Convocatoria\CreateConvocatoriaService;
use App\Services\Convocatoria\ListConvocatoriaService;
use App\Services\Convocatoria\UpdateConvocatoriaService;
use Illuminate\Http\Request;

class ConvocatoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ListConvocatoriaService $listConvocatoriaService)
    {
        return response()->json(['msg' => 'Servicios listados satisfactoriamente','detalle' => ConvocatoriaResource::collection($listConvocatoriaService->list())],200);
    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(ConvocatoriaRequest $request, CreateConvocatoriaService $createService)
    {
        //return response()->json(['msg' => 'Convocatoria registrada satisfactoriamente','detalle' =>ConvocatoriaResource::make($createService->create($request->validated()))],200);
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
     * @param  \App\Models\Convocatoria  $convocatoria
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $convocatoria = Convocatoria::find($id);
        if (!$convocatoria) {
            return response()->json(['msg' => 'Convocatoria no encontrado', 'detalle' => null], 404);
        }
        return response()->json(['msg' => 'Convocatoria', 'detalle' => $convocatoria]);
    
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Convocatoria  $convocatoria
     * @return \Illuminate\Http\Response
     */
    public function edit(Convocatoria $convocatoria)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Convocatoria  $convocatoria
     * @return \Illuminate\Http\Response
     */
    public function update(ConvocatoriaRequest $request, UpdateConvocatoriaService $updateService, $id)
    {
        $convocatoria = Convocatoria::findOrFail($id);
        $convocatoria = $updateService->update($convocatoria, $request->validated());
        return response()->json(['msg' => 'Convocatoria actualizada satisfactoriamente','detalle' => ConvocatoriaResource::make($convocatoria)],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Convocatoria  $convocatoria
     * @return \Illuminate\Http\Response
     */
    public function destroy(Convocatoria $convocatoria)
    {
        //
    }
}
