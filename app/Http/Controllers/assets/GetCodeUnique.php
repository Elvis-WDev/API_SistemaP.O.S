<?php

namespace App\Http\Controllers\assets;

use App\Http\Controllers\Controller;
use App\Models\Productos;
use App\Models\Ventas;

class GetCodeUnique extends Controller
{
    static public function generateUniqueProductCode()
    {
        $codeExists = true;
        while ($codeExists) {
            $code = mt_rand(100000, 999999); // genera un código de 6 dígitos aleatorio
            $codeExists = Productos::where('codigo_producto', $code)->exists(); // verifica si el código ya existe en la BD
        }
        return $code;
    }
    static public function generateUniqueVentaCode()
    {
        $codeExists = true;
        while ($codeExists) {
            $code = mt_rand(10000000, 999999999); // genera un código de 6 dígitos aleatorio
            $codeExists = Ventas::where('codigo_venta', $code)->exists(); // verifica si el código ya existe en la BD
        }
        return $code;
    }
}