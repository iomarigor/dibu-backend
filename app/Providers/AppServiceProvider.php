<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
    public function boot()
    {
        Validator::extend('unas_email', function ($attribute, $value, $parameters, $validator) {
            // Validar que el dominio sea "unas.edu.pe"
            return preg_match('/^[a-zA-Z0-9._%+-]+@unas\.edu\.pe$/', $value);
        });

        Validator::replacer('unas_email', function ($message, $attribute, $rule, $parameters) {
            // Personaliza el mensaje de error aquí si lo deseas
            return str_replace(':attribute', $attribute, 'El :attribute debe ser un correo electrónico de @unas.edu.pe brindado por OTI - UNAS');
        });
        Validator::extend('dni_length', function ($attribute, $value, $parameters, $validator) {
            // Validar que el DNI tenga una longitud de 8 dígitos
            return strlen((string)$value) == 8;
        });
        Validator::replacer('dni_length', function ($message, $attribute, $rule, $parameters) {
            // Personaliza el mensaje de error aquí si lo deseas
            return str_replace(':attribute', $attribute, 'El :attribute debe tener una longitud de 8 dígitos');
        });
    }
}
