<?php

namespace App\Http\Controllers;

use App\Models\Pais;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class PaisesController extends Controller
{
    public function index()
    {
        return Inertia::render('Paises/Index', [
            'filters' => Request::all('search', 'trashed'),
            'paises' => Pais::select('*')
                ->orderBy('pais')
                ->filter(Request::only('search', 'trashed'))
                ->paginate(10)
                ->withQueryString()
                ->through(fn ($pais) => [
                    'idpais' => $pais->idpais,
                    'pais' => $pais->pais,
                    'fcheliminado' => $pais->fcheliminado,
                ]),
        ]);
    }

    public function create()
    {
        return Inertia::render('Paises/Create');
    }

    public function store()
    {
        Pais::all()->create(
            Request::validate([
                'idpais' => ['required', 'max:3'],
                'pais' => ['required', 'max:100'],
            ])
        );

        return Redirect::route('paises')->with('success', 'Pais creada.');
    }

    public function edit(Pais $pais)
    {
        return Inertia::render('Paises/Edit', [
            'pais' => [
                'idpais' => $pais->idpais,
                'pais' => $pais->pais,
                'fcheliminado' => $pais->fcheliminado,
            ],
        ]);
    }

    public function update(Pais $pais)
    {
        $pais->update(
            Request::validate([
                'pais' => ['required', 'max:30'],
            ])
        );

        return Redirect::back()->with('success', 'Pais actualizada.');
    }

    public function destroy(Pais $pais)
    {
        $pais->delete();

        return Redirect::back()->with('success', 'Pais eliminada.');
    }

    public function restore(Pais $pais)
    {
        $pais->restore();

        return Redirect::back()->with('success', 'Pais recuperada.');
    }
}
