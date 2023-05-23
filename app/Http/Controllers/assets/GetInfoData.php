<?php

namespace App\Http\Controllers\assets;

use App\Http\Controllers\Controller;
use App\Models\Clientes;
use App\Models\Productos;
use App\Models\Ventas;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class GetInfoData extends Controller
{
    static public function GetInfo(Request $request, $data)
    {

        $DataToResponse = "";

        if (!$data) {

            return response()->json([
                'errors' => "Parametro requerido"
            ], 422);
        }

        if ($data == 1) {

            $ventas = Ventas::all();

            $totalVentas = $ventas->reduce(function ($carry, $venta) {
                return $carry + $venta->total;
            }, 0);

            $DataToResponse = $totalVentas;
        } else if ($data == 2) {


            $TotalProductos = Productos::count();

            $DataToResponse = $TotalProductos;
        } else if ($data == 3) {

            $TotalClientes = Clientes::count();

            $DataToResponse = $TotalClientes;
        } else if ($data == 4) {

            $TotalVentasProductos = Productos::all();

            $totalVentas = $TotalVentasProductos->reduce(function ($carry, $venta) {
                return $carry + $venta->ventas_producto;
            }, 0);

            $DataToResponse = $totalVentas;
        }

        return response()->json([
            'data' => $DataToResponse,
        ], 201);

        try {
        } catch (Exception $e) {
            return response()->json([
                'message' => 'No se ha podido registrar la categoría correctamente',
                'status' => $e,
            ], 422);
        }
    }
}
