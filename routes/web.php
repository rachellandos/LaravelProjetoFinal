<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\UtilController;
use Illuminate\Support\Facades\Route;

Route::get('/', [UtilController::class, 'loadHomepage'])->name('welcome');

Route::get('/hello/{message}', [UtilController::class, 'helloMessage']);

// rota de homepage
Route::get('/home', [UtilController::class, 'loadHomepage'])->name('home');

//******************************************** */
// rotas de users
//******************************************** */

Route::get('/users', [UserController::class, 'index']) ->name('users.all');

// rota de adicionar utilizadores
Route::get('/users-add', [UserController::class, 'createUsers'])->name('users.add');

// rota de registar users no servidor
Route::post('/store-users', [UserController::class, 'storeUser'])->name('users.store');

// rota de apagar users
Route::get('/delete-users/{id}',[UserController::class, 'deleteUsers'] )->name('users.delete');

// rota de ver ou editar users
Route::get('/edit-users/{id}',[UserController::class, 'editUsers'] )->name('users.edit')->middleware('auth');

// rota de registar o edit no servidor
Route::put('/update-users', [UserController::class, 'updateUser'])->name('users.update');

//******************************************** */
// rota fallback
//******************************************** */

Route::fallback([UtilController::class, 'loadFallback']);

