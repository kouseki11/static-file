<?php

use App\Http\Controllers\FileController;
use App\Http\Controllers\FolderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;

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

Route::resources([
    'user'=>UserController::class
]);

Route::get('/folder', [FolderController::class, 'index'])->name('folder.index');
Route::post('/folder', [FolderController::class, 'store'])->name('folder.store');
Route::get('/folder/{slug}', [FolderController::class, 'show'])->name('folder.show');

Route::post('/file', [FileController::class, 'store'])->name('file.store');
Route::delete('/file/{id}', [FileController::class, 'destroy'])->name('file.destroy');

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'auth'])->name('login.auth');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
