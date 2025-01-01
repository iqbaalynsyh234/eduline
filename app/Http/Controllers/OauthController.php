<?php

namespace App\Http\Controllers;

use Auth;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use App\Models\User;

class OauthController extends Controller
{
    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleProviderCallback()
    {
        try {

            $googleUser = Socialite::driver('google')->stateless()->user();

            $findUser = User::where('gauth_id', $googleUser->id)
                ->orWhere('email', $googleUser->email)
                ->first();

            if ($findUser) {
                if (empty($findUser->gauth_id)) {
                    $findUser->update(['gauth_id' => $googleUser->id]);
                }
                Auth::login($findUser);
            } else {
                $newUser = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'gauth_id' => $googleUser->id,
                    'gauth_type' => 'google',
                    'password' => encrypt('user@123'),
                    'onboarding_completed' => false, 
                ]);

                $newUser->assignRole('student');

                Auth::login($newUser);
            }

            $user = Auth::user();

            if ($user->hasRole('student')) {
                if (!$user->onboarding_completed) {
                    return redirect()->route('onboarding.show');
                }
                return redirect()->route('student.dashboard');
            } elseif ($user->hasRole('owner')) {
                return redirect()->route('admin.dashboard');
            } elseif ($user->hasRole('teacher')) {
                return redirect()->route('dashboard');
            }
            
            Auth::logout();
            return redirect('/login')->withErrors('Unauthorized role access.');
        } catch (Exception $e) {
            return redirect('/login')->withErrors(['error' => $e->getMessage()]);
        }
    }
}
