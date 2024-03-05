<?php

namespace App\Http\Controllers;

use App\Models\Convocatoria;
use App\Http\Controllers\Controller;
use App\Http\Requests\Convocatoria\ConvocatoriaRequest;
use App\Http\Resources\Convocatoria\ConvocatoriaResource;
use App\Services\Convocatoria\CreateConvocatoriaService;
use App\Services\Convocatoria\ListConvocatoriaService;
use App\Services\Convocatoria\UpdateConvocatoriaService;
use App\Http\Response\Response;
use App\Services\Convocatoria\ShowConvocatoriaService;
use Illuminate\Http\Request;

class ConvocatoriaController extends Controller
{
    public function index(ListConvocatoriaService $listConvocatoriaService)
    {
        return Response::res('Convocatorias listadas', ConvocatoriaResource::collection($listConvocatoriaService->list()), 200);
    }

    public function create(ConvocatoriaRequest $request, CreateConvocatoriaService $createService)
    {
        return Response::res('Convocatoria registrada', ConvocatoriaResource::make($createService->create($request->validated())));
    }

    public function show($id, ShowConvocatoriaService $showConvocatoriaService)
    {
        return Response::res('Convocatoria filtrada', ConvocatoriaResource::make($showConvocatoriaService->show($id)));
    }

    public function update(ConvocatoriaRequest $request, UpdateConvocatoriaService $updateService, $id)
    {
        return Response::res('Datos de convocatoria actualizado satisfactoriamente', ConvocatoriaResource::make($updateService->update($request->validated(), $id)));
    }

    public function destroy(Convocatoria $convocatoria)
    {
        //
    }
}
