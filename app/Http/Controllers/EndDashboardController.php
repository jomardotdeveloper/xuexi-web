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
        // $all_lessons = $this->getAllLessons($this->database, $grade_level_removed_grade);
        $current_lesson = $this->getStudentCurrentLesson($this->database, session('user')['id']);

        $grade_lessons = [];
        $lessons = $this->database->getReference('LessonsV2')->getSnapshot()->getValue();

        foreach ($lessons as $lesson) {
            if($lesson['grade_level'] == $grade_level_removed_grade) {
                array_push($grade_lessons, $lesson);
            }
        }
        return view('end.dashboardv2', compact('grade_lessons', 'current_lesson'));
    }
}
