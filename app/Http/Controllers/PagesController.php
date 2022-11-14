<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PagesController extends Controller
{

    public function __construct()
    {

    }


    public function index() {
	//if (Auth::check()) {
	    //return redirect('/admin');
	//}
        return view('pages.index');
    }

    public function about() {
        return view('pages.about');
    }
}
