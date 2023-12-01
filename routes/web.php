<?php

use App\Http\Controllers\PeriodoController;
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\LabHorarioController;
use App\Http\Controllers\LaboratorioController;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\SemestreController;
use App\Http\Controllers\CarreraController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Models\Periodo;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('users', UserController::class);
Route::resource('docentes', DocenteController::class);
Route::resource('carreras', CarreraController::class);
Route::resource('horarios', HorarioController::class);
Route::resource('carreras.semestres', SemestreController::class);
Route::resource('semestres.horario', PeriodoController::class);
Route::resource('semestres.materias', MateriaController::class);
Route::resource('laboratorios', LaboratorioController::class);
Route::resource('laboratorios.horario', LabHorarioController::class);

Route::post('/guardar_registro_periodo', [App\Http\Controllers\PeriodoController::class, 'guardarRegistro'])->name('guardar_registro_periodo');
Route::post('/eliminar_periodo', [App\Http\Controllers\PeriodoController::class, 'eliminarRegistro'])->name('eliminar_periodo');
Route::post('buscar_carrera', [App\Http\Controllers\LabHorarioController::class, 'carrera_buscar'])->name('buscar_carrera');
Route::post('buscar_semestre', [App\Http\Controllers\LabHorarioController::class, 'semestre_buscar'])->name('buscar_semestre');