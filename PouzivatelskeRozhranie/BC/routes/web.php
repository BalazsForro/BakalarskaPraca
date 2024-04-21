<?php

use App\Http\Controllers\DataController;
use Illuminate\Support\Facades\Route;

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


Route::get('/', [DataController::class, 'aktualny'])->name('aktualny');
Route::get('/aktualny', [DataController::class, 'aktualny'])->name('aktualny');

Route::get('/grafNapatia', [DataController::class, 'grafNapatia'])->name('grafNapatia');
Route::get('/grafNapatia/ajax', [DataController::class, 'grafNapatiaAjax'])->name('grafNapatiaAjax');

Route::get('/grafPrudu', [DataController::class, 'grafPrudu'])->name('grafPrudu');
Route::get('/grafPrudu/ajax', [DataController::class, 'grafPruduAjax'])->name('grafPruduAjax');

Route::get('/grafVykonu', [DataController::class, 'grafVykonu'])->name('grafVykonu');
Route::get('/grafVykonu/ajax', [DataController::class, 'grafVykonuAjax'])->name('grafVykonuAjax');

Route::get('/grafSvetelnosti', [DataController::class, 'grafSvetelnosti'])->name('grafSvetelnosti');
Route::get('/grafSvetelnosti/ajax', [DataController::class, 'grafSvetelnostiAjax'])->name('grafSvetelnostiAjax');

Route::get('/vsetky', [DataController::class, 'vsetky'])->name('vsetky');


Route::get('/get-data/{deviceId}', [DataController::class, 'getData'])->name('get.data');
