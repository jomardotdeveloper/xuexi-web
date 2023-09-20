<?php

namespace App\Http\Controllers;

use Kreait\Firebase\Factory;
use Illuminate\Http\Request;

class AdminController extends Controller
{
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
        $admins = $this->database->getReference('Admin')->getSnapshot()->getValue();

        if ($admins == null) {
            $admins = [];
        }
        // foreach ($admins as $key => $value) {
        //     // $admins[$key]['id'] = $key;
        //     echo $value;
        // }
        // dd($admins);
        return view('admin.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.create');
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
                         "Admin",
                         $postData);

        return redirect()->route('admins.index')->with(['success' => ['Admin successfully created!']]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $admins = $this->database->getReference('Admin')->getSnapshot()->getValue();
        $admin = $admins[$id];
        return view('admin.show', compact('admin', 'id'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $admins = $this->database->getReference('Admin')->getSnapshot()->getValue();
        $admin = $admins[$id];
        return view('admin.edit', compact('admin', 'id'));
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
                          "Admin",
                          $postData,
                          $id);
        return redirect()->route('admins.index')->with(['success' => ['Admin successfully updated!']]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->deleteData($this->database,
                          "Admin",
                          $id);
        return redirect()->route('admins.index')->with(['success' => ['Admin successfully deleted!']]);
    }
}
