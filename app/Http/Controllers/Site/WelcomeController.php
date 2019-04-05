<?php

namespace App\Http\Controllers\Site;

use App\Http\Requests\Site\StoreClientRequest;
use App\Models\Dashboard\City;
use App\Http\Controllers\Controller;
use App\Models\Site\ClientRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Session;

class WelcomeController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application Dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('site.index');
    }
}
