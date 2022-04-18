<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\ParticipationController;
use App\Http\Controllers\AwardController;
use App\Http\Controllers\LoginParticipant;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function() {
    return Inertia::render('Index');
})->name('index');
Route::get('/prueba', function() {
    return Inertia::render('Prueba');
})->name('prueba');
Route::get('/corazon', function() {
    return Inertia::render('Corazon');
})->name('corazon');
Route::post('register-participant', [ParticipantController::class, 'register'])->name('register');
Route::get('/participation/{participation}', [ParticipationController::class, 'index'])->name('participation');
Route::post('register-response', [AwardController::class, 'register'])->name('register_response');
Route::post('login-participant', [LoginParticipant::class, 'login'])->name('login_participant');
