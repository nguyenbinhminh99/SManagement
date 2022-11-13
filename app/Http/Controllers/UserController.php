<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUser;
use App\Models\User;
use App\Supports\Responder;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $users = User::query()->orderByDesc('id')->paginate(10);
        return response()->json([
            'status' => true,
            'message' => 'Success',
            'users' => $users
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
        if (!User::query()->where('id', $id)->exists()) {
            return response()->json([
                'id' => $id,
                'message' => 'ID not exist',
                'status' => false
            ]);
        }
        $user = User::query()
            ->where('id', $id)
            ->first();
        return response()->json([
            'status' => true,
            'message' => 'Success',
            'user' => $user
        ], 201);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreUser $request)
    {
        $user = '';
        try {
            $user = User::create($request->all());
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
            'user' => $user
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
    public function update(StoreUser $request, $id)
    {
        $user = '';
        if (preg_match('/[^0-9]/', $id)) {
            return response()->json([
                'id' => $id,
                'message' => 'ID must be number',
                'status' => false
            ]);
        }
        if (!User::query()->where('id', $id)->exists()) {
            return response()->json([
                'id' => $id,
                'message' => 'ID not exist',
                'status' => false
            ]);
        }
        try {
            User::where('id', $id)
                ->update([
                    'email' => $request->email,
                    'firstname' => $request->firstname,
                    'lastname' => $request->lastname,
                    'phone_number' => $request->phone_number,
                    'gender' => $request->gender,
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
            'user' => $user
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
        if (!User::query()->where('id', $id)->exists()) {
            return response()->json([
                'id' => $id,
                'message' => 'ID not exist',
                'status' => false
            ]);
        }
        $deleteUser = User::where('id', $id)->delete();
        return response()->json([
            'status' => true,
            'message' => 'Success',
            'user' => $deleteUser
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
    public function updateStatus(Request $request, $id)
    {
        $user = '';
        if (preg_match('/[^0-9]/', $id)) {
            return response()->json([
                'id' => $id,
                'message' => 'ID must be number',
                'status' => false
            ]);
        }
        if (!User::query()->where('id', $id)->exists()) {
            return response()->json([
                'id' => $id,
                'message' => 'ID not exist',
                'status' => false
            ]);
        }
        try {
            $user = User::where('id', $id)
                ->update([
                    'status' => $request->status,
                ]);
            if($user['status'] == 1)
            {
                $user->assignRole('user');
            }
            if($user['status'] == 0)
            {
                $user->removeRole('user');
            }
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
            'user' => $user
        ], 201);
    }
}
