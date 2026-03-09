<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(Request $request): View
    {
        if ($request->has('upline')) {
            session(['upline' => $request->query('upline')]);
        }
        // return view('auth.register');
        return view('auth.auth.tab-layout');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegisterRequest $request): RedirectResponse
    {

        $ref_code = str_pad(mt_rand(1, 9999999999), 10, '0', STR_PAD_LEFT);

        // Check if the session has the 'upline' key and pull it
        $upline = null;

        if (session()->has('upline')) {
            $upline = User::where('username', session()->pull('upline'))->first();
        }


        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'phone' =>  $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'type' => 'user',
            'status' => 'inactive',
            'balance' => 0.00,
            'deposits' => 0.00,
            'investments' => 0.00,
            'cashouts' => 0.00,
            'upline' => $upline ? $upline->username : 'system',
            'usercode' => $ref_code,
            'country' => $request->country,
        ]);


        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
