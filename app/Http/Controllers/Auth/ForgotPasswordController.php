<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Форма ввода адреса почты
     */
    public function form()
    {
        return view('auth.passwords.reset');
    }

    public function mail(Request $request)
    {
        if ($request->phone) return '0';

        $request->validate([
            'email' => 'email|exists:users',
        ]);
        $token = Str::random(60);
        DB::table('password_resets')->insert([
            'email' => $request->login,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        $link = route('password.reset.token', ['token' => $token, 'email' => $request->login]);
        $user = User::query()->where('email', '=', $request->login)->first();
        if ($user) {
            Mail::send('emails.reset-passwordEmail', ['link' => $link],
                function ($message) use ($request) {
                    $message->to($request->login);
                    $message->subject('Восстановление пароля СПОРТБАЗА.РФ');
                }
            );
        } else return response()->json( [ "message"=>"email error"], 400);
    }
}
