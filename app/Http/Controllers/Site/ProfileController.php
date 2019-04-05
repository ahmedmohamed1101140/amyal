<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    //
    public function index(){
        $client = Auth::user();
        return view('site.profile.index',compact('client'));
    }
}