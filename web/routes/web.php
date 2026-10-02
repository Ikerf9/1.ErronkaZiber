<?php

use App\Http\Controllers\AdministrazioaController;
use App\Http\Controllers\IkastaroController;
use App\Http\Middleware\AdminOnly;
use Illuminate\Support\Facades\Route;

Route::get('/', [IkastaroController::class, 'index']);
Route::get('/index.php', [IkastaroController::class, 'index'])->name('home');
Route::get('/login.php', [AdministrazioaController::class, 'login'])->name('login');
Route::post('/login.php', [AdministrazioaController::class, 'authenticate'])->name('login.submit');
Route::get('/erregistratu.php', [IkastaroController::class, 'register'])->name('register');
Route::post('/erregistratu.php', [IkastaroController::class, 'storeRegistration'])->name('register.submit');
Route::get('/administrazioa.php', [AdministrazioaController::class, 'index'])->middleware(AdminOnly::class)->name('administrazioa');
Route::get('/erabiltzaileak/{erabiltzailea}/editatu', [AdministrazioaController::class, 'edit'])
    ->middleware(AdminOnly::class)->name('users.edit');
Route::patch('/erabiltzaileak/{erabiltzailea}', [AdministrazioaController::class, 'update'])
    ->middleware(AdminOnly::class)->name('users.update');
Route::delete('/erabiltzaileak/{erabiltzailea}', [AdministrazioaController::class, 'destroy'])
    ->middleware(AdminOnly::class)
    ->name('users.destroy');
Route::post('/ikasleak', [IkastaroController::class, 'storeStudent'])->middleware(AdminOnly::class)->name('students.store');
Route::post('/ikastaroak/{ikastaroa}/matrikulatu', [IkastaroController::class, 'enroll'])->middleware('auth')->name('enroll');
Route::redirect('/nagusia.php', '/administrazioa.php')->name('nagusia');
Route::post('/irten', [AdministrazioaController::class, 'logout'])->name('logout');

Route::patch('/matrikulak/{matrikula}', [\App\Http\Controllers\MatrikulaController::class, 'update'])->middleware(AdminOnly::class)->name('enrollments.update');



Route::middleware(AdminOnly::class)->group(function () {
    Route::get('/ikastaroak/sortu', [IkastaroController::class, 'create'])->name('courses.create');
    Route::post('/ikastaroak', [IkastaroController::class, 'store'])->name('courses.store');
    Route::get('/ikastaroak/{ikastaroa}/editatu', [IkastaroController::class, 'edit'])->name('courses.edit');
    Route::patch('/ikastaroak/{ikastaroa}', [IkastaroController::class, 'update'])->name('courses.update');
    Route::delete('/ikastaroak/{ikastaroa}', [IkastaroController::class, 'destroy'])->name('courses.destroy');
});
