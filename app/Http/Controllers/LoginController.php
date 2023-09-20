<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
class LoginController extends Controller
{
    private $database;

    public function __construct()
    {
        $firebase = (new Factory)
        ->withServiceAccount(__DIR__.'/firebase_configurations.json')
        ->withDatabaseUri('https://laravel-firebase-xuexi-default-rtdb.firebaseio.com/');
        $this->database = $firebase->createDatabase();
    }

    public function authenticate(Request $request) {
        $email = $request->email;
        $password = $request->password;
        $users = $this->database->getReference('Admin')->getSnapshot()->getValue();

        $user = null;

        foreach ($users as $key => $value) {
            // dd($value);

            if(!array_key_exists("email",$value))
                continue;

            if ($value['email'] == $email) {
                $user = $value;
                break;
            }
        }
        // dd($user);
        if ($user == null) {
            return back()->with(["error" => ["Invalid Credentials"]]);
        }
        // $user = array_values($user)[0];
        if ($user['password'] != $password) {
            return back()->with(["error" => ["Invalid Credentials"]]);
        }
        $request->session()->put('user', $user);
        return redirect()->route('dashboard');
    }

    public function logout(Request $request) {
        $request->session()->forget('user');
        return redirect()->route('login');
    }

    public function login() {
        return view('login');
    }


}
