<?php

// Desarrollador: David Forero
// Version 1.0

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\ContraseController;
use App\Http\Controllers\UsuarioController;


//ruta principal
Route::get('/', function () {
    return view('auth.login');
});

//ruta para paciente cliente
Route::get('/cliente', function () {
    return view('cliente.cliente');
});

 
//middleware() para que respete la autenticacion
Route::resource('paciente',PacienteController::class)->middleware('auth');
// Route::resource('pdf',PDFController::class)->middleware('auth');
Route::resource('usuario',UsuarioController::class)->middleware('auth');

//cancela opcion registro en la vista del login
Auth::routes(['register'=>false]);
// Auth::routes();

//Agrupar rutas que comparten un Middleware
Route::group(['middleware' => 'auth'], function () {
    //Muestra todo los pacientes
    Route::get('/home', [PacienteController::class, 'index'])->name('home');
    //Muestra todo los usuarios
    Route::get('/usuario', [UsuarioController::class, 'index'])->name('usuario');
    //Redirige al formulario de registro
    Route::get('/registro', [UsuarioController::class, 'showForm'])->name('registro');
    //Crear registro de usuario nuevo
    Route::post('/crearR', [UsuarioController::class, 'create'])->name('crearR');
});

// Rutas publicas
Route::get('/validar', [ContraseController::class, 'ValidarC'])->name('validarCon');
Route::get('/pdf/{id}', [PDFController::class, 'show'])->name('descargar');
