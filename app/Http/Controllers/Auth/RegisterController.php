<?php

namespace App\Http\Controllers\Auth;

use App\Enumerators\UsersEnumerator;
use App\Http\Controllers\Controller;
use App\Mail\Auth\VerifyMail;
use App\Mail\EmailConfirmation;
use App\Mail\Welcome;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(Request $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        event(new Registered($user = $this->create($request->all())));

        return redirect()->route('login')
            ->with('success', 'Check your email and click on the link to verify.');
    }

    public function verify(Request $request, $token, $id)
    {
        if (!$user = User::where('verify_token', $token)->where('id', $id)->first()) {
            return redirect()->route('login')
                ->with('error', 'Sorry your link cannot be identified.');
        }

        $user->status = User::STATUS_VERIFY;
        $user->verify_token = null;
        $user->save();

        return redirect()->route('user.welcome')
            ->with('success', 'Your e-mail is verified. You can now login.');
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param Request $request
     * @param int $role
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function showRegistrationForm()
    {
        if (!Auth::check()) {
            return view('register');
        }
        return view('/');
    }

    protected function create(Request $request)
    {
        if ($request->get('brief_info') == null)
            $brief = '';
        else $brief = $request->get('brief_info');

        $user = User::where('email', '=', $request['email'])->first();
        if ($user) return 1;

        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'brief_info' => $brief,
            'verify_token' => Str::random(),
            'status' => User::STATUS_REGISTER,
            'role' => $request['role'],
        ]);

        Mail::to($user)->send(new EmailConfirmation($user));
    }

    public function activation($userId, $token)
    {

    }
}
