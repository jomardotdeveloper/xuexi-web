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
        $lessons = $this->database->getReference('LessonItemsV2')->getSnapshot()->getValue();
        $lesson_number = $_GET['lesson_number'];
        $lesson_title = $_GET['lesson_title'];

        $grade_lessons = [];

        foreach ($lessons as $lesson) {
            if($lesson['grade_level'] == $grade_level_removed_grade && $lesson['number'] == $lesson_number) {
                array_push($grade_lessons, $lesson);
            }
        }

        $taken_assessments = $this->database->getReference('TakenQuizzesV2')->getSnapshot()->getValue();
        $user_taken_assessments = [];
        $score = 0;

        if($taken_assessments == null) {
            $taken_assessments = [];
        }

        foreach($taken_assessments as $assessment) {
            if(session('user')['id'] == $assessment['user_id'] && $assessment['lesson_number'] == $lesson_number) {
                $user_taken_assessments[] = $assessment;
            }
        }

        foreach($user_taken_assessments as $taken) {
            if($taken['is_correct'] == true) {
                $score += 1;
            }
        }

        return view('end.lesson', compact('user_taken_assessments','grade_lessons', 'lesson_title', 'lesson_number'));
    }
}
