<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';
    protected $fillable = [
        'id_persona', 'correo', 'password', 'foto_perfil', 'estado', 'id_rol', 'nombre_usuario'
    ];
    public function persona()
    {
        return $this->belongsTo(Persona::class, 'id_persona');
    }
        
    public function rol()
    {
        return $this->belongsTo(Rol::class, 'id_rol');
    }
}
