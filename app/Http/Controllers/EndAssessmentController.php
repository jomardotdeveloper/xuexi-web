<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
class EndAssessmentController extends Controller
{
    private $database;

    public function __construct()
    {
        $firebase = (new Factory)
        ->withServiceAccount(__DIR__.'/firebase_configurations.json')
        ->withDatabaseUri('https://laravel-firebase-xuexi-default-rtdb.firebaseio.com/');
        $this->database = $firebase->createDatabase();
    }
    public function index () {
        $grade_level_removed_grade = explode(" ", session('user')['grade_level'])[1];
        // dd($grade_level_removed_grade);
        $assessment = $this->getStudentAssessment($this->database, $grade_level_removed_grade);
        // dd($assessment);
        $is_taken = $this->studentTakenAssessment($this->database, session('user')['id']);

        $score = 0;
        if($is_taken) {
            foreach($is_taken['data'] as $data) {
                if($data['is_correct'] == true) {
                    $score += 1;
                }
            }
        }

        return view('end.assessment', compact('assessment', 'is_taken', 'score'));
    }

    public function store(Request $request) {
        // dd($request->all());
        // $data = $request->all();
        // $data['student_id'] = session('user')['id'];
        // $data['grade_level'] = explode(" ", session('user')['grade_level'])[1];
        // $this->storeData($this->database, 'Assessment', $data);
        $data = [
            "student_id" => session('user')['id'],
            "data" => []
        ];
        $grade_level_removed_grade = explode(" ", session('user')['grade_level'])[1];
        $assessment = $this->getStudentAssessment($this->database, $grade_level_removed_grade);

        $allRates = [];

        foreach($assessment as $key => $value) {
            $allRates[] = $value['rate'];
        }
        // dd($allRates);
        $progressiveRate = [];
        $rate = 0;

        foreach($assessment as $key => $value) {
            $current_question = $value;
            $choices = $current_question['choices'];
            $current_answer = $request->input($key);
            // dd($current_answer);
            // dd($choices[1]['choice'], $current_answer);
            // $stripa = str_replace(' ', '', $choices[1]['choice']);
            // $stripb = str_replace(' ', '', $current_answer);

            // dd($stripa == $stripb);

            $current_data = [
                'question' => $current_question['question'],
                'answer' => $current_answer
            ];
            foreach ($choices as $choice) {
                $stripa = str_replace(' ', '', $choice['choice']);
                $stripb = str_replace(' ', '', $current_answer);
                // dd($choice['is_correct']);
                if($stripa == $stripb) {
                    if ($choice['is_correct'] == true) {
                        $rate += intval($value['rate']);
                        $current_data['is_correct'] = true;
                        break;
                    } else {
                        $current_data['is_correct'] = false;
                        break;
                    }
                    // dd("JOMAR");
                }
            }

            $progressiveRate[] = $rate;

            $data["data"][] = $current_data;
        }
        // dd($rate);

        // dd($progressiveRate);

        // dd($rate);
        $this->storeData($this->database, 'TakenAssessment', $data);

        $current_lesson = 0;
        if($rate <= 12 && $rate >= 0) {
            $this->updateData($this->database, 'Student', ['current_lesson' => 1], session('user')['id']);
            $current_lesson++;
        }

        if($rate <= 24 && $rate > 12) {
            $this->updateData($this->database, 'Student', ['current_lesson' => 2], session('user')['id']);
            $current_lesson++;
            $current_lesson++;
        }

        if($rate <= 36 && $rate > 24) {
            $this->updateData($this->database, 'Student', ['current_lesson' => 3], session('user')['id']);
            $current_lesson++;
            $current_lesson++;
            $current_lesson++;
        }

        if($rate <= 48 && $rate > 36) {
            $this->updateData($this->database, 'Student', ['current_lesson' => 4], session('user')['id']);
            $current_lesson++;
            $current_lesson++;
            $current_lesson++;
            $current_lesson++;
        }

        if(($rate <= 60 && $rate > 48 )|| $rate > 60) {
            $this->updateData($this->database, 'Student', ['current_lesson' => 5], session('user')['id']);
            $current_lesson++;
            $current_lesson++;
            $current_lesson++;
            $current_lesson++;
            $current_lesson++;
        }

        $id = session('user')['id'];
        $user = $this->database->getReference('Student/' . session('user')['id'])->getValue();
        $student = $user;
        $student['id'] = $id;
        // dd($user);
        // foreach($user as $key => $value) {
        //     $student = $value;
        //     $student['id'] = $key;
        //     break;
        // }
        $request->session()->put('user', $student);
        // UPDATE SESSION FOR USER
        // $request->session('user')['current_lesson'] = $current_lesson;
        // $request->session('user')['current_lesson'] = $current_lesson;
        return redirect()->route('end.assessment');
    }
}
