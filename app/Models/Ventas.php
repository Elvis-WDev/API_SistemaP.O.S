<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ventas extends Model
{
    use HasFactory;
    protected $fillable = [
        'codigo_venta',
        'id_cliente',
        'id_vendedor',
        'productos_venta',
        'impuesto_venta',
        'neto_venta',
        'total',
        'metodo_pago',
        'fecha',
    ];
}
