<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
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
    public function create(): View
    {
        return view('auth.register');
    }
    function store(Request $request): RedirectResponse
    {
        $request->validate([
            'full_name' => ['required', 'string', 'max:255'], 
            'phone_number' => ['required', 'string', 'max:15', 'unique:users'], 
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'full_name' => $request->full_name, 
            'phone_number' => $request->phone_number, 
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        return redirect()->route('login')->with('success', 'Registration successful. Please log in with your credentials.');
    }
}
