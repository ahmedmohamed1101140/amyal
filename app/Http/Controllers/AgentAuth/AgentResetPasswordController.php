<?php

namespace App\Http\Controllers\AgentAuth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class AgentResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:agent');
    }

    public function guard()
    {
        return Auth::guard('agent');
    }

    public function broker()
    {
        return Password::broker('agents');
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.passwords.agent-reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }
}
