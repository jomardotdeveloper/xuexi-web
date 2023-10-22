<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
class QuizController extends Controller
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
        $all_quiz = $this->database->getReference('QuizzesV2')->getSnapshot()->getValue();
        $grade5 = [];
        $grade6 = [];

        foreach ($all_quiz as $key => $value) {
            if ($value['grade_level'] == '5') {
                array_push($grade5, $value);
            } else {
                array_push($grade6, $value);
            }
        }
        return view('quiz', compact('grade5', 'grade6'));
    }
}
