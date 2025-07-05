<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Persona;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Usuario::with(['persona', 'rol'])->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'correo' => 'required|email|unique:usuarios,correo',
            'nombre_usuario' => 'required|unique:usuarios,nombre_usuario',
            'password' => 'required|min:6',
            'id_rol' => 'required|exists:roles,id_rol',
            'id_tipo_documento' => 'required|exists:tipo_documentos,id_tipo_documento',
            'nombres' => 'required',
            'apellidos' => 'required',
            'telefono' => 'required',
            'direccion' => 'required',
        ]);
    
        $persona = Persona::create([
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'id_tipo_documento' => $request->id_tipo_documento,
        ]);
    
        $usuario = Usuario::create([
            'id_persona' => $persona->id_persona,
            'correo' => $request->correo,
            'password' => bcrypt($request->password),
            'foto_perfil' => $request->foto_perfil,
            'estado' => 'activo',
            'id_rol' => $request->id_rol,
            'nombre_usuario' => $request->nombre_usuario,
        ]);
    
        return response()->json($usuario->load(['persona', 'rol']), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return Usuario::with(['persona', 'rol'])->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);
        $usuario->update($request->only(['correo', 'estado', 'foto_perfil']));

        if ($request->has('persona')) {
            $usuario->persona->update($request->persona);
        }

        return response()->json($usuario->load(['persona', 'rol']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $usuario = Usuario::findOrFail($id);
        $usuario->delete();

        return response()->json(['message' => 'Usuario eliminado']);

    }
}
