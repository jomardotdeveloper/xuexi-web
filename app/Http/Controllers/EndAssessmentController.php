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
        $assessments = $this->database->getReference('AssessmentsV2')->getSnapshot()->getValue();
        $all_assessments = [];


        foreach ($assessments as $assessment) {
            if ($assessment['grade_level'] == $grade_level_removed_grade)
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

        // dd($all_assessments);

        // dd($all_assessments);
        // dd($grade_level_removed_grade);
        // $assessment = $this->getStudentAssessment($this->database, $grade_level_removed_grade);
        // // dd($assessment);
        // $is_taken = $this->studentTakenAssessment($this->database, session('user')['id']);

        // $score = 0;
        // if($is_taken) {
        //     foreach($is_taken['data'] as $data) {
        //         if($data['is_correct'] == true) {
        //             $score += 1;
        //         }
        //     }
        // }
        $taken_assessments = $this->database->getReference('TakenAssessmentsV2')->getSnapshot()->getValue();
        $user_taken_assessments = [];
        $score = 0;

        if($taken_assessments == null) {
            $taken_assessments = [];
        }


        foreach($taken_assessments as $assessment) {
            if(session('user')['id'] == $assessment['user_id']) {
                $user_taken_assessments[] = $assessment;
            }
        }

        foreach($user_taken_assessments as $taken) {
            if($taken['is_correct'] == true) {
                $score += 1;
            }
        }

        return view('end.assessment', compact('user_taken_assessments', 'score','identification', 'multiple_choice','true_or_false'));
    }

    public function store(Request $request) {
        $grade_level_removed_grade = explode(" ", session('user')['grade_level'])[1];
        $assessments = $this->database->getReference('AssessmentsV2')->getSnapshot()->getValue();
        $all_assessments = [];


        foreach ($assessments as $assessment) {
            if ($assessment['grade_level'] == $grade_level_removed_grade)
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
                "rate" => $assessment['rate'],
                "is_correct" => $answered_by == $true_answer ? true : false,
                "user_id" => session('user')['id'],
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
                "rate" => $assessment['rate'],
                "is_correct" => $answered_by == $true_answer ? true : false,
                "user_id" => session('user')['id'],
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
                "rate" => $assessment['rate'],
                "is_correct" => $answered_by == $true_answer ? true : false,
                "user_id" => session('user')['id'],
            ];

            $answered[] = $assessment_to_store;
            $i++;
        }


        foreach($answered as $ans) {
            $this->storeData($this->database, 'TakenAssessmentsV2', $ans);
        }

        $total_rates = 0;
        $total_rate_of_user = 0;
        $divided_by_lessons = 0;
        foreach($all_assessments as $assessment) {
            $total_rates += intval($assessment["rate"]);
        }

        foreach($answered as $answer) {
            if($answer['is_correct'] == true) {
                $total_rate_of_user += intval($answer['rate']);
            }
        }

        $divided_by_lessons = $total_rates / 4;

        $required_rate_1 = $divided_by_lessons;
        $required_rate_2 = $required_rate_1 + $required_rate_1;
        $required_rate_3 = $required_rate_2 + $required_rate_2;
        $required_rate_4 = $required_rate_3 + $required_rate_3;

        $current_lesson = 1;

        if ($total_rate_of_user > $required_rate_1) {
            $current_lesson = 1;
        } else if ($total_rate_of_user > $required_rate_2) {
            $current_lesson = 2;
        } else if ($total_rate_of_user > $required_rate_3) {
            $current_lesson = 3;
        }

        $this->updateData($this->database, 'Student', ['current_lesson' => $current_lesson], session('user')['id']);
        $id = session('user')['id'];
        $user = $this->database->getReference('Student/' . session('user')['id'])->getValue();
        $student = $user;
        $student['id'] = $id;
        $request->session()->put('user', $student);
        return redirect()->route('end.assessment');
        // dd($required_rate_1, $required_rate_2, $required_rate_3 , $required_rate_4);

        // dd($request->all()[1]);

        // dd($answered);
        // dd($request->all());
        // $data = $request->all();
        // $data['student_id'] = session('user')['id'];
        // $data['grade_level'] = explode(" ", session('user')['grade_level'])[1];
        // $this->storeData($this->database, 'Assessment', $data);
        // dd($request->all());
        // $data = [
        //     "student_id" => session('user')['id'],
        //     "data" => []
        // ];
        // $grade_level_removed_grade = explode(" ", session('user')['grade_level'])[1];
        // $assessment = $this->getStudentAssessment($this->database, $grade_level_removed_grade);

        // $allRates = [];

        // foreach($assessment as $key => $value) {
        //     $allRates[] = $value['rate'];
        // }
        // // dd($allRates);
        // $progressiveRate = [];
        // $rate = 0;

        // foreach($assessment as $key => $value) {
        //     $current_question = $value;
        //     $choices = $current_question['choices'];
        //     $current_answer = $request->input($key);
        //     // dd($current_answer);
        //     // dd($choices[1]['choice'], $current_answer);
        //     // $stripa = str_replace(' ', '', $choices[1]['choice']);
        //     // $stripb = str_replace(' ', '', $current_answer);

        //     // dd($stripa == $stripb);

        //     $current_data = [
        //         'question' => $current_question['question'],
        //         'answer' => $current_answer
        //     ];
        //     foreach ($choices as $choice) {
        //         $stripa = str_replace(' ', '', $choice['choice']);
        //         $stripb = str_replace(' ', '', $current_answer);
        //         // dd($choice['is_correct']);
        //         if($stripa == $stripb) {
        //             if ($choice['is_correct'] == true) {
        //                 $rate += intval($value['rate']);
        //                 $current_data['is_correct'] = true;
        //                 break;
        //             } else {
        //                 $current_data['is_correct'] = false;
        //                 break;
        //             }
        //             // dd("JOMAR");
        //         }
        //     }

        //     $progressiveRate[] = $rate;

        //     $data["data"][] = $current_data;
        // }
        // // dd($rate);

        // // dd($progressiveRate);

        // // dd($rate);
        // $this->storeData($this->database, 'TakenAssessment', $data);

        // $current_lesson = 0;
        // if($rate <= 12 && $rate >= 0) {
        //     $this->updateData($this->database, 'Student', ['current_lesson' => 1], session('user')['id']);
        //     $current_lesson++;
        // }

        // if($rate <= 24 && $rate > 12) {
        //     $this->updateData($this->database, 'Student', ['current_lesson' => 2], session('user')['id']);
        //     $current_lesson++;
        //     $current_lesson++;
        // }

        // if($rate <= 36 && $rate > 24) {
        //     $this->updateData($this->database, 'Student', ['current_lesson' => 3], session('user')['id']);
        //     $current_lesson++;
        //     $current_lesson++;
        //     $current_lesson++;
        // }

        // if($rate <= 48 && $rate > 36) {
        //     $this->updateData($this->database, 'Student', ['current_lesson' => 4], session('user')['id']);
        //     $current_lesson++;
        //     $current_lesson++;
        //     $current_lesson++;
        //     $current_lesson++;
        // }

        // if(($rate <= 60 && $rate > 48 )|| $rate > 60) {
        //     $this->updateData($this->database, 'Student', ['current_lesson' => 5], session('user')['id']);
        //     $current_lesson++;
        //     $current_lesson++;
        //     $current_lesson++;
        //     $current_lesson++;
        //     $current_lesson++;
        // }


        // UPDATE SESSION FOR USER
        // $request->session('user')['current_lesson'] = $current_lesson;
        // $request->session('user')['current_lesson'] = $current_lesson;
        return redirect()->route('end.assessment');
    }
}
