<?php

namespace App\Http\Controllers\auth;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Http\Requests\auth\AuthRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\assets\ResizeStorageImage;

class ControllerAuth extends Controller
{
    /*=============================================
                =REGSITRAR USUARIO=
    =============================================*/

    public function register_user(Request $request)
    {
        //valido los datos recibidos 
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'user' => 'required|string|unique:users|max:255',
            'password' => 'required|string|min:8|confirmed',
            'profile' => 'required|string|max:255',
            'url_image' => 'image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|max:255',
            'last_login' => 'required|max:255',
        ], [
            'name.required' => 'El nombre es requerido.',
            'name.string' => 'El nombre debe ser una cadena de caracteres.',
            'name.max' => 'El nombre no debe exceder los 255 caracteres.',
            'user.required' => 'El usuario es requerido.',
            'user.string' => 'El usuario debe ser una cadena de caracteres.',
            'user.unique' => 'El usuario ya existe.',
            'user.max' => 'El usuario no debe exceder los 255 caracteres.',
            'password.required' => 'La contraseña es requerida.',
            'password.string' => 'La contraseña debe ser una cadena de caracteres.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'profile.required' => 'El perfil es requerido.',
            'profile.string' => 'El perfil debe ser una cadena de caracteres.',
            'profile.max' => 'El perfil no debe exceder los 255 caracteres.',
            'url_image.mimes', 'La imagen debe ser de tipo: jpeg, png o jpg',
            'url_image.max', 'La imagen no puede tener un tamaño mayor a 4MB',
            'status.required' => 'El estado es requerido.',
            'status.max' => 'El status no debe exceder los 255 caracteres.',
            'last_login.required' => 'El último login es requerido.',
            'last_login.max' => 'El último login no debe exceder los 255 caracteres.',
        ]);

        // Si no se envían los datos correctamente envío un JSON con los errores
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        // Si no existen problemas con el recibimiento de datos procedemos a guaradar la imagen recibida
        if ($request->hasFile('url_image')) {
            $url = ResizeStorageImage::resizeAndStoreImage(
                $request->file('url_image'),
                'users',
                500,
                500
            );
        } else {
            //si no llega imagen enviamos a guardar un null en la BD en lugar de la URL
            $url = null;
        }

        // Guardamos el usuario en la BD
        $user = User::create([

            'name' => $request->name,
            'user' => $request->user,
            'password' => Hash::make($request->password), //Hasheo el password
            'profile' => $request->profile,
            'url_image' => $url,
            'status' => $request->status,
            'last_Login' => $request->last_Login,

        ]);

        // Genero TOKEN después de guardar
        $token = JWTAuth::fromUser($user);

        //Envío la respuesta con datos del usuario y token generado 
        return response()->json([
            'user' => $user,
            'token' => $token,
            'message' => 'Registrado correctamente'
        ], 201);
    }

    /*=============================================
                =LOGEAR USUARIO=
    =============================================*/

    public function login_user(AuthRequest $AuthRequest)
    {
        $credencials = $AuthRequest->only('user', 'password');

        try {

            if (!$token = JWTAuth::attempt($credencials)) {
                return response()->json([
                    'error' => 'invalid_credentials'
                ], 401);
            }
        } catch (JWTException $e) {
            return response()->json([
                'error' => 'could_not_create_token'
            ], 500);
        }

        $findUser = User::where('user', $AuthRequest->only('user'))->firstOrFail();

        return response()->json([
            'user' => $findUser,
            'token' => compact('token')
        ], 201);
    }

    /*=============================================
                =ACTUALIZAR USUARIO=
    =============================================*/

    public function update_user(Request $request)
    {

        //valido los datos recibidos 
        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'user' => 'string|max:255',
            'password' => 'string|min:8|confirmed',
            'profile' => 'string|max:255',
            'url_image' => 'image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'max:255',
            'last_login' => 'max:255',
        ], [
            'name.string' => 'El nombre debe ser una cadena de caracteres.',
            'name.max' => 'El nombre no debe exceder los 255 caracteres.',
            'user.string' => 'El usuario debe ser una cadena de caracteres.',
            'user.max' => 'El usuario no debe exceder los 255 caracteres.',
            'password.string' => 'La contraseña debe ser una cadena de caracteres.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'profile.string' => 'El perfil debe ser una cadena de caracteres.',
            'profile.max' => 'El perfil no debe exceder los 255 caracteres.',
            'url_image.mimes', 'La imagen debe ser de tipo: jpeg, png o jpg',
            'url_image.max', 'La imagen no puede tener un tamaño mayor a 4MB',
            'status.max' => 'El status no debe exceder los 255 caracteres.',
            'last_login.max' => 'El último login no debe exceder los 255 caracteres.',
        ]);

        // Si no se envían los datos correctamente envío un JSON con los errores
        if ($validator->fails()) {
            return response()->json([
                // 'errors' => $validator->errors()
                'errors' => $validator->errors()
            ], 422);
        }

        // Busco al usuario en mi BD para traer sus datos.
        try {
            $findUser = User::findOrfail($request->id);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'message' => 'Usuario no encontrado',
            ]);
        }

        // Capturo la url de la imagen del usuario encontrado
        $oldImageUrl = $findUser->url_image;

        // Actualizo cada campo 
        $findUser->name = $request->name;
        if ($request->password) {
            $findUser->password = Hash::make($request->password); //Hasheo el password
        }
        $findUser->profile = $request->profile;
        $findUser->status = $request->status;
        if ($request->last_login) {
            $findUser->last_login = $request->last_login;
        }

        // Valido la imagen nueva que llega
        if (!empty($request->url_image)) {

            // Guardar la nueva imagen
            $newImageUrl = ResizeStorageImage::resizeAndStoreImage(
                $request->file('url_image'),
                'users',
                500,
                500
            );

            // Actualizamos la URL de la nueva imagen en la BD
            $findUser->url_image = $newImageUrl;

            // Eliminar la imagen antigua si se cambió
            if ($oldImageUrl && $oldImageUrl !== $newImageUrl) {
                $oldImagePath = public_path(str_replace(url('/'), '', $oldImageUrl));
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
        }

        // Ejecuto método save para guardar
        $findUser->save();

        // Devolver una respuesta adecuada al usuario.
        return response()->json([
            'user' => $findUser,
            'message' => 'Modificado correctamente',
        ]);
    }

    /*=============================================
                =ELIMINAR USUARIO=
    =============================================*/

    public function delete_user(Request $request, $id)
    {

        try {
            $findUser = User::findOrfail($id);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'message' => 'Usuario no encontrado',
            ]);
        }
        if (!empty($findUser->url_image)) {
            $oldImagePath = public_path(str_replace(url('/'), '', $findUser->url_image));
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
        }

        if ($findUser->delete()) {
            return response()->json([

                "message" => 'Eliminado correctamente.'

            ]);
        } else {
            return response()->json([

                "message" => 'No se ha podido eliminar el usuario.'

            ]);
        }
    }


    /*=============================================
                =RENOVAR TOKEN USUARIO=
    =============================================*/
    public function renew_token()
    {
        // $token = JWTAuth::getToken();

        // if (!$token) {
        //     return response()->json(['error' => 'Token no encontrado'], 401);
        // }

        // try {
        //     $refreshedToken = JWTAuth::refresh($token);
        //     return response()->json(['token' => $refreshedToken], 200);
        // } catch (\Exception $e) {
        //     return response()->json(['error' => 'Token no pudo ser refrescado'], 401);
        // }
        $token = JWTAuth::getToken();

        if (!$token) {
            return response()->json(['error' => 'Token no encontrado'], 401);
        }
        try {
            $refreshedToken = JWTAuth::refresh($token);
            $user = JWTAuth::setToken($refreshedToken)->toUser(); // Obtener el usuario actual

            return response()->json([
                'token' => $refreshedToken,
                'user' => $user
            ], 200); // Devolver el token renovado y la información del usuario en la respuesta
        } catch (\Exception $e) {
            return response()->json(['error' => 'Token no pudo ser refrescado'], 401);
        }
    }
}
