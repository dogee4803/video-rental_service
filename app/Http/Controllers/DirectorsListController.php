<?php

namespace App\Http\Controllers;
use App\Models\Director;
use Inertia\Inertia;

use Illuminate\Http\Request;

class DirectorsListController extends Controller
{
    public function index()
    {
        $directors = Director::all(); // Получаем всех режиссйров из базы данных

        return Inertia::render('(Storage)/DirectorsList', [
            'directors' => $directors // Передаем данные в представление
        ]);
    }
}
