<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\ListController;

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'postLogin'])->name('login.post');
Route::any('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth:admin'])->group(function () {
    Route::get('/', [HomeController::class, 'index']);
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::get('/setting', [HomeController::class, 'setting'])->name('setting');
    Route::get('/profile', [HomeController::class, 'profile'])->name('profile');
    Route::post('/setting', [HomeController::class, 'postsetting'])->name('setting.post');
    Route::get('/agents', [AgentController::class, 'index'])->name('agnet.list');
    Route::get('/users', [UserController::class, 'index'])->name('user.list');
    Route::get('/onlineusers', [UserController::class, 'index'])->name('user.onlinelist');
    Route::get('/sites', [ListController::class, 'sitelist'])->name('sitelist');
    Route::post('/site/process/{id}', [ListController::class, 'siteprocess'])->where('id', '[0-9]+')->name('site.process');
    Route::post('/site/add', [ListController::class, 'sitestore'])->name('site.add');
    Route::get('/games', [ListController::class, 'gamelist'])->name('gamelist');
    Route::post('/game/process/{id}', [ListController::class, 'gameprocess'])->where('id', '[0-9]+')->name('game.process');
    Route::post('/game/add', [ListController::class, 'gamestore'])->name('game.add');
    Route::get('/autos', [ListController::class, 'autolist'])->name('autolist');
    Route::post('/auto/add', [ListController::class, 'autostore'])->name('auto.add');
    Route::post('/auto/process/{id}', [ListController::class, 'autoprocess'])->where('id', '[0-9]+')->name('auto.process');
    Route::get('/tables', [ListController::class, 'tablelist'])->name('tablelist');
    Route::delete('/game/{id}/delete', [ListController::class, 'gameDelete'])->name('game.delete');
});
