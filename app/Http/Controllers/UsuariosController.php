<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class UsuariosController extends Controller
{
    public function index()
    {
        return Inertia::render('Usuarios/Index', [
            'filters' => Request::all('search', 'role', 'trashed'),
            'users' => Auth::user()->cuenta->usuarios()
                ->orderByName()
                ->filter(Request::only('search', 'role', 'trashed'))
                ->get()
                ->transform(fn ($usuario) => [
                    'idusuario' => $usuario->idusuario,
                    'nombres' => $usuario->nombres,
                    'apellidos' => $usuario->apellidos,
                    'email' => $usuario->email,
                    'admin' => $usuario->admin,
                    'foto' => $usuario->foto ? URL::route('image', ['path' => $usuario->foto, 'w' => 40, 'h' => 40, 'fit' => 'crop']) : null,
                    'deleted_at' => $usuario->deleted_at,
                ]),
        ]);
    }

    public function create()
    {
        return Inertia::render('Usuarios/Create');
    }

    public function store()
    {
        Request::validate([
            'nombres' => ['required', 'max:50'],
            'apellidos' => ['required', 'max:50'],
            'email' => ['required', 'max:50', 'email', Rule::unique('users')],
            'password' => ['nullable'],
            'admin' => ['required', 'boolean'],
            'foto' => ['nullable', 'image'],
        ]);

        Auth::user()->cuenta->users()->create([
            'nombres' => Request::get('nombres'),
            'apellidos' => Request::get('apellidos'),
            'email' => Request::get('email'),
            'password' => Request::get('password'),
            'admin' => Request::get('admin'),
            'foto' => Request::file('foto') ? Request::file('foto')->store('users') : null,
        ]);

        return Redirect::route('users')->with('success', 'Usuario creado.');
    }

    public function edit(Usuario $usuario)
    {
        return Inertia::render('Usuarios/Edit', [
            'user' => [
                'idusuario' => $usuario->idusuario,
                'nombres' => $usuario->nombres,
                'apellidos' => $usuario->apellidos,
                'email' => $usuario->email,
                'admin' => $usuario->admin,
                'foto' => $usuario->foto ? URL::route('image', ['path' => $usuario->foto, 'w' => 60, 'h' => 60, 'fit' => 'crop']) : null,
                'deleted_at' => $usuario->deleted_at,
            ],
        ]);
    }

    public function update(Usuario $usuario)
    {
        if (App::environment('demo') && $usuario->isDemoUsuario()) {
            return Redirect::back()->with('error', 'Updating the demo user is not allowed.');
        }

        Request::validate([
            'nombres' => ['required', 'max:50'],
            'apellidos' => ['required', 'max:50'],
            'email' => ['required', 'max:50', 'email', Rule::unique('usuarios')->ignore($usuario->idusuario)],
            'password' => ['nullable'],
            'admin' => ['required', 'boolean'],
            'foto' => ['nullable', 'image'],
        ]);

        $usuario->update(Request::only('nombres', 'apellidos', 'email', 'admin'));

        if (Request::file('foto')) {
            $usuario->update(['foto' => Request::file('foto')->store('usuarios')]);
        }

        if (Request::get('password')) {
            $usuario->update(['password' => Request::get('password')]);
        }

        return Redirect::back()->with('success', 'Usuario updated.');
    }

    public function destroy(Usuario $usuario)
    {
        if (App::environment('demo') && $usuario->isDemoUsuario()) {
            return Redirect::back()->with('error', 'Deleting the demo user is not allowed.');
        }

        $usuario->delete();

        return Redirect::back()->with('success', 'Usuario deleted.');
    }

    public function restore(Usuario $usuario)
    {
        $usuario->restore();

        return Redirect::back()->with('success', 'Usuario restored.');
    }
}
