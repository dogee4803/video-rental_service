<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CountriesListController;
use App\Http\Controllers\RentJournalController;
use App\Http\Controllers\StudiosListController;
use App\Http\Controllers\DirectorsListController;
use App\Http\Controllers\CategoriesListController;
use App\Http\Controllers\ActorsListController;

Route::get('/countrieslist', [CountriesListController::class, 'index'])->name('countrieslist');
Route::post('/countrieslist', [CountriesListController::class, 'store']);

Route::get('/rentjournal', [RentJournalController::class, 'index'])->name('rentjournal');
Route::post('/rentjournal', [RentJournalController::class, 'store']);

Route::get('/studioslist', [StudiosListController::class, 'index'])->name('studioslist');
Route::post('/studioslist', [StudiosListController::class, 'store']);

Route::get('/directorslist', [DirectorsListController::class, 'index'])->name('directorslist');
Route::post('/directorslist', [DirectorsListController::class, 'store']);

Route::get('/categorieslist', [CategoriesListController::class, 'index'])->name('categorieslist');
Route::get('/api/categorieslist', [CategoriesListController::class, 'getActors'])->name('categorieslist.getActors');;
Route::delete('/api/categorieslist/{id}', [CategoriesListController::class, 'destroy'])->name('categorieslist.destroy');
Route::put('/api/categorieslist/{id}', [CategoriesListController::class, 'update'])->name('categorieslist.update.{id}');
Route::post('/api/categorieslist', [CategoriesListController::class, 'store'])->name('categorieslist.store');

Route::get('/actorslist', [ActorsListController::class, 'index'])->name('actorslist');
Route::get('/api/actorslist', [ActorsListController::class, 'getActors'])->name('actorslist.getActors');;
Route::delete('/api/actorslist/{id}', [ActorsListController::class, 'destroy'])->name('actors.destroy');
Route::put('/api/actorslist/{id}', [ActorsListController::class, 'update'])->name('actors.update.{id}');
Route::post('/api/actorslist', [ActorsListController::class, 'store'])->name('actors.store');


Route::inertia('/', 'Home')->name('home');

// todo Перенести ролевые страницы в нужные мидлы по ролям (сначала их надо сделать)
Route::inertia('/customersduedate', '(Shop)/CustomersDueDate')->name('customersduedate');
Route::inertia('/filmscategory', '(Shop)/FilmsCategoryList')->name('filmscategory');
Route::inertia('/renteddiscs', '(Shop)/RentedDiscs')->name('renteddiscs');

Route::inertia('/discslist', '(Storage)/DiscsList')->name('discslist');
Route::inertia('/filmslist', '(Storage)/FilmsList')->name('filmslist');

Route::middleware('auth')->group(function () {
    Route::inertia('/dashboard', 'Dashboard')->name('dashboard');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware('guest')->group(function () {
    Route::inertia('/register', 'Auth/Register')->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    
    Route::inertia('/login', 'Auth/Login')->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

