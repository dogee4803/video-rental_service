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
            'actor_firstname' => 'required|string|max:255',
            'actor_lastname' => 'required|string|max:255',
        ]);

        // Находим актера по ID и обновляем его данные
        $actor = Actor::findOrFail($id);
        $actor->update([
            'actor_firstname' => $request->actor_firstname,
            'actor_lastname' => $request->actor_lastname,
        ]);

        // Перенаправляем обратно на страницу списка актеров с сообщением об успехе
        return redirect()->route('actorslist')->with('success', 'Актер обновлен успешно!');
    }
}
