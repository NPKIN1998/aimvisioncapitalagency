<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\View\View;

class DashboardController extends Controller
{

    public function index(): View
    {
        $transactions = Transaction::latest()->take(5)->get();

        // dd($transactions->toArray());

        return view('user/dashboard', compact('transactions'));
    }

    public function contact()
    {
        return view('user.contact');
    }
}
