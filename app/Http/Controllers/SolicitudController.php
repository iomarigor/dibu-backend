<?php

namespace App\Http\Controllers;

use App\Exceptions\ExceptionGenerate;
use App\Http\Requests\Solicitud\SolicitudRequest;
use App\Http\Requests\Solicitud\SolicitudServicioRequest;
use App\Http\Requests\Solicitud\UploadDocumentRequest;
use App\Http\Requests\Solicitud\ValidarDatosAlumnoRequest;
use App\Http\Resources\ServicioSolicitado\ServicioSolicitadoResource;
use App\Http\Resources\ServicioSolicitado\UpdateServicioSolicitadoResource;
use App\Http\Resources\Solicitud\SolicitudResource;
use App\Http\Response\Response;
use App\Services\Solicitud\ValidacionSolicitudService as SolicitudValidacionSolicitudService;
use App\Services\Solicitud\CreateSolicitudService;
use App\Services\Solicitud\ListSolicitudService;
use App\Services\Solicitud\ShowSolicitudService;
use App\Services\Solicitud\SolicitudServicioService;

class SolicitudController extends Controller
{

    public function validacionSolicitud(ValidarDatosAlumnoRequest $request, SolicitudValidacionSolicitudService $validacionSolicitudService)
    {
        try {
            return Response::res('Usted es apto para solicitar los servicos brindados por OBU - UNAS', ($validacionSolicitudService->validate($request->validated())));
        } catch (ExceptionGenerate $e) {
            return Response::res($e->getMessage(), $e->getData(), $e->getStatusCode());
        }
    }
    public function index(ListSolicitudService $listSolicitudService)
    {
        return Response::res('Solicitudes listadas', SolicitudResource::collection($listSolicitudService->list()), 200);
    }

    public function create(SolicitudRequest $request, CreateSolicitudService $createService)
    {
        return Response::res('Solicitud registrada', SolicitudResource::make($createService->create($request->validated())));
    }

    public function show($id, ShowSolicitudService $showSolicitudService)
    {
        return Response::res('Solicitud filtrada', SolicitudResource::make($showSolicitudService->show($id)));
    }

    public function updateServicio(SolicitudServicioRequest $request, SolicitudServicioService $updateSolicitudServicioService)
    {
        try {
            return Response::res('Datos de solicitud actualizada', ServicioSolicitadoResource::collection($updateSolicitudServicioService->updateServicio($request->validated())));
        } catch (ExceptionGenerate $e) {
            return Response::res($e->getMessage(), null, $e->getStatusCode());
        }
    }

    public function uploadDocument(UploadDocumentRequest $request, CreateSolicitudService $createService)
    {
        try {
            return Response::res('Documento registrado', ($createService->uploadFile($request->validated())));
        } catch (ExceptionGenerate $e) {
            return Response::res($e->getMessage(), null, $e->getStatusCode());
        }
    }
}
