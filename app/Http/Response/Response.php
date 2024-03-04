<?php

namespace App\Http\Response;

use Ramsey\Uuid\Type\Integer;

class Response
{
    public static function res(String $message, $data, int $status = 200)
    {
        return response()->json(['msg' => $message, 'detalle' => $data], $status);
    }
}
