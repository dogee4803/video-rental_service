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
Route::post('/categorieslist', [CategoriesListController::class, 'store']);

Route::get('/actorslist', [ActorsListController::class, 'index'])->name('actorslist');
Route::delete('/actorslist/{id}', [ActorsListController::class, 'destroy'])->name('actors.destroy');
Route::put('/actorslist/{id}', [ActorsListController::class, 'update'])->name('actors.update');


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

