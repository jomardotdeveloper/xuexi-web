<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Factory;

class EndDashboardController extends Controller
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
        // REMOVE GRADE WORD IN GRADE LEVEL
        $grade_level_removed_grade = explode(" ", session('user')['grade_level'])[1];
        $all_lessons = $this->getAllLessons($this->database, $grade_level_removed_grade);
        $current_lesson = $this->getStudentCurrentLesson($this->database, session('user')['id']);
        return view('end.dashboard', compact('current_lesson', 'all_lessons'));
    }
}
