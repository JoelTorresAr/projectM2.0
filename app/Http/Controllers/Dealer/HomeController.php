<?php

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{

    protected $redirectTo = '/dealer/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('dealer.auth:dealer');
    }

    /**
     * Show the Dealer dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('dealer.home');
    }

}