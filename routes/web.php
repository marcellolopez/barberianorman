<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginAdminController;
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


Route::get('admin/login', [LoginAdminController::class, 'viewLogin'])->name('admin/login');
Route::post('admin/loginForm', [LoginAdminController::class, 'authenticate'])->name('admin/loginForm');
Route::get('admin', [LoginAdminController::class, 'index'])->middleware('canAccessAdministrador');

Route::get('admin/index', [AdminController::class, 'index'])->middleware('canAccessAdministrador');
Route::get('admin/agenda', [AdminController::class, 'agendarCliente'])->middleware('canAccessAdministrador');
Route::get('admin/verClientes', [AdminController::class, 'verClientes'])->middleware('canAccessAdministrador');
Route::get('admin/verBarberos', [AdminController::class, 'verBarberos'])->middleware('canAccessAdministrador');
Route::get('admin/getClientes', [AdminController::class, 'getClientesDatatables'])->middleware('canAccessAdministrador');
Route::get('admin/getBarberos', [AdminController::class, 'getBarberosDatatables'])->middleware('canAccessAdministrador');
Route::get('admin/reportes', [AdminController::class, 'exportarExcel'])->middleware('canAccessAdministrador');
Route::post('admin/menu', [AdminController::class, 'menu'])->middleware('canAccessAdministrador');
Route::get('admin/logout', [LoginAdminController::class, 'logout'])->middleware('canAccessAdministrador');

Route::post('actualizarHora', [AdminController::class, 'actualizarHora']);
Route::get('cargarAgendaBarbero', [AdminController::class, 'cargarAgendaBarbero'])->middleware('canAccessAdministrador');
Route::get('cargarProgramacionBarbero', [AdminController::class, 'cargarProgramacionBarbero'])->middleware('canAccessAdministrador');
Route::post('guardarProgramacionBarbero', [AdminController::class, 'guardarProgramacionBarbero'])->middleware('canAccessAdministrador');
Route::get('calendarioBarbero', [AdminController::class, 'calendarioBarberoAjax'])->middleware('canAccessAdministrador');

Route::post('actualizarBarbero', [BarberoController::class, 'actualizarBarbero']);

Route::get('bizagi', [ArchivosController::class, 'bizagi']);
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
