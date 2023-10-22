<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;


    public function storeData($database, $table, $data) {
        if ($table == "Student") {
            $data['current_lesson'] = 0;
            $data['assessment_score'] = 0;
            $data['is_passed_lesson_1'] = 0;
            $data['is_passed_lesson_2'] = 0;
            $data['is_passed_lesson_3'] = 0;
            $data['is_passed_lesson_4'] = 0;
        }

        $database->getReference($table)
        ->push($data);
    }

    public function updateData($database, $table, $data, $id) {
        $database->getReference($table . '/' . $id)
        ->update($data);
    }

    public function deleteData($database, $table, $id) {
        $database->getReference($table . '/' . $id)
        ->remove();
    }

    public function getAllLessons($database, $gradelevel) {
        $gradeLevelLessons = [];
        $lessons = $database->getReference('Lesson')->getValue();
        foreach ($lessons as $key => $value) {
            if ($value['grade_level'] == $gradelevel) {
                $gradeLevelLessons[$key] = $value;
            }
        }

        return $gradeLevelLessons;
    }

    public function getStudentCurrentLesson ($database, $id) {
        $student = $database->getReference('Student/' . $id)->getValue();

        if(!array_key_exists("current_lesson",$student))
            return 0;

        return $student['current_lesson'];
    }


    public function getStudentAssessment ($database, $gradelevel) {
        $student = $database->getReference('Assessment')->getValue();

        $assessment = [];

        foreach ($student as $key => $value) {
            if ($value['grade_level'] == $gradelevel) {
                $assessment[$key] = $value;
            }
        }

        return $assessment;
    }

    public function getAllQuizzes($database, $lesson, $gradelevel) {
        $quiz = $database->getReference('Quiz')->getValue();
        $quizzes = [];

        foreach($quiz as $key => $value) {
            $lesson_is_same = str_contains($value['lesson'], strval($lesson));
            if($lesson_is_same && $value['grade_level'] == $gradelevel) {
                // $current = $value['questions'];
                // $current['id'] = $key;
                // $quizzes[] = [];
                // foreach($value['questions'] as $quiz) {
                //     $quiz['id'] = $key;
                // }
                // dd($value['questions']);

                $quizzes = $value['questions'];

                // foreach($quizzes as $quiz) {
                //     $quiz['id'] = $key;
                // }
            }
        }
        return $quizzes;
    }


    public function studentTakenAssessment($database, $id) {
        $student = $database->getReference('TakenAssessment')->getValue();
        // dd($student);
        if($student) {
            foreach ($student as $key => $value) {
                if ($value['student_id'] == $id) {
                    return $value;
                }
            }
        }


        return false;
    }

    public function quizIsTakenAssessment ($database, $lesson, $id) {
        $quizzes = $database->getReference('TakenQuiz')->getValue();
        if(!$quizzes)
            return false;
        foreach($quizzes as $quiz) {
            if ($quiz['lesson'] == $lesson && $quiz['student_id'] == $id) {
                return $quiz;
            }
            // $taken_assessment = $this->studentTakenAssessment($database, session('user')['id']);
            // if($taken_assessment) {
            //     foreach($taken_assessment['data'] as $data) {
            //         if($data['question'] == $quiz['question']) {
            //             return true;
            //         }
            //     }
            // }
        }

        return false;
    }


}
