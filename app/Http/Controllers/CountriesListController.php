<?php

namespace App\Http\Controllers;
use App\Models\Country;
use Inertia\Inertia;

use Illuminate\Http\Request;

class CountriesListController extends Controller
{
    public function index()
    {
        $countries = Country::all();

        return Inertia::render('(Storage)/CountriesList', [
            'countries' => $countries
        ]);
    }

    public function getCountries()
        {
            $countries = Country::all();
            return response()->json($countries);
        }

    public function destroy($id)
    {
        $country = Country::findOrFail($id);
        $country->delete();

        return redirect()->route('countrieslist')->with('success', 'Страна удалена успешно!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => [
            'required',
            'string',
            'max:255',
            'regex:/^(?!\s).*$/',
            ]
        ]);

        $country = Country::findOrFail($id);
        $country->update([
            'name' => $request->name,
        ]);

        return redirect()->route('countrieslist')->with('success', 'Страна обновлена успешно!');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => [
            'required',
            'string',
            'max:255',
            'regex:/^(?!\s).*$/',
            ]
        ]);

        Country::create([
            'name' => $request->name
        ]);

        return redirect()->route('countrieslist')->with('success', 'Страна добавлена успешно!');
    }
}
