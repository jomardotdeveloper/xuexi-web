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
        $lesson_number = $_GET['lesson_number'];
        $assessments = $this->database->getReference('QuizzesV2')->getSnapshot()->getValue();
        $all_assessments = [];


        foreach ($assessments as $assessment) {
            if ($assessment['grade_level'] == $grade_level_removed_grade && $assessment['lesson_number'] == $lesson_number)
                $all_assessments[] = $assessment;
        }


        // dd($all_assessments);
        $multiple_choice = [];
        $identification = [];
        $true_or_false = [];


        foreach ($all_assessments as $assessment) {
            if($assessment['type'] == "True or False") {
                $true_or_false[] = $assessment;
            } else if ($assessment["type"] == "Multiple Choice") {
                $multiple_choice[] = $assessment;
            } else {
                $identification[] = $assessment;
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

        // dd($is_taken);
        return view('end.quiz', compact('score', 'user_taken_assessments','multiple_choice', 'lesson_number', 'identification', 'true_or_false'));
    }

    public function store (Request $request) {

        $grade_level_removed_grade = explode(" ", session('user')['grade_level'])[1];
        $lesson_number = $request->get("lesson_number");
        $assessments = $this->database->getReference('QuizzesV2')->getSnapshot()->getValue();
        $all_assessments = [];


        foreach ($assessments as $assessment) {
            if ($assessment['grade_level'] == $grade_level_removed_grade && $assessment['lesson_number'] == $lesson_number)
                $all_assessments[] = $assessment;
        }

        $multiple_choice = [];
        $identification = [];
        $true_or_false = [];


        foreach ($all_assessments as $assessment) {
            if($assessment['type'] == "True or False") {
                $true_or_false[] = $assessment;
            } else if ($assessment["type"] == "Multiple Choice") {
                $multiple_choice[] = $assessment;
            } else {
                $identification[] = $assessment;
            }
        }

        $i = 1;
        $response = $request->all();
        $answered = [];

        foreach ($multiple_choice as $assessment) {
            $answered_by = strtoupper(str_replace(' ', '', $response[$i]));
            $true_answer = strtoupper(str_replace(' ', '', $assessment['answer']));
            $assessment_to_store = [
                "question" => $assessment['question'],
                "grade_level" => $assessment['grade_level'],
                "type" => $assessment['type'],
                "answer" => $assessment['answer'],
                "choice1" => $assessment['choice1'],
                "choice2" => $assessment['choice2'],
                "choice3" => $assessment['choice3'],
                "choice4" => $assessment['choice4'],
                // "rate" => $assessment['rate'],
                "is_correct" => $answered_by == $true_answer ? true : false,
                "user_id" => session('user')['id'],
                "lesson_number" => $lesson_number,
            ];

            $answered[] = $assessment_to_store;
            $i++;
        }

        foreach ($true_or_false as $assessment) {
            $answered_by = strtoupper(str_replace(' ', '', $response[$i]));
            $true_answer = strtoupper(str_replace(' ', '', $assessment['answer']));
            $assessment_to_store = [
                "question" => $assessment['question'],
                "grade_level" => $assessment['grade_level'],
                "type" => $assessment['type'],
                "answer" => $assessment['answer'],
                "choice1" => $assessment['choice1'],
                "choice2" => $assessment['choice2'],
                "choice3" => $assessment['choice3'],
                "choice4" => $assessment['choice4'],
                // "rate" => $assessment['rate'],
                "is_correct" => $answered_by == $true_answer ? true : false,
                "user_id" => session('user')['id'],
                "lesson_number" => $lesson_number,
            ];

            $answered[] = $assessment_to_store;
            $i++;
        }

        foreach ($identification as $assessment) {
            $answered_by = strtoupper(str_replace(' ', '', $response[$i]));
            $true_answer = strtoupper(str_replace(' ', '', $assessment['answer']));
            $assessment_to_store = [
                "question" => $assessment['question'],
                "grade_level" => $assessment['grade_level'],
                "type" => $assessment['type'],
                "answer" => $assessment['answer'],
                "choice1" => $assessment['choice1'],
                "choice2" => $assessment['choice2'],
                "choice3" => $assessment['choice3'],
                "choice4" => $assessment['choice4'],
                // "rate" => $assessment['rate'],
                "is_correct" => $answered_by == $true_answer ? true : false,
                "user_id" => session('user')['id'],
                "lesson_number" => $lesson_number,
            ];

            $answered[] = $assessment_to_store;
            $i++;
        }

        $score = 0;


        foreach ($answered as $cur) {
            if ($cur['is_correct'] == true) {
                $score++;
            }
        }


        if($score < 8)
            return redirect()->route('end.quiz', ['lesson_number' => $lesson_number])->with('error', 'You failed the quiz. Please try again.');


        foreach($answered as $ans) {
            $this->storeData($this->database, 'TakenQuizzesV2', $ans);
        }

        $this->updateData($this->database, 'Student', ['current_lesson' => $lesson_number + 1], session('user')['id']);

        $id = session('user')['id'];
        $user = $this->database->getReference('Student/' . session('user')['id'])->getValue();
        $student = $user;
        $student['id'] = $id;
        $request->session()->put('user', $student);

        // dd($request->all());
        // $data = [
        //     "student_id" => session('user')['id'],
        //     "data" => [],
        //     "lesson" => $request->get('lesson_number')
        // ];
        // $grade_level_removed_grade = explode(" ", session('user')['grade_level'])[1];
        // $lesson_number = $request->get('lesson_number');
        // $quizzes = $this->getAllQuizzes($this->database, $lesson_number, $grade_level_removed_grade);
        // $ctx = 1;
        // // dd($quizzes);
        // foreach($quizzes as $value) {
        //     $current_question = $value;
        //     $choices = $current_question['choices'];
        //     $current_answer = $request->input($ctx);
        //     $current_data = [
        //         'question' => $current_question['question'],
        //         'answer' => $current_answer,

        //     ];
        //     // dd($choices, $current_answer);
        //     // dd($current_answer);
        //     foreach ($choices as $choice) {
        //         $stripa = str_replace(' ', '', $choice['choice']);
        //         $stripb = str_replace(' ', '', $current_answer);
        //         // dd($stripa, $stripb);
        //         if($stripa == $stripb) {
        //             // dd("DI PUMASOK DITO");
        //             if ($choice['is_correct'] == true) {
        //                 $current_data['is_correct'] = true;
        //                 break;
        //             } else {
        //                 $current_data['is_correct'] = false;
        //                 break;
        //             }
        //         }
        //     }


        //     $data["data"][] = $current_data;
        //     $ctx++;
        // }
        // $this->storeData($this->database, 'TakenQuiz', $data);

        // $this->updateData($this->database, 'Student', ['current_lesson' => $lesson_number + 1], session('user')['id']);
        // $id = session('user')['id'];
        // $user = $this->database->getReference('Student/' . session('user')['id'])->getValue();
        // $student = $user;
        // $student['id'] = $id;
        // $request->session()->put('user', $student);
        return redirect()->route('end.quiz', ['lesson_number' => $lesson_number]);
        // dd($data["data"]);
    }
}
