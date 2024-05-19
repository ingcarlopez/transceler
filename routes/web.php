<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ContactosController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImagesController;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\MonedasController;
use App\Http\Controllers\PaisesController;
use App\Http\Controllers\CiudadesController;
use App\Http\Controllers\ConceptosController;
use App\Http\Controllers\TarifasController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Auth

Route::get('login', [AuthenticatedSessionController::class, 'create'])
    ->name('login')
    ->middleware('guest');

Route::post('login', [AuthenticatedSessionController::class, 'store'])
    ->name('login.store')
    ->middleware('guest');

Route::delete('logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

// Dashboard

Route::get('/', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->middleware('auth');

// Users

Route::get('usuarios', [UsuariosController::class, 'index'])
    ->name('usuarios')
    ->middleware('auth');

Route::get('usuarios/create', [UsuariosController::class, 'create'])
    ->name('usuarios.create')
    ->middleware('auth');

Route::post('usuarios', [UsuariosController::class, 'store'])
    ->name('usuarios.store')
    ->middleware('auth');

Route::get('usuarios/{usuario}/edit', [UsuariosController::class, 'edit'])
    ->name('usuarios.edit')
    ->middleware('auth');

Route::put('usuarios/{usuario}', [UsuariosController::class, 'update'])
    ->name('usuarios.update')
    ->middleware('auth');

Route::delete('usuarios/{usuario}', [UsuariosController::class, 'destroy'])
    ->name('usuarios.destroy')
    ->middleware('auth');

Route::put('usuarios/{usuario}/restore', [UsuariosController::class, 'restore'])
    ->name('usuarios.restore')
    ->middleware('auth');

// Clientes

Route::get('clientes', [ClientesController::class, 'index'])
    ->name('clientes')
    ->middleware('auth');

Route::get('clientes/create', [ClientesController::class, 'create'])
    ->name('clientes.create')
    ->middleware('auth');

Route::post('clientes', [ClientesController::class, 'store'])
    ->name('clientes.store')
    ->middleware('auth');

Route::get('clientes/{cliente}/edit', [ClientesController::class, 'edit'])
    ->name('clientes.edit')
    ->middleware('auth');

Route::put('clientes/{cliente}', [ClientesController::class, 'update'])
    ->name('clientes.update')
    ->middleware('auth');

Route::delete('clientes/{cliente}', [ClientesController::class, 'destroy'])
    ->name('clientes.destroy')
    ->middleware('auth');

Route::put('clientes/{cliente}/restore', [ClientesController::class, 'restore'])
    ->name('clientes.restore')
    ->middleware('auth');

// Contactos

Route::get('contactos', [ContactosController::class, 'index'])
    ->name('contactos')
    ->middleware('auth');

Route::get('contactos/create', [ContactosController::class, 'create'])
    ->name('contactos.create')
    ->middleware('auth');

Route::post('contactos', [ContactosController::class, 'store'])
    ->name('contactos.store')
    ->middleware('auth');

Route::get('contactos/{contacto}/edit', [ContactosController::class, 'edit'])
    ->name('contactos.edit')
    ->middleware('auth');

Route::put('contactos/{contacto}', [ContactosController::class, 'update'])
    ->name('contactos.update')
    ->middleware('auth');

Route::delete('contactos/{contacto}', [ContactosController::class, 'destroy'])
    ->name('contactos.destroy')
    ->middleware('auth');

Route::put('contactos/{contacto}/restore', [ContactosController::class, 'restore'])
    ->name('contactos.restore')
    ->middleware('auth');

// Monedas

Route::get('monedas', [MonedasController::class, 'index'])
    ->name('monedas')
    ->middleware('auth');

Route::get('monedas/create', [MonedasController::class, 'create'])
    ->name('monedas.create')
    ->middleware('auth');

Route::post('monedas', [MonedasController::class, 'store'])
    ->name('monedas.store')
    ->middleware('auth');

Route::get('monedas/{moneda}/edit', [MonedasController::class, 'edit'])
    ->name('monedas.edit')
    ->middleware('auth');

Route::put('monedas/{moneda}', [MonedasController::class, 'update'])
    ->name('monedas.update')
    ->middleware('auth');

Route::delete('monedas/{moneda}', [MonedasController::class, 'destroy'])
    ->name('monedas.destroy')
    ->middleware('auth');

Route::put('monedas/{moneda}/restore', [MonedasController::class, 'restore'])
    ->name('monedas.restore')
    ->middleware('auth');

// Paises

Route::get('paises', [PaisesController::class, 'index'])
    ->name('paises')
    ->middleware('auth');

Route::get('paises/create', [PaisesController::class, 'create'])
    ->name('paises.create')
    ->middleware('auth');

Route::post('paises', [PaisesController::class, 'store'])
    ->name('paises.store')
    ->middleware('auth');

Route::get('paises/{pais}/edit', [PaisesController::class, 'edit'])
    ->name('paises.edit')
    ->middleware('auth');

Route::put('paises/{pais}', [PaisesController::class, 'update'])
    ->name('paises.update')
    ->middleware('auth');

Route::delete('paises/{pais}', [PaisesController::class, 'destroy'])
    ->name('paises.destroy')
    ->middleware('auth');

Route::put('paises/{pais}/restore', [PaisesController::class, 'restore'])
    ->name('paises.restore')
    ->middleware('auth');

// Ciudades

Route::get('ciudades', [CiudadesController::class, 'index'])
    ->name('ciudades')
    ->middleware('auth');

Route::get('ciudades/create', [CiudadesController::class, 'create'])
    ->name('ciudades.create')
    ->middleware('auth');

Route::post('ciudades', [CiudadesController::class, 'store'])
    ->name('ciudades.store')
    ->middleware('auth');

Route::get('ciudades/{ciudad}/edit', [CiudadesController::class, 'edit'])
    ->name('ciudades.edit')
    ->middleware('auth');

Route::put('ciudades/{ciudad}', [CiudadesController::class, 'update'])
    ->name('ciudades.update')
    ->middleware('auth');

Route::delete('ciudades/{ciudad}', [CiudadesController::class, 'destroy'])
    ->name('ciudades.destroy')
    ->middleware('auth');

Route::put('ciudades/{ciudad}/restore', [CiudadesController::class, 'restore'])
    ->name('ciudades.restore')
    ->middleware('auth');

// Conceptos

Route::get('conceptos', [ConceptosController::class, 'index'])
    ->name('conceptos')
    ->middleware('auth');

Route::get('conceptos/create', [ConceptosController::class, 'create'])
    ->name('conceptos.create')
    ->middleware('auth');

Route::post('conceptos', [ConceptosController::class, 'store'])
    ->name('conceptos.store')
    ->middleware('auth');

Route::get('conceptos/{concepto}/edit', [ConceptosController::class, 'edit'])
    ->name('conceptos.edit')
    ->middleware('auth');

Route::put('conceptos/{concepto}', [ConceptosController::class, 'update'])
    ->name('conceptos.update')
    ->middleware('auth');

Route::delete('conceptos/{concepto}', [ConceptosController::class, 'destroy'])
    ->name('conceptos.destroy')
    ->middleware('auth');

Route::put('conceptos/{concepto}/restore', [ConceptosController::class, 'restore'])
    ->name('conceptos.restore')
    ->middleware('auth');

// Tarifas

Route::get('tarifas', [TarifasController::class, 'index'])
    ->name('tarifas')
    ->middleware('auth');

Route::get('tarifas/create', [TarifasController::class, 'create'])
    ->name('tarifas.create')
    ->middleware('auth');

Route::post('tarifas', [TarifasController::class, 'store'])
    ->name('tarifas.store')
    ->middleware('auth');

Route::get('tarifas/{tarifa}/edit', [TarifasController::class, 'edit'])
    ->name('tarifas.edit')
    ->middleware('auth');

Route::put('tarifas/{tarifa}', [TarifasController::class, 'update'])
    ->name('tarifas.update')
    ->middleware('auth');

Route::delete('tarifas/{tarifa}', [TarifasController::class, 'destroy'])
    ->name('tarifas.destroy')
    ->middleware('auth');

Route::put('tarifas/{tarifa}/restore', [TarifasController::class, 'restore'])
    ->name('tarifas.restore')
    ->middleware('auth');

// Reports

Route::get('reports', [ReportsController::class, 'index'])
    ->name('reports')
    ->middleware('auth');

// Images

Route::get('/img/{path}', [ImagesController::class, 'show'])
    ->where('path', '.*')
    ->name('image');
