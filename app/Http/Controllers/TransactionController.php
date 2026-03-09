<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class TransactionController extends Controller
{
    public function index(Request $request): View
    {
        $user =  $request->user();
        $transactions = $user->transactions()->latest()->paginate(10);

        // dd($transactions->toArray());
        return view('user/transactions', compact('transactions'));
    }
}
