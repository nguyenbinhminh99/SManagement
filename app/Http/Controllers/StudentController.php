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
    public function index(Request $request)
    {
        $search = $request->query('search') ?? '';
        $students = Student::query()->where('firstname', 'like', "%$search%")->with('school:id,name')->paginate(10);
        return response()->json([
            'status' => true,
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
            return response()->json([
                'id' => $id,
                'message' => 'ID must be number',
                'status' => false
            ]);
        }
        if (!Student::query()->where('id', $id)->exists()) {
            return response()->json([
                'id' => $id,
                'message' => 'ID not exist',
                'status' => false
            ]);
        }
        $student = Student::query()
            ->where('id', $id)
            ->first();
        return response()->json([
            'status' => true,
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
            return response()->json([
                'error' => $e,
                'message' => 'Failed',
                'status' => false
            ]);
        }
        return response()->json([
            'status' => true,
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
            return response()->json([
                'id' => $id,
                'message' => 'ID must be number',
                'status' => false
            ]);
        }
        if (!Student::query()->where('id', $id)->exists()) {
            return response()->json([
                'id' => $id,
                'message' => 'ID not exist',
                'status' => false
            ]);
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
            return response()->json([
                'error' => $e,
                'message' => 'Failed',
                'status' => false
            ]);
        }
        return response()->json([
            'status' => true,
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
            return response()->json([
                'id' => $id,
                'message' => 'ID must be number',
                'status' => false
            ]);
        }
        if (!Student::query()->where('id', $id)->exists()) {
            return response()->json([
                'id' => $id,
                'message' => 'ID not exist',
                'status' => false
            ]);
        }
        $deleteStudent = Student::where('id', $id)->delete();
        return response()->json([
            'status' => true,
            'message' => 'Success',
            'student' => $deleteStudent
        ], 201);
    }

    public function log()
    {
        return Activity::all()->last();
    }

}
