<?php

namespace App\Http\Controllers;

use App\Models\Moneda;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class MonedasController extends Controller
{
    public function index()
    {
        return Inertia::render('Monedas/Index', [
            'filters' => Request::all('search', 'trashed'),
            'monedas' => Moneda::select('*')
                ->orderBy('moneda')
                ->filter(Request::only('search', 'trashed'))
                ->paginate(10)
                ->withQueryString()
                ->through(fn ($moneda) => [
                    'idmoneda' => $moneda->idmoneda,
                    'moneda' => $moneda->moneda,
                    'fcheliminado' => $moneda->fcheliminado,
                ]),
        ]);
    }

    public function create()
    {
        return Inertia::render('Monedas/Create');
    }

    public function store()
    {
        Moneda::all()->create(
            Request::validate([
                'idmoneda' => ['required', 'max:3'],
                'moneda' => ['required', 'max:100'],
            ])
        );

        return Redirect::route('monedas')->with('success', 'Moneda creada.');
    }

    public function edit(Moneda $moneda)
    {
        return Inertia::render('Monedas/Edit', [
            'moneda' => [
                'idmoneda' => $moneda->idmoneda,
                'moneda' => $moneda->moneda,
                'fcheliminado' => $moneda->fcheliminado,
            ],
        ]);
    }

    public function update(Moneda $moneda)
    {
        $moneda->update(
            Request::validate([
                'moneda' => ['required', 'max:30'],
            ])
        );

        return Redirect::back()->with('success', 'Moneda actualizada.');
    }

    public function destroy(Moneda $moneda)
    {
        $moneda->delete();

        return Redirect::back()->with('success', 'Moneda eliminada.');
    }

    public function restore(Moneda $moneda)
    {
        $moneda->restore();

        return Redirect::back()->with('success', 'Moneda recuperada.');
    }
}
