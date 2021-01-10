<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        $permissions = $user->permissions();
        if ($permissions->contains('read_registration')) {
            return redirect('/manage');
        } else {
            if ($user->registration) {
                return view('register.status');
            } else {
                return view('register.index');
            }
        }
        
        //return view('home');
    }
}
