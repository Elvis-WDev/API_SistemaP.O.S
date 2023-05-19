<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ControllerUser extends Controller
{
    /*=============================================
                =LISTAR USUARIO=
    =============================================*/

    public function index()
    {
        $users = User::all();
        return response()->json($users, 201);
    }
}
