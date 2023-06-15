<?php

use App\Http\Controllers\ActsController;
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
Route::get('/', [ActsController::class, 'index'])->name('main');
Route::get('detail', [ActsController::class, 'detail'])->name('detail');
Route::get('search', [ActsController::class, 'search'])->name('search');
Route::post('addQuestion', [ActsController::class, 'addQuestion'])->name('addQuestion');
