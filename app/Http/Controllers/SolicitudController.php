<?php

namespace App\Http\Controllers;

use App\Exceptions\ExceptionGenerate;
use App\Http\Requests\Servicio\SolicitudRequest;
use App\Http\Requests\Solicitud\SolicitudRequest as SolicitudSolicitudRequest;
use App\Http\Resources\Alumnos\AlumnosResource;
use App\Http\Resources\Solicitud\SolicitudResource;
use App\Http\Response\Response;
use App\Services\Servicio\ValidacionSolicitudService;
use App\Services\Solicitud\ValidacionSolicitudService as SolicitudValidacionSolicitudService;

class SolicitudController extends Controller
{

    public function validacionSolicitud(SolicitudSolicitudRequest $request, SolicitudValidacionSolicitudService $validacionSolicitudService)
    {
        try {
            return Response::res('Usted es apto para solicitar los servicos brindados por OBU - UNAS', AlumnosResource::make($validacionSolicitudService->validate($request->validated())));
        } catch (ExceptionGenerate $e) {
            return Response::res($e->getMessage(), $e->getData(), $e->getStatusCode());
        }
    }
}
