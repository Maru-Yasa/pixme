<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pages;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Home extends Controller
{

    public function index(Request $req){
        return view('home');
    }

    public function logres(Request $req)
    {


        $action = $req->input('submit');
        $validated = $req->validate([

            "username" => ['min:3'],
            "password" => ['min:3']

        ]);

        if ($action == "Register") {
            try {
                return $this->register($req);
            } catch (Exception $e) {

            }
        }else{
            return $this->login($req);
        }

    }


    public function register(Request $req)
    {
        $validated = $req->validate(User::rules());
        $newUser = new User();
        $newUser->username = $validated['username'];
        $newUser->password = Hash::make($validated['password']);
        if ($newUser->save()) {
            $userId = $newUser->id;
            if (Pages::create(['owner'=>$userId])) {
                return redirect('/')->with('msg','success creating new user, now try to login');
            }
            return redirect('/')->withErrors(['msg','something went wrong, i can feel it']);
        }else{
            return redirect('/')->withErrors(['msg','something went wrong, i can feel it']);
        }
    }


    public function login(Request $req)
    {   

        $validated = $req->validate([
            'username' => 'min:4|required',
            'password' => 'required'
        ]);

        if (Auth::attempt($validated)) {
            $req->session()->regenerate();
            return redirect('/profile');
        }

        return redirect('/')->withErrors(['username or password invalid']);

    }


}
