<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'cedula',
        'email',
        'telefono',
        'direccion',
        'fecha_nacimiento',
        'compras_cliente',
        'ultima_compra',
        'fecha_registro',
    ];
}
