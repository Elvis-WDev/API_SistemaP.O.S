<?php

namespace App\Http\Controllers;

use App\Models\Clientes;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ControllerClientes extends Controller
{
    /*=============================================
                =LISTAR CLIENTE=
    =============================================*/

    public function index()
    {
        $clientes = Clientes::all();
        return response()->json($clientes, 201);
    }

    /*=============================================
                =REGISTRAR CLIENTE=
    =============================================*/

    public function store(Request $request)
    {
        //valido los datos recibidos 
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'cedula' => 'required|string|unique:clientes|max:255',
            'email' => 'required|email|unique:clientes|string|max:255',
            'telefono' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'fecha_nacimiento' => 'required|string|max:255|date_format:Y-m-d',
            'compras_cliente' => 'integer|min:0|max:99999',
            'ultima_compra' => 'nullable|string|max:255|date_format:Y-m-d',
            'fecha_registro' => 'required|string|max:255|date_format:Y-m-d',
        ], [
            'name.required' => 'El campo Nombre es obligatorio',
            'name.max' => 'El campo name del cliente debe ser menor o igual a 255',
            'cedula.required' => 'El campo Cédula es obligatorio',
            'cedula.unique' => 'Ya existe un cliente registrado con esta cédula',
            'cedula.max' => 'El campo cedula del cliente debe ser menor o igual a 255',
            'email.required' => 'El campo Correo electrónico es obligatorio',
            'email.email' => 'El Correo electrónico debe tener un formato válido',
            'email.unique' => 'Ya existe un cliente registrado con este email',
            'email.max' => 'El campo email del cliente debe ser menor o igual a 255',
            'telefono.required' => 'El campo Teléfono es obligatorio',
            'telefono.max' => 'El campo telefono del cliente debe ser menor o igual a 255',
            'direccion.required' => 'El campo Dirección es obligatorio',
            'direccion.max' => 'El campo direccion del cliente debe ser menor o igual a 255',
            'fecha_nacimiento.required' => 'El campo Fecha de nacimiento es obligatorio',
            'fecha_nacimiento.max' => 'El campo fecha_nacimiento del cliente debe ser menor o igual a 255',
            'fecha_nacimiento.date_format' => 'El campo Fecha de nacimiento debe tener el formato Y-m-d',
            'compras_cliente.integer' => 'El campo Compras del cliente debe ser un número entero',
            'compras_cliente.min' => 'El campo Compras del cliente debe ser mayor o igual a 0',
            'compras_cliente.max' => 'El campo Compras del cliente debe ser menor o igual a 99999',
            'ultima_compra.max' => 'El campo ultima_compra del cliente debe ser menor o igual a 255',
            'ultima_compra.date_format' => 'El campo Última compra debe tener el formato Y-m-d',
            'fecha_registro.required' => 'El campo Fecha de registro es obligatorio',
            'fecha_registro.max' => 'El campo fecha_registro del cliente debe ser menor o igual a 255',
            'fecha_registro.date_format' => 'El campo Fecha de registro debe tener el formato Y-m-d',
        ]);

        // Si no se envían los datos correctamente envío un JSON con los errores
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Guardamos el usuario en la BD
            $cliente = Clientes::create([

                'name' => $request->name,
                'cedula' => $request->cedula,
                'email' => $request->email,
                'telefono' => $request->telefono,
                'direccion' => $request->direccion,
                'fecha_nacimiento' => $request->fecha_nacimiento,
                'compras_cliente' => $request->compras_cliente,
                'ultima_compra' => $request->ultima_compra,
                'fecha_registro' => $request->fecha_registro,

            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Internal error',
                'status' => $e,
            ], 422);
        }

        return response()->json([
            'cliente' => $cliente,
            'message' => 'Cliente registrado correctamente',
        ], 201);
    }

    /*=============================================
                =ACTUALIZAR CLIENTE=
    =============================================*/

    public function update(Request $request, string $id)
    {
        //valido los datos recibidos 
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'cedula' => 'required|string|max:255',
            'email' => 'required|email|string|max:255',
            'telefono' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'fecha_nacimiento' => 'required|string|max:255|date_format:Y-m-d',
            'compras_cliente' => 'integer|min:0|max:99999',
            'ultima_compra' => 'nullable|string|max:255|date_format:Y-m-d',
            'fecha_registro' => 'required|string|max:255|date_format:Y-m-d',
        ], [
            'name.required' => 'El campo Nombre es obligatorio',
            'name.max' => 'El campo name del cliente debe ser menor o igual a 255',
            'cedula.required' => 'El campo Cédula es obligatorio',
            'cedula.unique' => 'Ya existe un cliente registrado con esta cédula',
            'cedula.max' => 'El campo cedula del cliente debe ser menor o igual a 255',
            'email.required' => 'El campo Correo electrónico es obligatorio',
            'email.email' => 'El Correo electrónico debe tener un formato válido',
            'email.unique' => 'Ya existe un cliente registrado con este email',
            'email.max' => 'El campo email del cliente debe ser menor o igual a 255',
            'telefono.required' => 'El campo Teléfono es obligatorio',
            'telefono.max' => 'El campo telefono del cliente debe ser menor o igual a 255',
            'direccion.required' => 'El campo Dirección es obligatorio',
            'direccion.max' => 'El campo direccion del cliente debe ser menor o igual a 255',
            'fecha_nacimiento.required' => 'El campo Fecha de nacimiento es obligatorio',
            'fecha_nacimiento.max' => 'El campo fecha_nacimiento del cliente debe ser menor o igual a 255',
            'fecha_nacimiento.date_format' => 'El campo Fecha de nacimiento debe tener el formato Y-m-d',
            'compras_cliente.integer' => 'El campo Compras del cliente debe ser un número entero',
            'compras_cliente.min' => 'El campo Compras del cliente debe ser mayor o igual a 0',
            'compras_cliente.max' => 'El campo Compras del cliente debe ser menor o igual a 99999',
            'ultima_compra.max' => 'El campo ultima_compra del cliente debe ser menor o igual a 255',
            'ultima_compra.date_format' => 'El campo Última compra debe tener el formato Y-m-d',
            'fecha_registro.required' => 'El campo Fecha de registro es obligatorio',
            'fecha_registro.max' => 'El campo fecha_registro del cliente debe ser menor o igual a 255',
            'fecha_registro.date_format' => 'El campo Fecha de registro debe tener el formato Y-m-d',
        ]);

        // Si no se envían los datos correctamente envío un JSON con los errores
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        // Busco al usuario en mi BD para traer sus datos.
        try {
            $findClient = Clientes::findOrFail($id);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'message' => 'cliente no encontrado',
            ], 201);
        }
        $findClient->name = $request->name;
        $findClient->cedula = $request->cedula;
        $findClient->email = $request->email;
        $findClient->telefono = $request->telefono;
        $findClient->direccion = $request->direccion;
        $findClient->fecha_nacimiento = $request->fecha_nacimiento;
        $findClient->ultima_compra = $request->ultima_compra;
        $findClient->fecha_registro = $request->fecha_registro;

        // Ejecuto método save para guardar
        $findClient->save();

        // Devolver una respuesta adecuada al usuario.
        return response()->json([
            'cliente' => $findClient,
            'message' => 'Cliente modificado correctamente',
        ], 201);
    }

    /*=============================================
                =ELIMINAR CLIENTE=
    =============================================*/

    public function destroy(string $id)
    {
        try {
            $findClient = Clientes::findOrfail($id);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'message' => 'Usuario no encontrado',
            ], 201);
        }

        if ($findClient->delete()) {
            return response()->json([

                "message" => 'Eliminado correctamente.'

            ], 201);
        } else {
            return response()->json([

                "message" => 'No se ha podido eliminar el cliente.'

            ], 422);
        }
    }
}
