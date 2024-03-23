<?php

namespace App\Exceptions;

use Exception;

class ExceptionGenerate extends Exception
{
    protected $statusCode;
    protected $datos;

    public function __construct($message, $statusCode = 500, $datos = null)
    {
        parent::__construct($message);
        $this->statusCode = $statusCode;
        $this->datos = $datos;
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }
    public function getData()
    {
        return $this->datos;
    }
}
