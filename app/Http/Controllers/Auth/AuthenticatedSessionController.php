<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\Request;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $user = User::where('email', $request->input('email'))->first();
    
        if (!$user) {
            return back()->with('sweetalert', [
                'type' => 'error',
                'title' => 'Email Not Registered',
                'text' => 'The email is not registered. Please register first.',
            ])->withInput($request->only('email'));
        }
    
        try {
            // Authenticate the user
            $request->authenticate();
            $request->session()->regenerate();
    
            $user = Auth::user();
    
            if (!$user->onboarding_completed) {
                return redirect()->route('onboarding.show')->with('sweetalert', [
                    'type' => 'info',
                    'title' => 'Complete Your Profile',
                    'text' => 'Please complete your profile information to proceed.',
                ]);
            }
    
            return redirect()
                ->intended(route('dashboard'))
                ->with('sweetalert', [
                    'type' => 'success',
                    'title' => 'Login Successful',
                    'text' => 'Welcome back, ' . $user->full_name . '!',
                ]);
        } catch (\Exception $e) {
            return back()->with('sweetalert', [
                'type' => 'error',
                'title' => 'Invalid Credentials',
                'text' => 'The provided credentials are incorrect.',
            ]);
        }
    }
    
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
