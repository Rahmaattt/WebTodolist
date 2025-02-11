<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\Todo\TodoController;
use Illuminate\Contracts\Session\Session;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/sesi', [SessionController::class, 'index']);
Route::post('/sesi/login', [SessionController::class, 'login']);
Route::post('/sesi/logout', [SessionController::class, 'logout']);


Route::get('/sesi/register', [SessionController::class, 'register']);
Route::post('/sesi/register', [SessionController::class, 'storeRegister'])->name('kirim');

Route::get('/sesi/lupapw', [SessionController::class, 'lupaPw']);
Route::post('/sesi/lupapw', [SessionController::class, 'lupaPwPost'])->name('lupaPw.post');

Route::get('/sesi/updatepw', [SessionController::class, 'updatePw']);
Route::post('/sesi/updatepw', [SessionController::class, 'updatePwPost'])->name('updatepw.post');

Route::get('/dashboard', [TodoController::class, 'index'])->name('dashboard');
Route::post('/dashboard/add', [TodoController::class, 'store']);
Route::put('dashboard/update/{id_task}', [TodoController::class, 'update'])->name('dashboard.update');
Route::delete('dashboard/{id_task}', [TodoController::class, 'destroy'])->name('dashboard.delete');
Route::post('dashboard/updateStatus/{id_task}', [TodoController::class, 'updateStatus'])->name('dashboard.updateStatus');
Route::post('dashboard/tambahSubtask', [TodoController::class, 'tambahSubtask'])->name('subtask.store');
Route::post('subtask/update/{id_subtask}', [TodoController::class, 'updateStatussub'])
    ->name('subtask.updateStatussub');