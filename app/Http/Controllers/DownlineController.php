<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DownlineController extends Controller
{
    public function index(): View
    {
        // Get the authenticated user's usercode
        $username = Auth::user()->username;
        $user = Auth::user();

        $downlines = User::where('upline', $username)
            ->select('id', 'name', 'username', 'status', 'phone', 'created_at') // Ensure created_at is selected
            ->latest() // Orders by created_at DESC
            ->get();


        $totalDownlines = $downlines->count();
        $activeDownlines = $downlines->where('status', 'active')->count();
        $inactiveDownlines = $downlines->where('status', 'inactive')->count();
        //   $referralBonuses = ReferralBonus::where('user_id', $user->id)->sum('amount');
        return view('user/downline', compact('downlines', 'totalDownlines', 'activeDownlines', 'inactiveDownlines'));
    }
}
