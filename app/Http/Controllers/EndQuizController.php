<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Factory;

class EndQuizController extends Controller
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
        $quizzes = $this->getAllQuizzes($this->database, $_GET['lesson_number'], $grade_level_removed_grade);
        $lesson_number = $_GET['lesson_number'];
        $is_taken = $this->quizIsTakenAssessment($this->database,$lesson_number, session('user')['id']);

        $score = 0;
        if($is_taken) {
            foreach($is_taken['data'] as $data) {
                if($data['is_correct'] == true) {
                    $score += 1;
                }
            }
        }

        // dd($is_taken);
        return view('end.quiz', compact('quizzes', 'lesson_number', 'is_taken', 'score'));
    }

    public function store (Request $request) {
        // dd($request->all());
        $data = [
            "student_id" => session('user')['id'],
            "data" => [],
            "lesson" => $request->get('lesson_number')
        ];
        $grade_level_removed_grade = explode(" ", session('user')['grade_level'])[1];
        $lesson_number = $request->get('lesson_number');
        $quizzes = $this->getAllQuizzes($this->database, $lesson_number, $grade_level_removed_grade);
        $ctx = 1;
        // dd($quizzes);
        foreach($quizzes as $value) {
            $current_question = $value;
            $choices = $current_question['choices'];
            $current_answer = $request->input($ctx);
            $current_data = [
                'question' => $current_question['question'],
                'answer' => $current_answer,

            ];
            // dd($choices, $current_answer);
            // dd($current_answer);
            foreach ($choices as $choice) {
                $stripa = str_replace(' ', '', $choice['choice']);
                $stripb = str_replace(' ', '', $current_answer);
                // dd($stripa, $stripb);
                if($stripa == $stripb) {
                    // dd("DI PUMASOK DITO");
                    if ($choice['is_correct'] == true) {
                        $current_data['is_correct'] = true;
                        break;
                    } else {
                        $current_data['is_correct'] = false;
                        break;
                    }
                }
            }


            $data["data"][] = $current_data;
            $ctx++;
        }
        $this->storeData($this->database, 'TakenQuiz', $data);

        $this->updateData($this->database, 'Student', ['current_lesson' => $lesson_number + 1], session('user')['id']);
        $id = session('user')['id'];
        $user = $this->database->getReference('Student/' . session('user')['id'])->getValue();
        $student = $user;
        $student['id'] = $id;
        $request->session()->put('user', $student);
        return redirect()->route('end.quiz', ['lesson_number' => $lesson_number]);
        // dd($data["data"]);
    }
}
