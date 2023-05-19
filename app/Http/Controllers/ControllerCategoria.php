<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Models\Categorias;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ControllerCategoria extends Controller
{
    /*=============================================
                =LISTAR CATEGORIAS=
    =============================================*/

    public function index()
    {
        $categoria = Categorias::all();
        return response()->json($categoria, 201);
    }

    /*=============================================
                =REGISTRAR CATEGORIAS=
    =============================================*/

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'categoria' => 'required|string|unique:categorias|min:3|max:255',
            'fecha' => 'required|date|date_format:Y-m-d H:i:s',
        ], [
            'name.required' => 'El campo categoría es obligatorio',
            'name.unique' => 'Ya existe esta categoría',
            'fecha.required' => 'El campo fecha es obligatorio',
            'fecha.date_format' => 'El campo fecha debe tener el formato Y-m-d H:i:s',
        ]);

        // Si no se envían los datos correctamente envío un JSON con los errores
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        // Capturo la excepción y envío el error
        try {
            // Guardamos el usuario en la BD
            $categoria = Categorias::create([
                'categoria' => $request->categoria,
                'fecha' => $request->fecha,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'No se ha podido registrar la categoría correctamente',
                'status' => $e,
            ], 422);
        }

        // Si la categoría se registró correctamente envío respuesta
        if ($categoria) {
            return response()->json([
                'categoria' => $categoria,
                'message' => 'Categoría registrada correctamente',
            ], 201);
        }
    }

    /*=============================================
                =ACTUALIZAR CATEGORIAS=
    =============================================*/

    public function update(Request $request, string $id)
    {
        // $validator = Validator::make($request->all(), [
        //     'categoria' => 'string|min:3|max:255',
        //     'fecha' => 'date|date_format:Y-m-d',
        // ]);

        $validator = Validator::make($request->all(), [
            'categoria' => 'required|string|min:3|max:255',
            'fecha' => 'required|date|date_format:Y-m-d H:i:s',
        ], [
            'name.required' => 'El campo categoría es obligatorio',
            'name.unique' => 'Ya existe esta categoría',
            'fecha.required' => 'El campo fecha es obligatorio',
            'fecha.date_format' => 'El campo fecha debe tener el formato Y-m-d H:i:s',
        ]);

        // Si no se envían los datos correctamente envío un JSON con los errores
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        // Busco al usuario en mi BD para traer sus datos.
        try {
            $findCategory = Categorias::findOrFail($id);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'message' => 'Esta categoría no existe',
            ], 201);
        }

        // Modifico datos fecha
        $findCategory->categoria = $request->categoria;
        $findCategory->fecha = $request->fecha;
        $findCategory->save();

        return response()->json([
            'categoria' => $findCategory,
            'message' => 'Categoría modificada correctamente.'
        ], 201);
    }

    /*=============================================
                =ELIMINAR CATEGORIAS=
    =============================================*/

    public function destroy(string $id)
    {
        try {
            $findCategory = Categorias::findOrfail($id);
            $findCategory->delete();
            return response()->json([
                "message" => 'Eliminado correctamente.'
            ], 201);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'message' => 'Categoría no encontrado',
            ], 201);
        } catch (\Exception $exception) {
            if ($exception instanceof \Illuminate\Database\QueryException) {
                return response()->json([
                    "message" => 'No se ha podido eliminar la categoría debido a que tiene productos relacionados.'
                ], 422);
            }
            return response()->json([
                "message" => 'Ha ocurrido un error inesperado.'
            ], 422);
        }
    }
}
