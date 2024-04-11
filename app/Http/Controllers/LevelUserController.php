<?php

namespace App\Http\Controllers;

use App\Models\LevelUser;
use Illuminate\Http\Request;

class LevelUserController extends Controller
{
    public function index()
    {
        $levelUser = LevelUser::all();
        return response()->json(['msg' => 'Niveles de usuario listadas', 'detalle' => $levelUser]);
    }
}
