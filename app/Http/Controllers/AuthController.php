<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function index(){
        return view('auth.login');
    }
    public function login(Request $request){
       // dd($request->all());
       //validate data
        $request->validate([
        'email' => 'required',
        'password' => 'required',
       ]);

       // Login code
       if(\Auth::attempt($request->only('email','password'))){
        return redirect('home');
       }
       return redirect('login')->withError('Login details are not valid');
    }
    public function register_view(){
        return view('auth.register');
    }

    public function register(Request $request){
       // dd($request->all());
       // Validate data
       $request->validate([
        'name'=>'required',
        'email'=>'required|unique:users|email',
        'password'=>'required|confirmed'
       ]);
       // Save in users table

       User::create([
        'name'=>$request->name,
        'email'=>$request->email,
        'password'=>\Hash::make($request->password)
       ]);
       // Login user here
       if(\Auth::attempt($request->only('email','password'))){
        return redirect('home');
       }
       return redirect('register')->withError('Error');
    }

    public function home(){
        return view('home');
    }
    public function logout(){
        \Session::flush();
        \Auth::logout();
        return redirect('/');
    }

}
