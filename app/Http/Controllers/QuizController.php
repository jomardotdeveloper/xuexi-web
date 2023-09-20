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
        $all_quiz = $this->database->getReference('Quiz')->getSnapshot()->getValue();
        $grade5 = [];
        $grade6 = [];

        foreach ($all_quiz as $key => $value) {
            if ($value['grade_level'] == '5') {
                foreach($value["questions"] as $question) {
                    $question["lesson"] = $value["lesson"];
                    array_push($grade5, $question);
                }
            } else {
                foreach($value["questions"] as $question) {
                    $question["lesson"] = $value["lesson"];
                    array_push($grade6, $question);
                }
            }
        }
        return view('quiz', compact('grade5', 'grade6'));
    }
}
