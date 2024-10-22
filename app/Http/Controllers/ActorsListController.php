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
        $actor = Actor::findOrFail($id);
        $actor->delete();

        return redirect()->route('actorslist')->with('success', 'Актер удален успешно!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'firstname' => [
            'required',
            'string',
            'max:255',
            'regex:/^(?!\s).*$/',
            ],
            'lastname' => [
            'required',
            'string',
            'max:255',
            'regex:/^(?!\s).*$/',
            ],
        ]);

        $actor = Actor::findOrFail($id);
        $actor->update([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
        ]);

        return redirect()->route('actorslist')->with('success', 'Актер обновлен успешно!');
    }

    public function store(Request $request)
    {
        $request->validate([
            'firstname' => [
                'required',
                'string',
                'max:255',
                'regex:/^(?!\s).*$/',
                ],
                'lastname' => [
                'required',
                'string',
                'max:255',
                'regex:/^(?!\s).*$/',
                ],
        ]);

        Actor::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
        ]);

        return redirect()->route('actorslist')->with('success', 'Актер добавлен успешно!');
    }
}
