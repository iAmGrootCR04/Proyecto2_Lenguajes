<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prestamos extends Model
{
    //
    protected $table = 'prestamos';

    protected $fillable = [
        'usuario_id',
        'libro_id',
        'fecha_prestamo',
        'fecha_devolucion',
    ];

}
