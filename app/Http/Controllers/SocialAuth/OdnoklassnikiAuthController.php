<?php

namespace App\Http\Controllers\SocialAuth;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Services\SocialOdnoklassnikiAccountService;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class OdnoklassnikiAuthController extends Controller
{
    /**
     * Create a redirect method to odnoklassniki api.
     *
     * @return void
     */
    public function odnoklassniki()
    {
        return Socialite::driver('odnoklassniki')->redirect();
    }
    /**
     * Return a callback method from odnoklassniki api.
     *
     * @return callback URL from odnoklassniki
     */
    public function odnoklassnikiRedirect()
    {
        try {
            $user = Socialite::driver('odnoklassniki')->user();
        } catch (\Exception $e) {
            return redirect('/login');
        }

        $existingUser = User::where('email', $user->email)->first();
        if ($existingUser) {
            // log them in
            auth()->login($existingUser, true);
        } else {
            // create a new user
            $newUser                  = new User;
            $newUser->name            = $user->name;
            $newUser->email           = $user->email;
            $newUser->password        = Hash::make(Str::random(24));
            $newUser->save();
            auth()->login($newUser, true);
        }
        return redirect()->to('/home');
    }
}
