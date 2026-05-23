<?php

namespace App\Models;
use App\Models\Cargo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Tecnico extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'tecnico';
    
    protected $primaryKey = 'id_tecnico';
    
    public $incrementing = true;

    protected $fillable = [
        'codigo_tecnico',
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'dni',
        'correo',
        'contraseña',
        'id_cargo',
        'activo',
        'telefono',
        'codigo_pais',
    ];

    protected $hidden = [
        'contraseña',
        'remember_token',
    ];

    // Relación con Cargo
    public function cargo()
    {
        return $this->belongsTo(Cargo::class, 'id_cargo', 'id_cargo');
    }

    // Nombre completo
    public function getNombreCompletoAttribute()
    {
        return trim("{$this->nombre} {$this->apellido_paterno} {$this->apellido_materno}");
    }

    // Helpers simples (por ahora solo Técnico y Admin)
    public function esAdmin()
    {
        return optional($this->cargo)->nombre_cargo === 'Administrador';
    }

    public function esTecnico()
    {
        return optional($this->cargo)->nombre_cargo === 'Técnico';
    }
}