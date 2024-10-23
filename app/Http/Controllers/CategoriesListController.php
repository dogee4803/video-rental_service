<?php

namespace App\Http\Controllers;
use App\Models\Category;
use Inertia\Inertia;

use Illuminate\Http\Request;

class CategoriesListController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        return Inertia::render('(Storage)/CategoriesList', [
            'categories' => $categories
        ]);
    }

    public function getCategories()
        {
            $categories = Category::all();
            return response()->json($categories);
        }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('categorieslist')->with('success', 'Жанр удален успешно!');
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

        $category = Category::findOrFail($id);
        $category->update([
            'name' => $request->name,
        ]);

        return redirect()->route('categorieslist')->with('success', 'Жанр обновлен успешно!');
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

        Category::create([
            'name' => $request->name
        ]);

        return redirect()->route('categorieslist')->with('success', 'Жанр добавлен успешно!');
    }
}
