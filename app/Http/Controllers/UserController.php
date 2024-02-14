<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::allDA();
        return response()->json(['msg' => 'Usuarios listados', 'detalle' => $users]);
    }

    public function show($id)
    {
        $user = User::findDA($id);
        if (!$user) {
            return response()->json(['msg' => 'Usuario no encontrado', 'detalle' => null], 404);
        }
        return response()->json(['msg' => 'Usuario', 'detalle' => $user]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'id' => 'required',
            'username' => 'required',
            'full_name' => 'required',
            'password' => 'nullable',
            'email' => 'required',
            'id_level_user' => 'required',
            'last_user' => 'required'
        ]);

        // Limpiado datos de confirmacion de contraseña
        $data = $request->all();
        $user = User::where([
            ['username', '=', $data['username']],
            ['status_id', '!=', 1]
        ])->first();


        if ($user && ($user['id'] != $data['id'])) {
            return response()->json(['msg' => 'Ya existe un usuario con el mismo nombre de usuario', 'detalle' => $user], 404);
        }
        if (array_key_exists('password', $data) && strlen($data['password']) == 0) {
            unset($data['password']);
        } else {
            // Hasheando contraseña
            if (array_key_exists('password', $data)) {
                $data["password"] = Hash::make($request->input('password'));
            }
        }
        unset($data['password_confirmation']);



        // Recupera los datos actuales antes de la actualización
        $user = User::whereId($data['id'])->first();
        $user->update($data);
        return response()->json(['msg' => 'Datos de usuario actualizado satisfactoriamente', 'detalle' => $user], 200);
    }

    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['msg' => 'Usuario no encontrado', 'detalle' => null], 404);
        }

        $user->delete();

        return response()->json(['msg' => 'Usuario eliminado', 'detalle' => $user], 200);
    }
}
