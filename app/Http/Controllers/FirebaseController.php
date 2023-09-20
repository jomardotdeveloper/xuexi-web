<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Factory;

class FirebaseController extends Controller
{
    private $database;

    public function __construct()
    {
        $firebase = (new Factory)
        ->withServiceAccount(__DIR__.'/firebase_configurations.json')
        ->withDatabaseUri('https://laravel-firebase-xuexi-default-rtdb.firebaseio.com/');
        $this->database = $firebase->createDatabase();
    }
    public function create() {
        $this->storeQuizzes();
        $this->storeAssessments();
        $this->storeLessons();
        $this->storeConversations();
        $this->clearFirebase();
        $this->createInitialAdmin();
    }

    private function clearFirebase() {
        $reference = $this->database->getReference('Admin');
        $reference->remove();

        $reference = $this->database->getReference('Student');
        $reference->remove();

        $reference = $this->database->getReference('TakenAssessment');
        $reference->remove();

        $reference = $this->database->getReference('TakenQuiz');
        $reference->remove();
    }

    private function createInitialAdmin() {
        $postData = [
            "first_name" => "John",
            "middle_name" =>  "D",
            "last_name" => "Doe",
            "gender" =>  "Male",
            "grade_level" => "Grade 5",
            "email" => "admin@superuser.com",
            "password" => "123",
        ];

        $this->storeData($this->database,
                         "Admin",
                         $postData);

        $studentData = [
            "first_name" => "John",
            "middle_name" =>  "D",
            "last_name" => "Doe",
            "gender" =>  "Male",
            "grade_level" => "Grade 5",
            "email" => "student@test.com",
            "password" => "123",
        ];

        $this->storeData($this->database,
                         "Student",
                         $studentData);
    }


    private function storeLessons () {
        $grade6 = file_get_contents(__DIR__.'/grade6_lesson.json');
        $grade6 = json_decode($grade6, true);
        $grade5 = file_get_contents(__DIR__.'/grade5_lesson.json');
        $grade5 = json_decode($grade5, true);


        $reference = $this->database->getReference('Lesson');
        $reference->remove();

        foreach ($grade5 as $key => $value) {
            $lesson_name = $key;
            $contents = $value["Content"];

            foreach($contents as $content) {
                $current = [
                    "lesson" => $lesson_name,
                    "content" => $content,
                    "grade_level" => "5",
                ];
                $this->storeData($this->database,
                         "Lesson",
                         $current);
            }

        }

        foreach($grade6 as $lessons) {
            foreach($lessons as $lesson) {
                // dd($lesson);
                $lesson_name = $lesson["lesson"];
                $contents = $lesson["sentences"];

                foreach($contents as $content) {
                    $current = [
                        "lesson" => $lesson_name,
                        "content" => $content,
                        "grade_level" => "6",
                    ];
                    $this->storeData($this->database,
                             "Lesson",
                             $current);
                }
            }

        }
    }

    private function storeConversations () {
        $grade6 = file_get_contents(__DIR__.'/grade6_conversation.json');
        $grade6 = json_decode($grade6, true);
        $grade5 = file_get_contents(__DIR__.'/grade5_conversation.json');
        $grade5 = json_decode($grade5, true);

        $reference = $this->database->getReference('Conversation');
        $reference->remove();

        foreach($grade5 as $lessons) {
            foreach($lessons as $lesson) {
                // dd($lesson);
                $lesson_name = $lesson["lesson"];
                $contents = $lesson["sentences"];

                foreach($contents as $content) {
                    $current = [
                        "lesson" => $lesson_name,
                        "content" => $content,
                        "grade_level" => "5",
                    ];
                    $this->storeData($this->database,
                             "Conversation",
                             $current);
                }
            }

        }


        foreach($grade6 as $lessons) {
            foreach($lessons as $lesson) {
                // dd($lesson);
                $lesson_name = $lesson["lesson"];
                $contents = $lesson["sentences"];

                foreach($contents as $content) {
                    $current = [
                        "lesson" => $lesson_name,
                        "content" => $content,
                        "grade_level" => "6",
                    ];
                    $this->storeData($this->database,
                             "Conversation",
                             $current);
                }
            }

        }
    }

    private function storeQuizzes () {
        $grade6 = file_get_contents(__DIR__.'/grade6_quiz.json');
        $grade6 = json_decode($grade6, true);

        $grade5 = file_get_contents(__DIR__.'/grade5_quiz.json');
        $grade5 = json_decode($grade5, true);

        $reference = $this->database->getReference('Quiz');
        $reference->remove();


        foreach ($grade5 as $key => $value) {
            $lesson = [
                "lesson" => $key,
                "grade_level" => "5",
                "questions" => [],
                "rate" => $value["Rate"],
            ];
            // dd($value["Rate"]);
            // dd($value["Questions"]);
            foreach($value["Questions"] as $question) {
                $current = [
                    // "rate" => $question_values["Rate"],
                    "question" => $question["Question"],
                    "choices" => [],
                    "grade_level" => "5",
                ];

                foreach($question["Options"] as $choice_key => $choice_value) {
                    $current_choice_data = [
                        "choice" => $choice_value,
                        "is_correct" => false,
                    ];
                    if(str_contains($choice_value, "Correct Answer")) {
                        $current_choice_data["is_correct"] = true;
                        $current_choice_data["choice"] = str_replace("Correct Answer", "", $choice_value);;
                    } else {
                        $current_choice_data["is_correct"] = false;
                    }

                    array_push($current["choices"], $current_choice_data);
                }

                array_push($lesson["questions"], $current);
            }

            $this->storeData($this->database,
                         "Quiz",
                         $lesson);

        }

        foreach ($grade6 as $key => $value) {
            $lesson = [
                "lesson" => $key,
                "grade_level" => "6",
                "questions" => [],
                "rate" => $value["Rate"],
            ];
            // dd($value["Rate"]);
            // dd($value["Questions"]);
            foreach($value["Questions"] as $question) {
                $current = [
                    // "rate" => $question_values["Rate"],
                    "question" => $question["Question"],
                    "choices" => [],
                    "grade_level" => "6",
                ];

                foreach($question["Options"] as $choice_key => $choice_value) {
                    $current_choice_data = [
                        "choice" => $choice_value,
                        "is_correct" => false,
                    ];
                    if(str_contains($choice_value, "Correct Answer")) {
                        $current_choice_data["is_correct"] = true;
                        $current_choice_data["choice"] = str_replace("Correct Answer", "", $choice_value);;
                    } else {
                        $current_choice_data["is_correct"] = false;
                    }

                    array_push($current["choices"], $current_choice_data);
                }

                array_push($lesson["questions"], $current);
            }

            $this->storeData($this->database,
                         "Quiz",
                         $lesson);

        }
    }

    private function storeAssessments () {
        $grade5 = file_get_contents(__DIR__.'/grade5_assessment.json');
        $grade5 = json_decode($grade5, true);


        $grade6 = file_get_contents(__DIR__.'/grade6_assessment.json');
        $grade6 = json_decode($grade6, true);

        $reference = $this->database->getReference('Assessment');
        $reference->remove();

        foreach ($grade5 as $key => $value) {
            foreach($value as $question_name => $question_values) {
                $current = [
                    "rate" => $question_values["Rate"],
                    "question" => $question_values["Question"],
                    "choices" => [],
                    "grade_level" => "5",
                ];

                foreach($question_values["Options"] as $choice_key => $choice_value) {
                    $current_choice_data = [
                        "choice" => $choice_value,
                        "is_correct" => false,
                    ];
                    if(str_contains($choice_value, "Correct Answer")) {
                        $current_choice_data["is_correct"] = true;
                        $current_choice_data["choice"] = str_replace("Correct Answer", "", $choice_value);;
                    } else {
                        $current_choice_data["is_correct"] = false;
                    }

                    array_push($current["choices"], $current_choice_data);
                }
                $this->storeData($this->database,
                         "Assessment",
                         $current);
            }

        }


        foreach ($grade6 as $key => $value) {
            foreach($value as $question_name => $question_values) {
                $current = [
                    "rate" => $question_values["Rate"],
                    "question" => $question_values["Question"],
                    "choices" => [],
                    "grade_level" => "6",
                ];

                foreach($question_values["Options"] as $choice_key => $choice_value) {
                    $current_choice_data = [
                        "choice" => $choice_value,
                        "is_correct" => false,
                    ];
                    if(str_contains($choice_value, "Correct Answer")) {
                        $current_choice_data["is_correct"] = true;
                        $current_choice_data["choice"] = str_replace("Correct Answer", "", $choice_value);;
                    } else {
                        $current_choice_data["is_correct"] = false;
                    }

                    array_push($current["choices"], $current_choice_data);
                }
                $this->storeData($this->database,
                         "Assessment",
                         $current);
            }

        }




    }
}
