<?php

namespace App\Http\Controllers;

use Exception;
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
        $lesson_str = file_get_contents(__DIR__.'/Lessons.csv');
        $lessons = explode("\n", $lesson_str);

        $reference = $this->database->getReference('LessonsV2');
        $reference->remove();


        foreach($lessons as $lesson) {
            if(!$lesson)
                break;
            $lesson_to_explode = explode(",", $lesson);
            $lesson_to_store = [
                "name" => $lesson_to_explode[0],
                "number" => $lesson_to_explode[1],
                "category" => $lesson_to_explode[2],
                "rate" => $lesson_to_explode[3],
                "grade_level" => $lesson_to_explode[4],
            ];

            $this->storeData($this->database,
                             "LessonsV2",
                             $lesson_to_store);

            $lesson_item_str = file_get_contents(__DIR__.'/LessonItemsV2.csv');
            $lesson_items = explode("\n", $lesson_item_str);

            $reference = $this->database->getReference('LessonItemsV2');
            $reference->remove();

            foreach($lesson_items as $lesson_item) {
                if(!$lesson_item)
                    break;

                $lesson_item_to_explode = explode(",", $lesson_item);

                $lesson_item_to_store = [
                    "english" => $lesson_item_to_explode[0],
                    "chinese" => $lesson_item_to_explode[1],
                    "chinese_character" => $lesson_item_to_explode[2],
                    "rate" => $lesson_item_to_explode[3],
                    "number" => $lesson_item_to_explode[4],
                    "category" => $lesson_item_to_explode[5],
                    "grade_level" => $lesson_item_to_explode[6],
                ];

                $this->storeData($this->database,
                                 "LessonItemsV2",
                                 $lesson_item_to_store);
            }

            $quiz_str = file_get_contents(__DIR__.'/Quizzes.csv');
            $quizzes = explode("\n", $quiz_str);

            $reference = $this->database->getReference('QuizzesV2');
            $reference->remove();

            foreach($quizzes as $quiz) {
                if(!$quiz)
                    break;
                $quiz_to_explode = explode(",", $quiz);
                $quiz_to_store = [
                    "question" => $quiz_to_explode[0],
                    "quiz_number" => $quiz_to_explode[1],
                    "lesson_number" => $quiz_to_explode[2],
                    "grade_level" => $quiz_to_explode[3],
                    "type" => $quiz_to_explode[4],
                    "choice1" => "N/A",
                    "choice2" => "N/A",
                    "choice3" => "N/A",
                    "choice4" => "N/A",
                    "answer" => $quiz_to_explode[5]
                ];

                if($quiz_to_explode == "Multiple choice") {
                    $quiz_to_store["choice1"] = $quiz_to_explode[6];
                    $quiz_to_store["choice2"] = $quiz_to_explode[7];
                    $quiz_to_store["choice3"] = $quiz_to_explode[8];
                    $quiz_to_store["choice4"] = $quiz_to_explode[9];
                } else if ($quiz_to_explode == "True or False") {
                    $quiz_to_store["choice1"] = "True";
                    $quiz_to_store["choice2"] = "False";
                }

                $this->storeData($this->database,
                                 "QuizzesV2",
                                 $quiz_to_store);
            }

            $assessment_str = file_get_contents(__DIR__.'/Assessments.csv');
            $assessments = explode("\n", $assessment_str);

            $reference = $this->database->getReference('AssessmentsV2');
            $reference->remove();

            foreach($assessments as $assessment) {
                if(!$assessment)
                    break;
                try{
                    $assessment_to_explode = explode(",", $assessment);
                    $assessment_to_store = [
                        "question" => $assessment_to_explode[0],
                        "grade_level" => $assessment_to_explode[1],
                        "type" => $assessment_to_explode[2],
                        "answer" => $assessment_to_explode[3],
                        "choice1" => "N/A",
                        "choice2" => "N/A",
                        "choice3" => "N/A",
                        "choice4" => "N/A",
                        "rate" => $assessment_to_explode[8],
                    ];

                    if($assessment_to_explode == "Multiple choice") {
                        $assessment_to_store["choice1"] = $assessment_to_explode[4];
                        $assessment_to_store["choice2"] = $assessment_to_explode[5];
                        $assessment_to_store["choice3"] = $assessment_to_explode[6];
                        $assessment_to_store["choice4"] = $assessment_to_explode[7];
                    } else if ($assessment_to_explode == "True or False") {
                        $assessment_to_store["choice1"] = "True";
                        $assessment_to_store["choice2"] = "False";
                    }

                    $this->storeData($this->database,
                                    "AssessmentsV2",
                                    $assessment_to_store);
                }catch(Exception $e){
                    dd($assessment_to_explode);
                }
            }


        }

        // dd(explode("\n",$lessons));
        // dd(explode("\n"))
        // $this->storeQuizzes();
        // $this->storeAssessments();
        // $this->storeLessons();
        // $this->storeConversations();
        // $this->clearFirebase();
        // $this->createInitialAdmin();
    }


    // V2
    public function storeLesson2 () {
        $grade6 = file_get_contents(__DIR__.'/grade6_lesson.json');
        $grade6 = json_decode($grade6, true);
        $grade5 = file_get_contents(__DIR__.'/grade5_lesson.json');
        $grade5 = json_decode($grade5, true);
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
