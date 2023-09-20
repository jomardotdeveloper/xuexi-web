<?php

namespace App\Http\Controllers;
use Kreait\Firebase\Factory;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private $database;

    public function __construct()
    {
        $firebase = (new Factory)
        ->withServiceAccount(__DIR__.'/firebase_configurations.json')
        ->withDatabaseUri('https://laravel-firebase-xuexi-default-rtdb.firebaseio.com/');
        $this->database = $firebase->createDatabase();
    }


    public function index() {
        // dd(session('user'));
        $student_counts = $this->database->getReference('Student')->getSnapshot()->numChildren();
        $teacher_counts = $this->database->getReference('Admin')->getSnapshot()->numChildren();
        return view('dashboard', compact('student_counts', 'teacher_counts'));
    }
}
