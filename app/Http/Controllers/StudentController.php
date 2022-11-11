<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudent;
use App\Models\School;
use App\Models\Student;
use App\Supports\Responder;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Activitylog\Models\Activity;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $students = Student::query()->with('school:id,name')->paginate(10);
        return response()->json([
            'message' => 'Success',
            'students' => $students
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        if (preg_match('/[^0-9]/', $id)) {
            return Responder::fail($id, 'id must be number');
        }
        if (!Student::query()->where('id', $id)->exists()) {
            return Responder::fail($id, 'Not exist');
        }
        $student = Student::query()
            ->where('id', $id)
            ->first();
        return response()->json([
            'message' => 'Success',
            'student' => $student
        ], 201);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreStudent $request)
    {
        $student = '';
        try {
            $student = Student::create($request->all());
        } catch (Exception $e) {
            return Responder::fail($student, $e->getMessage());
        }
        return response()->json([
            'message' => 'Success',
            'student' => $student
        ], 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(StoreStudent $request, $id)
    {
        $student = '';
        if (preg_match('/[^0-9]/', $id)) {
            return Responder::fail($id, 'id must be number');
        }
        if (!Student::query()->where('id', $id)->exists()) {
            return Responder::fail($id, 'Not exist');
        }
        try {
            Student::where('id', $id)
                ->update([
                    'firstname' => $request->firstname,
                    'lastname' => $request->lastname,
                    'phone_number' => $request->phone_number,
                    'email' => $request->email,
                    'gender' => $request->gender,
                    'identification' => $request->identification,
                    'address' => $request->address
                ]);
        } catch (Exception $e) {
            return Responder::fail($student, $e->getMessage());
        }
        return response()->json([
            'message' => 'Success',
            'student' => $student
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        if (preg_match('/[^0-9]/', $id)) {
            return Responder::fail($id, 'id is not number');
        }
        if (!Student::query()->where('id', $id)->exists()) {
            return Responder::fail($id, 'Not exist');
        }
        $deleteStudent = Student::where('id', $id)->delete();
        return response()->json([
            'message' => 'Success',
            'student' => $deleteStudent
        ], 201);
    }

    public function log()
    {
        return Activity::all()->last();
    }
}
