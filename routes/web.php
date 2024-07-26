<?php

use App\Http\Controllers\Rapat\HasilRapatController;
use App\Http\Controllers\Rapat\UndanganRapatController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('rapat/undangan/{rapat}', UndanganRapatController::class)->name('rapat.undangan');
Route::get('rapat/hasil/{rapat}', HasilRapatController::class)->name('rapat.hasil');
