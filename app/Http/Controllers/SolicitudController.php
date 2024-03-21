<?php

namespace App\Http\Controllers;

use App\Http\Requests\Solicitud\SolicitudRequest;
use App\Http\Resources\Solicitud\SolicitudResource;
use App\Http\Response\Response;
use App\Models\Solicitud;
use App\Services\Solicitud\CreateSolicitudService;

class SolicitudController extends Controller
{
    public function index(ListSolicitudService $listSolicitudService)
    {
        return Response::res('Solicitudes listadas', SolicitudResource::collection($listSolicitudService->list()), 200);
    }

    public function create(SolicitudRequest $request, CreateSolicitudService $createService)
    {
        return Response::res('Solicitudes registrada', SolicitudResource::make($createService->create($request->validated())));
    }

    public function show($id, ShowSolicitudService $showSolicitudService)
    {
        return Response::res('Convocatoria filtrada', SolicitudResource::make($showSolicitudService->show($id)));
    }

    public function destroy(Solicitud $solicitud)
    {
        //
    }
}
