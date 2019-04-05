<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Session;

class DashboardController extends Controller
{
    //
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:agent');

    }

    /**
     * Show the application Dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect(route('applications.index'));
    }
}
