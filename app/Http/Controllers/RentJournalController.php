<?php

namespace App\Http\Controllers;
use App\Models\Customer;
use Inertia\Inertia;

class RentJournalController extends Controller
{
    public function index()
    {
        $customers = Customer::all(); // Получаем всех клиентов из базы данных

        return Inertia::render('(Shop)/RentJournal', [
            'customers' => $customers // Передаем данные в представление
        ]);
    }
}
