<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Productos extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_category',
        'codigo_producto',
        'descripcion_producto',
        'url_img_producto',
        'stock_producto',
        'precio_compra_producto',
        'precio_venta_producto',
        'ventas_producto',
        'fecha',
    ];
}
