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


Route::get('admin/login', [AdminController::class, 'admin/login']);
Route::get('admin/index', [AdminController::class, 'admin/index']);
Route::get('admin/agenda', [AdminController::class, 'admin/agenda']);
Route::get('admin/registros', [AdminController::class, 'admin/registros']);
Route::get('admin/getClientes', [AdminController::class, 'admin/getClientes']);
Route::get('admin/reportes', [AdminController::class, 'admin/reportes']);


Route::get('cargarAgendaBarbero', [AdminController::class, 'cargarAgendaBarbero']);
Route::get('cargarProgramacionBarbero', [AdminController::class, 'cargarProgramacionBarbero']);
Route::get('guardarProgramacionBarbero', [AdminController::class, 'guardarProgramacionBarbero']);
Route::get('calendarioBarbero', [AdminController::class, 'calendarioBarbero']);

Route::get('actualizarBarbero', [BarberoController::class, 'actualizarBarbero']);

Route::get('bizagi', [ArchivosController::class, 'bizagi']);