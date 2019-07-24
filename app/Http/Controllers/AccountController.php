<?php
/**
 * Created by PhpStorm.
 * User: molde
 * Date: 05.06.2019
 * Time: 19:13
 */

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
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
        if (Auth::user()->isAdmin == 0) {
            return view('home');
        } else
            return view('admin/blogPostList');
    }
}
