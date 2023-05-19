<?php

namespace App\Http\Controllers;

use App\Http\Controllers\assets\GetCodeUnique;
use App\Models\Clientes;
use App\Models\Productos;
use App\Models\Ventas;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ControllerVentas extends Controller
{

    /*=============================================
                =LISTAR VENTA=
    =============================================*/

    public function index()
    {
        $ventas = Ventas::all();
        return response()->json($ventas, 201);
    }

    /*=============================================
                =REGISTRAR VENTA=
    =============================================*/

    public function store(Request $request)
    {
        //valido los datos recibidos
        $validator = Validator::make($request->all(), [
            'id_cliente' => 'required|numeric',
            'id_vendedor' => 'required|numeric',
            'productos_venta' => 'required',
            'impuesto_venta' => 'required|numeric',
            'neto_venta' => 'required|numeric',
            'total' => 'required|numeric',
            'metodo_pago' => 'required',
            'fecha' => 'required|date|date_format:Y-m-d H:i:s',
        ], [
            'id_cliente.required' => 'El id del cliente es obligatorio.',
            'id_cliente.numeric' => 'El id del cliente debe ser un número.',
            'id_vendedor.required' => 'El id del vendedor es obligatorio.',
            'id_vendedor.numeric' => 'El id del vendedor debe ser un número.',
            'productos_venta.required' => 'Los productos de la venta son obligatorios.',
            'impuesto_venta.required' => 'El impuesto de la venta es obligatorio.',
            'impuesto_venta.numeric' => 'El impuesto de la venta debe ser un número.',
            'neto_venta.required' => 'El neto de la venta es obligatorio.',
            'neto_venta.numeric' => 'El neto de la venta debe ser un número.',
            'total.required' => 'El total de la venta es obligatorio.',
            'total.numeric' => 'El total de la venta debe ser un número.',
            'metodo_pago.required' => 'El método de pago es obligatorio.',
            'fecha.required' => 'La fecha de la venta es obligatoria.',
            'fecha.date' => 'La fecha de la venta debe ser una fecha válida.',
        ]);
        // Si no se envían los datos correctamente envío un JSON con los errores
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        try {

            $codigo_venta = GetCodeUnique::generateUniqueVentaCode();

            // Guardamos el usuario en la BD
            $ventas = Ventas::create([
                'codigo_venta' => $codigo_venta,
                'id_cliente' => $request->id_cliente,
                'id_vendedor' => $request->id_vendedor,
                'productos_venta' => $request->productos_venta,
                'impuesto_venta' => $request->impuesto_venta,
                'neto_venta' => $request->neto_venta,
                'total' => $request->total,
                'metodo_pago' => $request->metodo_pago,
                'fecha' => $request->fecha
            ]);

            $jsonString = $request->productos_venta;

            $productos = json_decode($jsonString, true);

            $idsProductos = array_column($productos, 'id');

            $productosEnVenta = Productos::whereIn('id', $idsProductos)->get();

            foreach ($productosEnVenta as $producto) {
                $id = $producto->id;
                $cantidad = $productos[array_search($id, array_column($productos, 'id'))]['cantidad'];

                // Actualizamos el stock del producto
                $producto->stock_producto -= $cantidad;
                $producto->ventas_producto += $cantidad;
                $producto->save();
            }

            $cliente = Clientes::findOrFail($request->id_cliente); // Busca al cliente por su ID

            $cliente->compras_cliente = $cliente->compras_cliente + 1;

            $cliente->ultima_compra = date('Y-m-d H:i:s');

            $cliente->save();
        } catch (Exception $e) {
            return response()->json([
                'errors' => $e
            ], 422);
        }

        if ($ventas) {
            return response()->json([
                'venta' => $ventas,
                'message' => 'Venta registrada correctamente'
            ], 201);
        }
    }

    /*=============================================
                =ACTUALIZAR VENTA=
    =============================================*/

    public function update(Request $request, $id_venta)
    {
        //valido los datos recibidos
        $validator = Validator::make($request->all(), [
            'id_cliente' => 'required|numeric',
            'id_vendedor' => 'required|numeric',
            'productos_venta' => 'required',
            'impuesto_venta' => 'required|numeric',
            'neto_venta' => 'required|numeric',
            'total' => 'required|numeric',
            'metodo_pago' => 'required',
            'fecha' => 'required|date',
        ], [
            'codigo_venta.required' => 'El código de venta es obligatorio.',
            'id_cliente.required' => 'El id del cliente es obligatorio.',
            'id_cliente.numeric' => 'El id del cliente debe ser un número.',
            'id_vendedor.required' => 'El id del vendedor es obligatorio.',
            'id_vendedor.numeric' => 'El id del vendedor debe ser un número.',
            'productos_venta.required' => 'Los productos de la venta son obligatorios.',
            'impuesto_venta.required' => 'El impuesto de la venta es obligatorio.',
            'impuesto_venta.numeric' => 'El impuesto de la venta debe ser un número.',
            'neto_venta.required' => 'El neto de la venta es obligatorio.',
            'neto_venta.numeric' => 'El neto de la venta debe ser un número.',
            'total.required' => 'El total de la venta es obligatorio.',
            'total.numeric' => 'El total de la venta debe ser un número.',
            'metodo_pago.required' => 'El método de pago es obligatorio.',
            'fecha.required' => 'La fecha de la venta es obligatoria.',
            'fecha.date' => 'La fecha de la venta debe ser una fecha válida.',
        ]);
        // Si no se envían los datos correctamente envío un JSON con los errores
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        // Busco la venta en mi BD para traer sus datos.
        try {
            $findVentas = Ventas::findOrFail($id_venta);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'message' => 'Venta no encontrada',
            ], 201);
        }

        // Actualizo campos
        $findVentas->id_cliente = $request->id_cliente;
        $findVentas->id_vendedor = $request->id_vendedor;
        $findVentas->productos_venta = $request->productos_venta;
        $findVentas->impuesto_venta = $request->impuesto_venta;
        $findVentas->neto_venta = $request->neto_venta;
        $findVentas->total = $request->total;
        $findVentas->metodo_pago = $request->metodo_pago;
        $findVentas->fecha = $request->fecha;

        try {
            // Ejecuto método save para guardar
            if ($findVentas->save()) {
                return response()->json([
                    'producto' => $findVentas,
                    'message' => 'Actualizado correctamente'
                ], 201);
            }
        } catch (Exception $e) {
            return response()->json([
                'error' => $e,
                'message' => 'No se ha podido actualizar producto',
            ], 422);
        }
    }

    /*=============================================
                =ELIMINAR VENTA=
    =============================================*/

    public function destroy(Request $request, $id)
    {
        try {
            $findVentas = Ventas::findOrFail($id);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'message' => 'Producto no encontrado',
            ], 201);
        }

        if ($findVentas->delete()) {
            return response()->json([

                "message" => 'Eliminado correctamente.'

            ], 201);
        } else {
            return response()->json([

                "message" => 'No se ha podido eliminar el producto.'

            ], 422);
        }
    }
}
