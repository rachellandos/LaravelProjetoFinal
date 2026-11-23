<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PetController;
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
Route::get('/edit-users/{id}',[UserController::class, 'editUser'] )->name('users.edit')->middleware('auth');

// rota de registar o edit no servidor
Route::put('/update-users', [UserController::class, 'updateUser'])->name('users.update');

//******************************************** */
// rotas de pets
//******************************************** */

Route::get('/pets', [PetController::class, 'index']) ->name('pets.all'); 

// rota de adicionar pets
Route::get('/pets-add', [PetController::class, 'createPets'])->name('pets.add');

// rota de registar pets no servidor
Route::post('/store-pets', [PetController::class, 'storePets'])->name('pets.store');

// // rota de apagar pets
Route::get('/delete-pets/{id}',[PetController::class, 'deletePets'] )->name('pets.delete');

// rota de ver ou editar pets
 Route::get('/edit-pets/{id}',[PetController::class, 'editPets'] )->name('pets.edit')->middleware('auth');

// rota de registar o edit no servidor
Route::put('/update-pets', [PetController::class, 'updatePets'])->name('pets.update');

// rota os meus pets perdidos
Route::get('/my-pets', [PetController::class, 'myPets'])->name('pets.mine')->middleware('auth');

//******************************************** */
// rotas de dashboard
//******************************************** */
Route::get('/dashboard', [DashboardController::class, 'index']) ->name('dashboard')->middleware('auth', 'admin');;
Route::get('/pets/{id}', [DashboardController::class, 'showPets'])->name('dashboard.showPet');
Route::post('/pets/{id}/approve', [DashboardController::class, 'approve'])->name('dashboard.approve')->middleware(['auth', 'admin']);
Route::post('/pets/{id}/reject', [DashboardController::class, 'reject'])->name('dashboard.reject')->middleware(['auth', 'admin']);


//******************************************** */
// rota fallback
//******************************************** */

Route::fallback([UtilController::class, 'loadFallback']);

