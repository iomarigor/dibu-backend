<?php

namespace App\Http\Controllers;

use App\LevelUser;
use Illuminate\Http\Request;

class LevelUserController extends Controller
{
    public function index()
    {
        $sedes = LevelUser::all();
        return response()->json(['msg' => 'Niveles de usuario listadas', 'detalle' => $sedes]);
    }
}
