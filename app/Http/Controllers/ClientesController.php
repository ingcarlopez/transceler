<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class ClientesController extends Controller
{
    public function index()
    {
        return Inertia::render('Clientes/Index', [
            'filters' => Request::all('search', 'trashed'),
            'clientes' => Auth::user()->cuenta->clientes()
                ->orderBy('cliente')
                ->filter(Request::only('search', 'trashed'))
                ->paginate(10)
                ->withQueryString()
                ->through(fn ($cliente) => [
                    'idcliente' => $cliente->idcliente,
                    'cliente' => $cliente->cliente,
                    'identificacion' => $cliente->identificacion,
                    'dv' => $cliente->dv,
                    'direccion' => $cliente->direccion,
                    'telefono' => $cliente->telefono,
                    'idciudad' => $cliente->idciudad,
                    'fcheliminado' => $cliente->fcheliminado,
                ]),
        ]);
    }

    public function create()
    {
        return Inertia::render('Clientes/Create');
    }

    public function store()
    {
        Auth::user()->cuenta->clientes()->create(
            Request::validate([
                'cliente' => ['required', 'max:100'],
                'email' => ['nullable', 'max:50', 'email'],
                'identificacion' => ['nullable', 'max:50', 'identificacion'],
                'dv' => ['nullable', 'max:50', 'dv'],
                'telefono' => ['nullable', 'max:50'],
                'direccion' => ['nullable', 'max:150'],
                'idciudad' => ['nullable', 'max:50'],
                'region' => ['nullable', 'max:50'],
                'country' => ['nullable', 'max:2'],
                'zipcode' => ['nullable', 'max:25'],
            ])
        );

        return Redirect::route('clientes')->with('success', 'Cliente creado.');
    }

    public function edit(Cliente $cliente)
    {
        return Inertia::render('Clientes/Edit', [
            'cliente' => [
                'idcliente' => $cliente->idcliente,
                'cliente' => $cliente->cliente,
                'email' => $cliente->email,
                'identificacion' => $cliente->identificacion,
                'dv' => $cliente->dv,
                'telefono' => $cliente->telefono,
                'direccion' => $cliente->direccion,
                'idciudad' => $cliente->idciudad,
                'zipcode' => $cliente->zipcode,
                'fcheliminado' => $cliente->fcheliminado,
                'contactos' => $cliente->contactos()->orderByName()->get()->map->only('idcontacto', 'nombres', 'apellidos', 'email', 'telefono', 'direccion'),
            ],
        ]);
    }

    public function update(Cliente $cliente)
    {
        $cliente->update(
            Request::validate([
                'cliente' => ['required', 'max:100'],
                'email' => ['nullable', 'max:50', 'email'],
                'telefono' => ['nullable', 'max:50'],
                'direccion' => ['nullable', 'max:150'],
                'idciudad' => ['nullable', 'max:50'],
                'zipcode' => ['nullable', 'max:25'],
            ])
        );

        return Redirect::back()->with('success', 'Cliente actualizado.');
    }

    public function destroy(Cliente $cliente)
    {
        $cliente->delete();

        return Redirect::back()->with('success', 'Cliente eliminado.');
    }

    public function restore(Cliente $cliente)
    {
        $cliente->restore();

        return Redirect::back()->with('success', 'Cliente recuperado.');
    }
}
