<?php

use App\Http\Controllers\ProfileController;
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

Route::get('/index', [App\Http\Controllers\TaskController::class, 'index'])->name('index');
Route::get('/create', [App\Http\Controllers\TaskController::class, 'showCreate'])->name('show.create');
Route::post('/create', [App\Http\Controllers\TaskController::class, 'storeTask'])->name('store.task');
Route::get('/edit/{id}', [App\Http\Controllers\TaskController::class, 'showEdit'])->name('show.edit');
Route::post('/edit/{id}', [App\Http\Controllers\TaskController::class, 'registEdit'])->name('update.task');
Route::delete('/delete/{id}', [App\Http\Controllers\TaskController::class, 'deleteTask'])->name('delete');



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/header', function () {
    return view('header');
})->name('header');

//プロフィール機能
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
