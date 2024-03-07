<?php

namespace App\Http\Controllers;

use App\Exceptions\ExceptionGenerate;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\User\UserResource;
use App\Http\Response\Response;
use App\Models\User;
use App\Services\User\DeleteUserService;
use App\Services\User\ListUserService;
use App\Services\User\ShowUserService;
use App\Services\User\UpdateUserService;

class UserController extends Controller
{
    public function index(ListUserService $listUserService)
    {
        return Response::res('Lista de usuarios', UserResource::collection($listUserService->list()), 200);
    }

    public function show($id, ShowUserService $showUserService)
    {
        try {
            return Response::res('Usuario', UserResource::make($showUserService->show($id)));
        } catch (ExceptionGenerate $e) {
            return Response::res($e->getMessage(), null, $e->getStatusCode());
        }
    }

    public function update(UpdateUserRequest $request, UpdateUserService $updateUserService, $id)
    {
        try {
            return Response::res('Datos de usuario actualizado satisfactoriamente', UserResource::make($updateUserService->update($id, $request->validated())));
        } catch (ExceptionGenerate $e) {
            return Response::res($e->getMessage(), null, $e->getStatusCode());
        }
    }

    public function destroy($id, DeleteUserService $deleteUserService)
    {
        try {
            return Response::res('Usuario eliminado', UserResource::make($deleteUserService->delete($id)));
        } catch (ExceptionGenerate $e) {
            return Response::res($e->getMessage(), null, $e->getStatusCode());
        }
    }
}
