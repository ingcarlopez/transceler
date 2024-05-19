<?php

namespace App\Http\Controllers;

use App\Models\Concepto;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class ConceptosController extends Controller
{
    public function index()
    {
        return Inertia::render('Conceptos/Index', [
            'filters' => Request::all('search', 'trashed'),
            'conceptos' => Concepto::select('*')
                ->orderBy('concepto_esp')
                ->filter(Request::only('search', 'trashed'))
                ->paginate(10)
                ->withQueryString()
                ->through(fn ($concepto) => [
                    'idconcepto' => $concepto->idconcepto,
                    'concepto_esp' => $concepto->concepto_esp,
                    'concepto_eng' => $concepto->concepto_eng,
                    'fcheliminado' => $concepto->fcheliminado,
                ]),
        ]);
    }

    public function create()
    {
        return Inertia::render('Conceptos/Create');
    }

    public function store()
    {
        // Concepto::all()->create(
            Concepto::Create(
            Request::validate([
                'concepto_esp' => ['required', 'max:100'],
                'concepto_eng' => ['required', 'max:100'],
            ])
        );

        return Redirect::route('conceptos')->with('success', 'Concepto creado.');
    }

    public function edit(Concepto $concepto)
    {
        return Inertia::render('Conceptos/Edit', [
            'concepto' => [
                'idconcepto' => $concepto->idconcepto,
                'concepto_esp' => $concepto->concepto_esp,
                'concepto_eng' => $concepto->concepto_eng,
                'fcheliminado' => $concepto->fcheliminado,
                'tarifas' => $concepto->tarifas()->get()->map->only('idtarifa', 'vigencia', 'valor_neto', 'valor_venta', 'idmoneda'),
            ],
        ]);
    }

    public function update(Concepto $concepto)
    {
        $concepto->update(
            Request::validate([
                'concepto_esp' => ['required', 'max:30'],
                'concepto_eng' => ['required', 'max:30'],
            ])
        );

        return Redirect::back()->with('success', 'Concepto actualizado.');
    }

    public function destroy(Concepto $concepto)
    {
        $concepto->delete();

        return Redirect::back()->with('success', 'Concepto eliminado.');
    }

    public function restore(Concepto $concepto)
    {
        $concepto->restore();

        return Redirect::back()->with('success', 'Concepto recuperado.');
    }
}
