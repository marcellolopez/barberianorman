<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BarberoController;
use App\Http\Controllers\ArchivosController;

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
Route::get('/', [IndexController::class, 'index']);

Route::post('consultarCliente', [ClienteController::class, 'consultarCliente']);
Route::post('registrarCliente', [ClienteController::class, 'registrarCliente']);
Route::post('registrarReserva', [ClienteController::class, 'registrarReserva']);

Route::get('cargarAgenda', [AgendaController::class, 'cargarAgenda']);
Route::post('reservarHora', [AgendaController::class, 'reservarHora']);


Route::get('send', 'IndexController@send');


Route::get('admin/login', [AdminController::class, 'viewLogin']);
Route::get('admin/index', [AdminController::class, 'index']);
Route::get('admin/agenda', [AdminController::class, 'agendarCliente']);
Route::get('admin/registros', [AdminController::class, 'verRegistros']);
Route::get('admin/getClientes', [AdminController::class, 'getClientesDatatables']);
Route::get('admin/reportes', [AdminController::class, 'exportarExcel']);


Route::get('cargarAgendaBarbero', [AdminController::class, 'cargarAgendaBarbero']);
Route::get('cargarProgramacionBarbero', [AdminController::class, 'cargarProgramacionBarbero']);
Route::post('guardarProgramacionBarbero', [AdminController::class, 'guardarProgramacionBarbero']);
Route::get('calendarioBarbero', [AdminController::class, 'calendarioBarberoAjax']);

Route::post('actualizarBarbero', [BarberoController::class, 'actualizarBarbero']);

Route::get('bizagi', [ArchivosController::class, 'bizagi']);