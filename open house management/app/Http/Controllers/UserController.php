<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function authenticate(Request $request){
        $formFields=$request->validate([
            'email'=> ['required','email'],
            'password'=>'required',
            'role'=>'required',
        ]);
        if(auth()->attempt($formFields)){
            $request->session()->regenerate();
            $user = Auth::user();
            $user->role = $formFields['role']; // Set the user's role accordingly

            if ($formFields['role'] == 'student') {
                return redirect('/student/project')->with('message', 'You are logged in as FYP Group!');
            }elseif($formFields['role'] == 'guest') {
                return redirect('/guest/home')->with('message', 'You are logged in as Guest!');
            }elseif($formFields['role'] == 'admin') {
                return redirect('/admin/dashboard')->with('message', 'You are logged in as Admin!');
            }
            
        }

        return back()->withErrors(['email' => 'Invalid Credentials'])->onlyInput('email');
    }

    public function createUser(Request $request){
        $formFields=$request->validate(
            [
                'name'=>'required',
                'email'=>['required','email', Rule::unique('users', 'email')],
                'role'=>'required',
                'password'=>'required | confirmed | min:6',
            ]
            );
            // Hash Password
        $formFields['password'] = bcrypt($formFields['password']);
        // Create User
        $user = User::create($formFields);

        // Login
        auth()->login($user);
        if ($formFields['role'] == 'student') {
            return redirect('/student/project')->with('message', 'User created and logged in');
        }elseif($formFields['role'] == 'guest') {
            return redirect('/guest/home')->with('message', 'User created and logged in');
        }
    }

    public function logout(Request $request){
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('message', 'You have been logged out!');
    }

}
