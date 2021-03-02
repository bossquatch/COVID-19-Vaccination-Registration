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
        $this->middleware('verified');
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
        if ($permissions->contains('create_user')) {
            return redirect('/admin');
        } else if ($permissions->contains('create_event')) {
            return redirect('/events');
        } else if ($permissions->contains('create_vaccine') || $permissions->contains('check_in')) {
            return redirect('/manage/qr');
        } else if ($permissions->contains('read_registration') || $permissions->contains('skeleton_key')) {
            return redirect('/manage');
        } else if ($permissions->contains('read_partner_event')) {
            return redirect('/my-events');
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
