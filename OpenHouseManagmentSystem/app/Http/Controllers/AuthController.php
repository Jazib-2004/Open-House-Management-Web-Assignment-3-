<?php

namespace App\Http\Controllers;
use App\Models\Admin;
use App\Models\Fyp_group;
use App\Models\Evaluator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function login(Request $request){
        $userId = null; // Initialize variable to store the user ID
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'role' => 'required|in:admin,evaluator,fyp_group', // Ensure that the role is one of these values
        ]);

        $email = $request->input('email');
        $password = $request->input('password');
        $role = $request->input('role');

        // Check role and authenticate accordingly
        switch ($role) {
            case 'admin':
                $user = Admin::where('email', $email)->first();
                if ($user){
                    if(\Hash::check($password, $user->password)){
                    // Authentication successful
                    return redirect('/landing');
                    }
                    else{
                        return back()->withErrors(['password' => 'Invalid password']);
                    }
                }else{
                    // Authentication failed
                    return back()->withErrors(['email' => 'Invalid email']);
                }
                break;

            case 'evaluator':
                $user = Evaluator::where('email', $email)->first();
                if ($user) {
                    $userId = $user->id;
                } else {
                    // Handle the case where the user with the specified email is not found.
                    $userId = null; // You can set a default value or take appropriate action.
                }
                if ($user){
                    if(\Hash::check($password, $user->password)){
                    // Authentication successful
                    return redirect('/evaluator/preferences'.$userId);
                    }
                    else{
                        return back()->withErrors(['password' => 'Invalid password']);
                    }
                }
                break;

            case 'fyp_group':
                $user = Fyp_group::where('email', $email)->first();
                $user = Fyp_group::where('email', $email)->first();

                if ($user) {
                    $userId = $user->id;
                } else {
                    // Handle the case where the user with the specified email is not found.
                    $userId = null; // You can set a default value or take appropriate action.
                }
                if ($user){
                    if(\Hash::check($password, $user->password)){
                    // Authentication successful
                    return redirect('/studetails/'.$userId);
                    }
                    else{
                        return back()->withErrors(['password' => 'Invalid password']);
                    }
                }else{
                    // Authentication failed
                    return back()->withErrors(['email' => 'Invalid email']);
                }
                break;

            default:
                return back()->withErrors(['role' => 'Invalid role specified']);
        }

        // Check if user exists and password is correct
        
    }
    public function register(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:admins|unique:evaluators|unique:fyp_groups',
        'password' => 'required|string|min:8|confirmed',
        'role' => 'required|in:admin,evaluator,fyp_group',
    ]);

    switch ($request->input('role')) {
        case 'admin':
            try {
                $userId = DB::table("admins")->insertGetId([
                    "name" => $request->input('name'),
                    'email' => $request->input('email'),
                    'password' => bcrypt($request->input('password')),
                ]);
            } catch (\Exception $e) {
                Log::error('Error creating admin: ' . $e->getMessage());
            }
            break;

        case 'evaluator':
            $userId = DB::table("evaluators")->insertGetId([
                "name" => $request->input('name'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
            ]);
        
            break;

        case 'fyp_group':
            $userId = DB::table("fyp_groups")->insertGetId([
                "group_name" => $request->input('name'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
            ]);
            break;

        default:
            return back()->withErrors(['role' => 'Invalid role specified']);
    }

    // Registration successful, redirect to login or dashboard
    return redirect('/login')->with('success', 'Registration successful. Please login.');
}
}
