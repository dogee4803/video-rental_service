<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Home')->name('home');
// todo Перенести ролевые страницы в нужные мидлы по ролям (сначала их надо сделать)
Route::inertia('/customersduedate', '(Shop)/CustomersDueDate')->name('customersduedate');
Route::inertia('/filmscategory', '(Shop)/FilmsCategoryList')->name('filmscategory');
Route::inertia('/renteddiscs', '(Shop)/RentedDiscs')->name('renteddiscs');
Route::inertia('/rentjournal', '(Shop)/RentJournal')->name('rentjournal');

Route::inertia('/actorslist', '(Storage)/ActorsList')->name('actorslist');
Route::inertia('/categorieslist', '(Storage)/CategoriesList')->name('categorieslist');
Route::inertia('/countrieslist', '(Storage)/CountriesList')->name('countrieslist');
Route::inertia('/directorslist', '(Storage)/DirectorsList')->name('directorslist');
Route::inertia('/discslist', '(Storage)/DiscsList')->name('discslist');
Route::inertia('/filmslist', '(Storage)/FilmsList')->name('filmslist');
Route::inertia('/studioslist', '(Storage)/StudiosList')->name('studioslist');

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

