<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UsuarioController extends Controller
{
    /**
     * GET /api/usuarios
     * Listar todos los usuarios (Equivalente al findAll() de JPA)
     */
    public function index()
    {
        $usuarios = User::all();
        return response()->json($usuarios, 200);
    }
    /**
     * POST /api/usuarios
     * Crear un nuevo usuario (Equivalente al save() en Spring)
     */
    public function store(Request $request)
    {
        // 1. Validar los datos de entrada (Como las anotaciones @Valid o @NotNull de Java)
        $validator = Validator::make($request->all(), [
            'username'  => 'required|string|unique:users,username|max:255',
            'email'     => 'required|string|email|unique:users,email|max:255',
            'password'  => 'required|string|min:6',
            'role'      => 'required|string',
            'full_name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // 2. Crear el usuario
        // Nota: Gracias al cast 'hashed' que pusimos en el Modelo User, 
        // Laravel encriptará la contraseña automáticamente al guardarla.
        $user = User::create([
            'username'  => $request->username,
            'email'     => $request->email,
            'password'  => $request->password, 
            'role'      => $request->role,
            'full_name' => $request->full_name,
        ]);

        return response()->json([
            'message' => 'Usuario creado con éxito',
            'data'    => $user
        ], 21);
    }

    /**
     * GET /api/usuarios/{id}
     * Mostrar un usuario específico (findById())
     */
    public function show(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        // Si quieres que incluya sus préstamos asociados, puedes cargarlos así:
        // $user->load('loans');

        return response()->json($user, 200);
    }

    /**
     * PUT /api/usuarios/{id}
     * Actualizar un usuario existente
     */
    public function update(Request $request, string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        // Validar (ignorando el unique para el ID del usuario actual)
        $validator = Validator::make($request->all(), [
            'username'  => 'string|unique:users,username,' . $id . '|max:255',
            'email'     => 'string|email|unique:users,email,' . $id . '|max:255',
            'password'  => 'string|min:6',
            'role'      => 'string',
            'full_name' => 'string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Actualizar solo los campos que vengan en la petición
        if ($request->has('password')) {
            $user->password = $request->password; // se encripta por el Cast del modelo
        }
        
        $user->update($request->only(['username', 'email', 'role', 'full_name']));

        return response()->json([
            'message' => 'Usuario actualizado con éxito',
            'data'    => $user
        ], 200);
    }

    /**
     * DELETE /api/usuarios/{id}
     * Eliminar un usuario (deleteById())
     */
    public function destroy(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'Usuario eliminado correctamente'], 200);
    }
}
