<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Config;
use Illuminate\Support\Facades\Auth;
use JWTAuth;
use JWTAuthException;
use App\User;
use App\Agent;

class LoginController extends Controller
{
    //
    //
    public function __construct()
    {
        $this->middleware('guest:agent')->except('logout');
    }


    protected function guard()
    {
        return Auth::guard('agent');
    }



    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');
        \Config::set('jwt.user', "App\Agent");
        \Config::set('auth.providers.users.model', \App\Agent::class);

        try {
            if(! $token = Auth::guard('agent')->attempt($credentials)){
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
            else{
                $user = $this->guard()->user()->id;
                $type = $this->guard()->user()->type;
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        return response()->json(compact('token','user','type'));
    }


    public function getAuthenticatedUser(Request $request)
    {
        dd($request->header());
//        try {
//            \Config::set('jwt.user', "App\Agent");
//            \Config::set('auth.providers.users.model', \App\Agent::class);
//            if (! $user = JWTAuth::parseToken()->authenticate()) {
//                return response()->json(['user_not_found'], 404);
//            }
//
//        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
//
//            return response()->json(['token_expired'], $e->getStatusCode());
//
//        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
//
//            return response()->json(['token_invalid'], $e->getStatusCode());
//
//        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
//
//            return response()->json(['token_absent'], $e->getStatusCode());
//
//        }
//
//        return response()->json(compact('user'));
    }
}
