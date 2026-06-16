<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $transactions = Transaction::where('user_id', $request->user()->id)->latest()->take(5)->get();

        // dd($transactions->toArray());

        return view('user/dashboard', compact('transactions'));
    }

    public function contact()
    {
        return view('user.contact');
    }
}
