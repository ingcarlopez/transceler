<?php

namespace App\Http\Controllers;

use App\Models\Contacto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class ContactosController extends Controller
{
    public function index()
    {
        return Inertia::render('Contactos/Index', [
            'filters' => Request::all('search', 'trashed'),
            'contactos' => Auth::user()->cuenta->contactos()
                ->with('cliente')
                ->orderByName()
                ->filter(Request::only('search', 'trashed'))
                ->paginate(10)
                ->withQueryString()
                ->through(fn ($contacto) => [
                    'idcontacto' => $contacto->idcontacto,
                    'nombres' => $contacto->nombres,
                    'apellidos' => $contacto->apellidos,
                    'email' => $contacto->email,
                    'telefono' => $contacto->telefono,
                    'direccion' => $contacto->direccion,
                    'cliente' => $contacto->cliente ? $contacto->cliente->only('cliente') : null,
                ]),
        ]);
    }

    public function create()
    {
        return Inertia::render('Contactos/Create', [
            'clientes' => Auth::user()->cuenta
                ->clientes()
                ->orderBy('cliente')
                ->get()
                ->map
                ->only('idcliente', 'cliente'),
        ]);
    }

    public function store()
    {
        Auth::user()->cuenta->contactos()->create(
            Request::validate([
                'nombres' => ['required', 'max:50'],
                'apellidos' => ['required', 'max:50'],
                'idcliente' => ['nullable', Rule::exists('clientes', 'idcliente')->where(function ($query) {
                    $query->where('idcuenta', Auth::user()->idcuenta);
                })],
                'email' => ['nullable', 'max:50', 'email'],
                'telefono' => ['nullable', 'max:50'],
                'direccion' => ['nullable', 'max:150'],
                'idciudad' => ['nullable', 'max:50'],
                'zipcode' => ['nullable', 'max:25'],
            ])
        );

        return Redirect::route('contactos')->with('success', 'Contacto creado.');
    }

    public function edit(Contacto $contacto)
    {
        return Inertia::render('Contactos/Edit', [
            'contacto' => [
                'idcontacto' => $contacto->idcontacto,
                'nombres' => $contacto->nombres,
                'apellidos' => $contacto->apellidos,
                'idcliente' => $contacto->idcliente,
                'email' => $contacto->email,
                'telefono' => $contacto->telefono,
                'direccion' => $contacto->direccion,
                'idciudad' => $contacto->idciudad,
                'zipcode' => $contacto->zipcode,
            ],
            'clientes' => Auth::user()->cuenta->clientes()
                ->orderBy('cliente')
                ->get()
                ->map
                ->only('idcliente', 'cliente'),
        ]);
    }

    public function update(Contacto $contacto)
    {
        $contacto->update(
            Request::validate([
                'nombres' => ['required', 'max:25'],
                'apellidos' => ['required', 'max:25'],
                'idcliente' => [
                    'nullable',
                    Rule::exists('clientes', 'idcliente')->where(fn ($query) => $query->where('idcuenta', Auth::user()->idcuenta)),
                ],
                'email' => ['nullable', 'max:50', 'email'],
                'telefono' => ['nullable', 'max:50'],
                'direccion' => ['nullable', 'max:150'],
                'idciudad' => ['nullable', 'max:50'],
                'zipcode' => ['nullable', 'max:25'],
            ])
        );

        return Redirect::back()->with('success', 'Contacto actualizado.');
    }

    public function destroy(Contacto $contacto)
    {
        $contacto->delete();

        return Redirect::back()->with('success', 'Contacto eliminado.');
    }

    public function restore(Contacto $contacto)
    {
        $contacto->restore();

        return Redirect::back()->with('success', 'Contacto recuperado.');
    }
}
