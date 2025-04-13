<?php

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Mail\Notifikasi;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\Todo\TodoController;
use App\Http\Controllers\Todo\TaskController;
use App\Http\Controllers\Todo\SubtaskController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MailController;
use Illuminate\Contracts\Session\Session;

Route::get('/doc', function () {
    return view('welcome');
});

Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
Route::post('/profile', [ProfileController::class, 'profile'])->name('profile.update');

Route::post('/subtask/update', [TodoController::class, 'updateSubtask'])->name('subtask.updateSubtask');



Route::get('/send-notification/{id_task}', [MailController::class, 'sendEmail']);

Route::get('/', [SessionController::class, 'index']);
Route::post('/sesi/login', [SessionController::class, 'login']);
Route::post('/sesi/logout', [SessionController::class, 'logout']);


Route::get('/sesi/register', [SessionController::class, 'register']);
Route::post('/sesi/register', [SessionController::class, 'storeRegister'])->name('kirim');

Route::get('/sesi/lupapw', [ResetPasswordController::class, 'lupaPw']);
Route::post('/sesi/lupapw', [ResetPasswordController::class, 'lupaPwPost'])->name('lupaPw.post');

Route::get('/sesi/updatepw/{token}', [ResetPasswordController::class, 'updatePw']);
Route::post('/sesi/updatepw', [ResetPasswordController::class, 'updatePwPost'])->name('updatepw.post');

Route::get('/dashboard', [TodoController::class, 'index'])->name('dashboard');
Route::post('/dashboard/add', [TaskController::class, 'store'])->name('dashboard.store');
Route::post('/dashboard/update/{id_task}', [TaskController::class, 'update'])->name('dashboard.update');
Route::post('/dashboard/delete/{id_task}', [TaskController::class, 'destroy'])->name('dashboard.delete');


Route::post('dashboard/updateStatus/{id_task}', [TodoController::class, 'updateStatus'])->name('dashboard.updateStatus');
Route::post('dashboard/tambahSubtask', [SubtaskController::class, 'store'])->name('subtask.store');
Route::post('subtask/update/{id_subtask}', [SubtaskController::class, 'update'])
    ->name('subtask.updateStatussub');
Route::post('/subtask/delete', [SubtaskController::class, 'destroy'])->name('subtask.deleteSubtask');
Route::post('subtask/status/{id_subtask}', [TodoController::class, 'updateStatussub'])
    ->name('subtask.status');