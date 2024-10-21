<?php

namespace App\Http\Controllers;
use App\Models\Country;
use Inertia\Inertia;

use Illuminate\Http\Request;

class CountriesListController extends Controller
{
    public function index()
    {
        $countries = Country::all(); // Получаем все страны из базы данных

        return Inertia::render('(Storage)/CountriesList', [
            'countries' => $countries // Передаем данные в представление
        ]);
    }
}
