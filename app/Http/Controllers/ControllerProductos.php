<?php

namespace App\Http\Controllers;

use App\Http\Controllers\assets\GetCodeUnique;
use App\Http\Controllers\assets\ResizeStorageImage;
use App\Models\Productos;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ControllerProductos extends Controller
{

    /*=============================================
                =LISTAR PRODUCTOS=
    =============================================*/

    public function index()
    {
        $productos = Productos::all();
        return response()->json($productos, 201);
    }

    /*=============================================
                =REGISTRAR PRODUCTOS=
    =============================================*/

    public function store(Request $request)
    {
        //valido los datos recibidos
        $validator = Validator::make($request->all(), [
            'id_category' => ['required', 'integer'],
            'codigo_producto' => ['nullable', 'unique:productos', 'string', 'max:255'],
            'descripcion_producto' => ['required', 'string'],
            'url_img_producto' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'stock_producto' => ['required', 'integer', 'min:0'],
            'precio_compra_producto' => ['required', 'numeric', 'min:0'],
            'precio_venta_producto' => ['required', 'numeric', 'min:0'],
            'ventas_producto' => ['required', 'integer', 'min:0'],
            'fecha' => ['required', 'date_format:Y-m-d H:i:s'],
        ], [
            'id_category.required' => 'El campo de categoría es obligatorio',
            'id_category.integer' => 'El campo de categoría debe ser un número entero',
            'codigo_producto.unique' => 'Ya existe producto con este código',
            'codigo_producto.string' => 'El campo de código de producto debe ser una cadena de caracteres',
            'codigo_producto.max' => 'El campo de código de producto no debe ser mayor de 255 caracteres',
            'descripcion_producto.required' => 'El campo de descripción de producto es obligatorio',
            'descripcion_producto.string' => 'El campo de descripción de producto debe ser una cadena de caracteres',
            'stock_producto.required' => 'El campo de stock de producto es obligatorio',
            'stock_producto.integer' => 'El campo de stock de producto debe ser un número entero',
            'stock_producto.min' => 'El campo de stock de producto no debe ser menor de 0',
            'precio_compra_producto.required' => 'El campo de precio de compra de producto es obligatorio',
            'precio_compra_producto.numeric' => 'El campo de precio de compra de producto debe ser un número',
            'precio_compra_producto.min' => 'El campo de precio de compra de producto no debe ser menor de 0',
            'precio_venta_producto.required' => 'El campo de precio de venta de producto es obligatorio',
            'precio_venta_producto.numeric' => 'El campo de precio de venta de producto debe ser un número',
            'precio_venta_producto.min' => 'El campo de precio de venta de producto no debe ser menor de 0',
            'ventas_producto.required' => 'El campo de ventas de producto es obligatorio',
            'ventas_producto.integer' => 'El campo de ventas de producto debe ser un número entero',
            'ventas_producto.min' => 'El campo de ventas de producto no debe ser menor de 0',
            'fecha.required' => 'El campo de fecha es obligatorio',
            'fecha.date_format' => 'El campo de fecha debe tener el formato AAAA-MM-DD',
        ]);

        // Si no se envían los datos correctamente envío un JSON con los errores
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }
        if ($request->hasFile('url_img_producto')) {
            // Guardar la imagen
            $ImageUrl = ResizeStorageImage::resizeAndStoreImage(
                $request->file('url_img_producto'),
                'productos',
                500,
                500
            );
        } else {
            $ImageUrl = '';
        }

        $codigo_producto = GetCodeUnique::generateUniqueProductCode();

        // Guardamos el usuario en la BD
        $productos = Productos::create([

            'id_category' => $request->id_category,
            'codigo_producto' => $codigo_producto,
            'descripcion_producto' => $request->descripcion_producto,
            'url_img_producto' => $ImageUrl,
            'stock_producto' => $request->stock_producto,
            'precio_compra_producto' => $request->precio_compra_producto,
            'precio_venta_producto' => $request->precio_venta_producto,
            'ventas_producto' => $request->ventas_producto,
            'fecha' => $request->fecha

        ]);

        if ($productos) {
            return response()->json([
                'producto' => $productos,
                'message' => 'Producto registrado correctamente'
            ], 201);
        }
    }

    /*=============================================
                =ACTUALIZAR PRODUCTOS=
    =============================================*/

    public function update(Request $request)
    {
        //valido los datos recibidos
        $validator = Validator::make($request->all(), [
            'id_category' => ['required', 'integer'],
            'codigo_producto' => ['string', 'max:255'],
            'descripcion_producto' => ['required', 'string'],
            'url_img_producto' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'stock_producto' => ['required', 'integer', 'min:0'],
            'precio_compra_producto' => ['required', 'numeric', 'min:0'],
            'precio_venta_producto' => ['required', 'numeric', 'min:0'],
            'ventas_producto' => ['required', 'integer', 'min:0'],
            'fecha' => ['required', 'date_format:Y-m-d H:i:s'],
        ], [
            'id_category.required' => 'El campo de categoría es obligatorio',
            'id_category.integer' => 'El campo de categoría debe ser un número entero',
            'codigo_producto.required' => 'El campo de código de producto es obligatorio',
            'codigo_producto.string' => 'El campo de código de producto debe ser una cadena de caracteres',
            'codigo_producto.max' => 'El campo de código de producto no debe ser mayor de 255 caracteres',
            'descripcion_producto.required' => 'El campo de descripción de producto es obligatorio',
            'descripcion_producto.string' => 'El campo de descripción de producto debe ser una cadena de caracteres',
            'stock_producto.required' => 'El campo de stock de producto es obligatorio',
            'stock_producto.integer' => 'El campo de stock de producto debe ser un número entero',
            'stock_producto.min' => 'El campo de stock de producto no debe ser menor de 0',
            'precio_compra_producto.required' => 'El campo de precio de compra de producto es obligatorio',
            'precio_compra_producto.numeric' => 'El campo de precio de compra de producto debe ser un número',
            'precio_compra_producto.min' => 'El campo de precio de compra de producto no debe ser menor de 0',
            'precio_venta_producto.required' => 'El campo de precio de venta de producto es obligatorio',
            'precio_venta_producto.numeric' => 'El campo de precio de venta de producto debe ser un número',
            'precio_venta_producto.min' => 'El campo de precio de venta de producto no debe ser menor de 0',
            'ventas_producto.required' => 'El campo de ventas de producto es obligatorio',
            'ventas_producto.integer' => 'El campo de ventas de producto debe ser un número entero',
            'ventas_producto.min' => 'El campo de ventas de producto no debe ser menor de 0',
            'fecha.required' => 'El campo de fecha es obligatorio',
            'fecha.date_format' => 'El campo de fecha debe tener el formato AAAA-MM-DD',
        ]);

        // Si no se envían los datos correctamente envío un JSON con los errores
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }
        // Busco al usuario en mi BD para traer sus datos.
        try {
            $findProducto = Productos::where('codigo_producto', $request->codigo_producto)->first();
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'message' => 'Producto no encontrado',
            ], 201);
        }

        // Capturo la ruta de la imagen almacenada en mi BD
        $oldImageUrl = $findProducto->url_img_producto;

        // Actualizo los campos
        $findProducto->id_category = $request->id_category;
        $findProducto->descripcion_producto = $request->descripcion_producto;
        $findProducto->stock_producto = $request->stock_producto;
        $findProducto->precio_compra_producto = $request->precio_compra_producto;
        $findProducto->precio_venta_producto = $request->precio_venta_producto;
        $findProducto->ventas_producto = $request->ventas_producto;
        $findProducto->fecha = $request->fecha;

        if (!empty($request->url_img_producto)) {

            // Guardar la nueva imagen
            $newImageUrl = ResizeStorageImage::resizeAndStoreImage(
                $request->file('url_img_producto'),
                'productos',
                500,
                500
            );

            // Actualizamos la URL de la nueva imagen en la BD
            $findProducto->url_img_producto = $newImageUrl;

            // Eliminar la imagen antigua si se cambió
            if ($oldImageUrl && $oldImageUrl !== $newImageUrl) {
                $oldImagePath = public_path(str_replace(url('/'), '', $oldImageUrl));
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
        }

        try {
            // Ejecuto método save para guardar
            if ($findProducto->save()) {
                return response()->json([
                    'producto' => $findProducto,
                    'message' => 'Actualizado correctamente'
                ], 201);
            }
        } catch (Exception $e) {
            return response()->json([
                'error' => $e,
                'message' => 'No se ha podido actualzizar producto',
            ], 422);
        }
    }

    /*=============================================
                =ELIMINAR PRODUCTOS=
    =============================================*/

    public function destroy(Request $request, $id)
    {

        try {
            $findProductos = Productos::findOrfail($id);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'message' => 'Producto no encontrado',
            ], 201);
        }
        if (!empty($findProductos->url_img_producto)) {
            $oldImagePath = public_path(str_replace(url('/'), '', $findProductos->url_img_producto));
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
        }

        if ($findProductos->delete()) {
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
