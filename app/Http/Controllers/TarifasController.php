<?php

namespace App\Http\Controllers;

use App\Models\Tarifa;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class TarifasController extends Controller
{
    public function index()
    {
        return Inertia::render('Tarifas/Index', [
            'filters' => Request::all('search', 'trashed'),
            'tarifas' => Tarifa::select('*')
                ->orderBy('idconcepto')x
                ->filter(Request::only('search', 'trashed'))
                ->paginate(10)
                ->withQueryString()
                ->through(fn ($tarifa) => [
                    'idtarifa' => $tarifa->idtarifa,
                    'idconcepto' => $tarifa->idconcepto,
                    'vigencia' => $tarifa->vigencia,
                    'valor_neto' => $tarifa->valor_neto,
                    'valor_venta' => $tarifa->valor_venta,
                    'idmoneda' => $tarifa->idmoneda,
                    'fcheliminado' => $tarifa->fcheliminado,
                ]),
        ]);
    }

    public function create()
    {
        return Inertia::render('Tarifas/Create');
    }

    public function store()
    {
        Tarifa::all()->create(
            Request::validate([
                'vigencia' => ['required', 'max:10'],
                'valor_neto' => ['required', 'max:100'],
                'valor_venta' => ['required', 'max:100'],
                'idmoneda' => ['required', 'max:3'],
            ])
        );

        return Redirect::route('tarifas')->with('success', 'Tarifa creada.');
    }

    public function edit(Tarifa $tarifa)
    {
        return Inertia::render('Tarifas/Edit', [
            'tarifa' => [
                'idtarifa' => $tarifa->idtarifa,
                'vigencia' => $tarifa->vigencia,
                'valor_neto' => $tarifa->valor_neto,
                'valor_venta' => $tarifa->valor_venta,
                'idmoneda' => $tarifa->idmoneda,
                'fcheliminado' => $tarifa->fcheliminado,
        ],
        ]);
    }

    public function update(Tarifa $tarifa)
    {
        $tarifa->update(
            Request::validate([
                'vigencia' => ['required', 'max:10'],
                'valor_neto' => ['required', 'max:100'],
                'valor_venta' => ['required', 'max:100'],
                'idmoneda' => ['required', 'max:3'],
            ])
        );

        return Redirect::back()->with('success', 'Tarifa actualizada.');
    }

    public function destroy(Tarifa $tarifa)
    {
        $tarifa->delete();

        return Redirect::back()->with('success', 'Tarifa eliminada.');
    }

    public function restore(Tarifa $tarifa)
    {
        $tarifa->restore();

        return Redirect::back()->with('success', 'Tarifa recuperada.');
    }
}
