<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Convocatoria\ConvocatoriaRequest;
use App\Http\Resources\Convocatoria\ConvocatoriaResource;
use App\Services\Convocatoria\CreateConvocatoriaService;
use App\Services\Convocatoria\ListConvocatoriaService;
use App\Services\Convocatoria\UpdateConvocatoriaService;
use App\Http\Response\Response;
use App\Services\Convocatoria\ShowConvocatoriaService;
use App\Exceptions\ExceptionGenerate;
use App\Services\Convocatoria\UltimaConvocatoriaService;

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
        try {
            return Response::res('Convocatoria filtrada', ConvocatoriaResource::make($showConvocatoriaService->show($id)));
        } catch (ExceptionGenerate $e) {
            return Response::res($e->getMessage(), null, $e->getStatusCode());
        }
    }

    public function update(ConvocatoriaRequest $request, UpdateConvocatoriaService $updateService, $id)
    {
        try {
            return Response::res('Datos de convocatoria actualizado satisfactoriamente', ConvocatoriaResource::make($updateService->update($request->validated(), $id)));
        } catch (ExceptionGenerate $e) {
            return Response::res($e->getMessage(), null, $e->getStatusCode());
        }
    }

    public function vigenteConvocatoria(UltimaConvocatoriaService $ultimaService)
    {
        try {
            return  Response::res('Ultima convocatoria mostrada', ConvocatoriaResource::make($ultimaService->vigente()));
        } catch (ExceptionGenerate $e) {
            return Response::res($e->getMessage(), null, $e->getStatusCode());
        }
    }
}
