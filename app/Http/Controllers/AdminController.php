<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Constructor del controlador.
     * Aplica el middleware para proteger las rutas solo a usuarios con el rol de 'admin'.
     */
    public function __construct()
    {
        $this->middleware('role:admin');
    }

    /**
     * Muestra el dashboard del administrador.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Puedes cargar datos específicos para el dashboard del administrador aquí
        return view('admin.dashboard');
    }

    /**
     * Muestra la lista de usuarios.
     *
     * @return \Illuminate\View\View
     */
    public function users()
    {
        $users = \App\Models\User::all(); // Obtiene todos los usuarios
        return view('admin.users', compact('users'));
    }

    /**
     * Muestra los detalles de un usuario específico.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function showUser($id)
    {
        $user = \App\Models\User::findOrFail($id); // Encuentra el usuario por ID o falla
        return view('admin.user-details', compact('user'));
    }

    /**
     * Crea un nuevo usuario.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = \App\Models\User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);

        $user->assignRole('user'); // Asigna un rol por defecto

        return redirect()->route('admin.users')->with('success', 'Usuario creado con éxito.');
    }
}
