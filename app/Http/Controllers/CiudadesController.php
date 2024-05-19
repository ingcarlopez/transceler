<?php

namespace App\Http\Controllers;

use App\Models\Ciudad;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class CiudadesController extends Controller
{
    public function index()
    {
        return Inertia::render('Ciudades/Index', [
            'filters' => Request::all('search', 'trashed'),
            'ciudades' => Ciudad::select('*')
                ->orderBy('ciudad')
                ->filter(Request::only('search', 'trashed'))
                ->paginate(10)
                ->withQueryString()
                ->through(fn ($ciudad) => [
                    'idciudad' => $ciudad->idciudad,
                    'ciudad' => $ciudad->ciudad,
                    'fcheliminado' => $ciudad->fcheliminado,
                ]),
        ]);
    }

    public function create()
    {
        return Inertia::render('Ciudades/Create');
    }

    public function store()
    {
        Ciudad::all()->create(
            Request::validate([
                'idciudad' => ['required', 'max:3'],
                'ciudad' => ['required', 'max:100'],
            ])
        );

        return Redirect::route('ciudades')->with('success', 'Ciudad creada.');
    }

    public function edit(Ciudad $ciudad)
    {
        return Inertia::render('Ciudades/Edit', [
            'ciudad' => [
                'idciudad' => $ciudad->idciudad,
                'ciudad' => $ciudad->ciudad,
                'fcheliminado' => $ciudad->fcheliminado,
            ],
        ]);
    }

    public function update(Ciudad $ciudad)
    {
        $ciudad->update(
            Request::validate([
                'ciudad' => ['required', 'max:30'],
            ])
        );

        return Redirect::back()->with('success', 'Ciudad actualizada.');
    }

    public function destroy(Ciudad $ciudad)
    {
        $ciudad->delete();

        return Redirect::back()->with('success', 'Ciudad eliminada.');
    }

    public function restore(Ciudad $ciudad)
    {
        $ciudad->restore();

        return Redirect::back()->with('success', 'Ciudad recuperada.');
    }
}
