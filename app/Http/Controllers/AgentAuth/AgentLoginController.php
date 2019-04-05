<?php

namespace App\Http\Controllers\AgentAuth;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Validation\ValidationException;


class AgentLoginController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('guest:agent')->except('logout');
    }


    protected function guard()
    {
        return Auth::guard('agent');
    }

    use AuthenticatesUsers;

    protected $redirectTo = '/dashboard';


    public function showLoginForm()
    {
        return view('auth.agent-login');
    }

    public function login(Request $request)
    {

        $this->validate($request, array(
            'email' => 'required|email',
            'password' => 'required|min:4'
        ));

        $credentials = $request->only('email', 'password');
        if (Auth::guard('agent')->attempt($credentials, $request->remember)) {
            $this->guard()->user()->last_login = Carbon::now();
            $this->guard()->user()->save();
            return redirect()->intended(route('Dashboard'));
        }
        throw ValidationException::withMessages([
            'email' => [trans('auth.failed')],
        ]);


    }

    public function logout()
    {
        Auth::guard('agent')->logout();
        return redirect('/dashboard');
    }
}
