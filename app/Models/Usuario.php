<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    protected $table = 'usuario';
    
    protected $primaryKey = 'id_usuario';
    
    public $incrementing = true;
    
    protected $fillable = [
        'id_cliente',
        'codigo_usuario',
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'dni',
        'codigo_pais',
        'telefono',
        'correo',
        'contraseña',
        'activo',
    ];

    protected $hidden = [
        'contraseña',
    ];
}