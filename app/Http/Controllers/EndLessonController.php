<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Factory;

class EndLessonController extends Controller
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
        $grade_level_removed_grade = explode(" ", session('user')['grade_level'])[1];
        $all_lessons = $this->getAllLessons($this->database, $grade_level_removed_grade);
        $lesson_number = $_GET['lesson_number'];

        $lessons = [];

        foreach($all_lessons as $key => $value) {
            if(str_contains($value['lesson'], strval($lesson_number))) {
                $lessons[] = $value;
            }
        }


        return view('end.lesson', compact('lessons', 'lesson_number'));
    }
}
