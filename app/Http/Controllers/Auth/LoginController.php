<?php

namespace App\Http\Controllers\Auth;

use App\Events\AuthUser;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function formLogIn()
    {
        if (!Auth::check()) {
            return view('welcome');
        }
        return view('/');
    }

    public function loginUser(Request $request)
    {
        $email = $request['email'];
        $password = $request['password'];

        $this->validate($request, [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        try {
            $user = User::query()->where('email', '=', $email)->first();
            if ($user->status === 9) {
                return 'nonVerify';
            }
            if ($user->block === 1) {
                return 'block';
            }
            if (Hash::check($password, $user->password)) {
                Auth::login($user);
                event(new AuthUser($request->user()));
                $request->session()->put('LoggedUser', $user->id);
                $request->session()->put('current_user', Auth::user());
                return '1';
            }
        } catch (\Exception $e) {
            return '0';
        }
    }

    public function loginCustomer(Request $request)
    {
        $email = $request['email'];
        $password = $request['password'];

        $this->validate($request, [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        $user = User::where('email', '=', $email)->first();
        if ($user) {
            if ($user->block === 1) {
                return 'block';
            }

            if ($user->status === 9) {
                return 'nonVerify';
            }

            if (Hash::check($password, $user->password) && $user['role'] == 2) {
                Auth::login($user);
                $request->session()->put('LoggedUser', $user->id);
                return 1;
            }
        }
        return 0;
    }

    public function authenticated(Request $request, $user)
    {
        if ($user->status !== User::STATUS_ACTIVE) {
            $this->guard()->logout();
            return back()->with('error', 'You need to confirm your account. Please check your email.');
        }
        return redirect()->intended($this->redirectPath());
    }

    public function authenticateAdmin(Request $request)
    {
        $password = $request['password'];
        $email = $request['email'];

        $this->validate($request, [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        $user = User::where('email', '=', $email)->where('role', '=', 1)->first();
        if ($user) {
            if (Hash::check($password, $user['password'])) {
                Auth::login($user);
                $request->session()->put('LoggedUser', $user->id);
                return redirect(route('admin.customers'));
            }
            return redirect(route('admin.customers'));
        }
        return redirect(route('admin.login'))->withErrors(array('login' => 'Error logging in!'));
    }

    public function loginAdmin()
    {
        if (Auth::check()) return view('adminPanel.customers');
        else return view('adminPanel.auth.login');
    }

    public function logout()
    {
        if (Auth::user()){
            Auth::logout();
        }
        Cache::forget('user-is-online-' . Auth::id());
        return redirect('/auth');
    }
}
