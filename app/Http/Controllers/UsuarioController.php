<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UsuarioController extends Controller
{
    public function index(Request $request)
    {
        $query = trim($request->get('texto'));
        $usuarios = User::where('name', 'like', '%' . $query . '%')
            ->orderBy('id', 'desc')
            ->paginate(5);

        return view('seguridad.usuario.index', ["usuarios" => $usuarios, "texto" => $query]);
    }

    public function create()
    {
        // Obtén todos los roles para mostrarlos en el formulario de creación
        $roles = Role::all();
        return view('seguridad.usuario.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6', // Confirmación de contraseña
            'role' => 'required|string' // Asegúrate de que el rol sea requerido
        ]);

        $usuario = new User;
        $usuario->name = $request->get('name');
        $usuario->email = $request->get('email');
        $usuario->password = bcrypt($request->get('password'));
        $usuario->save();

        // Asignar rol al usuario
        $usuario->assignRole($request->get('role'));

        return redirect()->route('usuario.index')->with('success', 'Usuario creado exitosamente.');
    }


    public function edit($id)
    {
        $usuario = User::findOrFail($id);
        $roles = Role::all(); // Obtén todos los roles para mostrarlos en el formulario de edición
        return view('seguridad.usuario.edit', compact('usuario', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6|confirmed', // Confirmación de contraseña
            'role' => 'required|string' // Asegúrate de que el rol sea requerido
        ]);

        $usuario = User::findOrFail($id);
        $usuario->name = $request->get('name');
        $usuario->email = $request->get('email');

        if ($request->filled('password')) {
            $usuario->password = bcrypt($request->get('password'));
        }

        $usuario->save();

        // Actualizar rol
        $usuario->syncRoles([$request->get('role')]); // Actualiza el rol del usuario

        return redirect()->route('usuario.index')->with('success', 'Usuario actualizado exitosamente.');
    }

    public function show($id)
    {
        $usuario = User::findOrFail($id);
        return view('seguridad.usuario.show', compact('usuario'));
    }

    public function destroy($id)
    {
        $usuario = User::findOrFail($id);
        $usuario->delete();
        return redirect()->route('usuario.index')->with('success', 'Usuario eliminado exitosamente.');
    }
}
