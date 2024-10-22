<?php

namespace App\Http\Controllers;
use App\Models\Actor;
use Inertia\Inertia;

use Illuminate\Http\Request;

class ActorsListController extends Controller
{
    public function index()
    {
        $actors = Actor::all(); // Получаем все страны из базы данных

        return Inertia::render('(Storage)/ActorsList', [
            'actors' => $actors // Передаем данные в представление
        ]);
    }
}
