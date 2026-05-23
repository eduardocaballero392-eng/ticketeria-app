<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'cliente';
    protected $primaryKey = 'id_cliente';
    public $incrementing = true;

    protected $fillable = [
        'razon_social',
        'ruc',
        'sedes',
        'rubro',
        'correo',
        'contraseña',
        'activo',
    ];

    protected $hidden = [
        'contraseña',
    ];
}