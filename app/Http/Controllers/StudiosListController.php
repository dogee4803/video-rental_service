<?php

namespace App\Http\Controllers;
use App\Models\Studio;
use Inertia\Inertia;

use Illuminate\Http\Request;

class StudiosListController extends Controller
{
    public function index()
    {
        $studios = Studio::all(); // Получаем все студии из базы данных

        return Inertia::render('(Storage)/StudiosList', [
            'studios' => $studios // Передаем данные в представление
        ]);
    }
}
