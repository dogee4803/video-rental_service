<?php

namespace App\Http\Controllers;
use App\Models\Category;
use Inertia\Inertia;

use Illuminate\Http\Request;

class CategoriesListController extends Controller
{
    public function index()
    {
        $categories = Category::all(); // Получаем все жанры из базы данных

        return Inertia::render('(Storage)/CategoriesList', [
            'categories' => $categories // Передаем данные в представление
        ]);
    }
}
