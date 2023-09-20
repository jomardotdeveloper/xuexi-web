<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Factory;

class EndLoginController extends Controller
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
        $users = $this->database->getReference('Student')->getSnapshot()->getValue();

        $user = null;

        foreach ($users as $key => $value) {
            // dd($value);

            if(!array_key_exists("email",$value))
                continue;

            if ($value['email'] == $email) {
                $user = $value;
                $user['id'] = $key;
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
        return redirect()->route('end.dashboard');
    }

    public function logout(Request $request) {
        $request->session()->forget('user');
        return redirect()->route('end.login');
    }

    public function login() {
        return view('end.login');
    }
}
