<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ViewController extends Controller
{
    public function viewLoginForm(){
        return view('login');
    }
    public function viewRegistrationForm(){
        return view('register');
    }

}
