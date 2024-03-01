<?php

namespace App\Http\Controllers;

use App\Http\Requests\Requisito\CreateRequisitoRequest;
use App\Http\Resources\Requisito\RequisitoResource;
use App\Models\Requisito;
use App\Services\Requisito\CreateRequisitoService;
use App\Services\Requisito\ListRequisitoService;
use Illuminate\Http\Request;

class RequisitoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ListRequisitoService $listService)
    {
        return response()->json(['msg' => 'Requisitos listados', 'detalle' => RequisitoResource::collection($listService->list())]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(CreateRequisitoRequest $request, CreateRequisitoService $createService): RequisitoResource
    {
        return RequisitoResource::make($createService->create($request->validated()));
    }

    public function show($id)
    {
        $user = Requisito::findDA($id);
        if (!$user) {
            return response()->json(['msg' => 'Requisitos no encontrado', 'detalle' => null], 404);
        }
        return response()->json(['msg' => 'Requisitos', 'detalle' => $user]);
    }

    public function update(CreateRequisitoRequest $request, $id)
    {
        $data = $request->all();
        $requisito = Requisito::where([
            ['id', '=', $id],
            ['status_id', '!=', 1]
        ])->first();
        $requisito->update($data);
        return response()->json(['msg' => 'Datos de Requisitos actualizado satisfactoriamente', 'detalle' => $requisito], 200);
    }

    public function destroy($id)
    {
        $requisito = Requisito::find($id);
        if (!$requisito) {
            return response()->json(['msg' => 'Requisitos no encontrado', 'detalle' => null], 404);
        }

        $requisito->delete();

        return response()->json(['msg' => 'Requisitos eliminado', 'detalle' => $requisito], 200);
    }
}
