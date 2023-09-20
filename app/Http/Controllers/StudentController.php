<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Factory;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $database;

    public function __construct()
    {
        $firebase = (new Factory)
        ->withServiceAccount(__DIR__.'/firebase_configurations.json')
        ->withDatabaseUri('https://laravel-firebase-xuexi-default-rtdb.firebaseio.com/');
        $this->database = $firebase->createDatabase();
    }

    public function index()
    {
        $students = $this->database->getReference('Student')->getSnapshot()->getValue();

        if ($students == null) {
            $students = [];
        }
        // foreach ($students as $key => $value) {
        //     // $students[$key]['id'] = $key;
        //     echo $value;
        // }
        // dd($students);
        return view('student.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('student.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $postData = [
            "first_name" => $request->first_name,
            "middle_name" =>  $request->middle_name,
            "last_name" => $request->last_name,
            "gender" =>  $request->gender,
            "grade_level" => $request->grade_level,
            "email" => $request->email,
            "password" => $request->password,
        ];

        $this->storeData($this->database,
                         "Student",
                         $postData);

        return redirect()->route('students.index')->with(['success' => ['Student successfully created!']]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $students = $this->database->getReference('Student')->getSnapshot()->getValue();
        $student = $students[$id];
        return view('student.show', compact('student', 'id'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $students = $this->database->getReference('Student')->getSnapshot()->getValue();
        $student = $students[$id];
        return view('student.edit', compact('student', 'id'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $postData = [
            "first_name" => $request->first_name,
            "middle_name" =>  $request->middle_name,
            "last_name" => $request->last_name,
            "gender" =>  $request->gender,
            "grade_level" => $request->grade_level,
        ];

        $this->updateData($this->database,
                          "Student",
                          $postData,
                          $id);
        return redirect()->route('students.index')->with(['success' => ['Student successfully updated!']]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->deleteData($this->database,
                          "Student",
                          $id);
        return redirect()->route('students.index')->with(['success' => ['Student successfully deleted!']]);
    }
}
