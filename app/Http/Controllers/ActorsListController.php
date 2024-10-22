<?php

namespace App\Http\Controllers;
use App\Models\Actor;
use Inertia\Inertia;

use Illuminate\Http\Request;

class ActorsListController extends Controller
{
    public function index()
    {
        $actors = Actor::all();

        return Inertia::render('(Storage)/ActorsList', [
            'actors' => $actors
        ]);
    }

    public function destroy($id)
    {
        // Находим актера по ID и удаляем его
        $actor = Actor::findOrFail($id);
        $actor->delete();

        // Перенаправляем обратно на страницу списка актеров с сообщением об успехе
        return redirect()->route('actorslist')->with('success', 'Актер удален успешно!');
    }

    public function update(Request $request, $id)
    {
        // Валидация входящих данных
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
        ]);

        // Находим актера по ID и обновляем его данные
        $actor = Actor::findOrFail($id);
        $actor->update([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
        ]);

        // Перенаправляем обратно на страницу списка актеров с сообщением об успехе
        return redirect()->route('actorslist')->with('success', 'Актер обновлен успешно!');
    }

    public function store(Request $request)
{
    $request->validate([
        'firstname' => 'required|string|max:255',
        'lastname' => 'required|string|max:255',
    ]);

    // Создаем нового актера
    Actor::create([
        'firstname' => $request->firstname,
        'lastname' => $request->lastname,
    ]);

    // Перенаправляем обратно на страницу списка актеров с сообщением об успехе
    return redirect()->route('actorslist')->with('success', 'Актер добавлен успешно!');
}
}
