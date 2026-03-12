<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserResource;
use App\Http\Requests\StoreUserRequest;
class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        return response()->json([
            'message' => 'Users retrieved successfully',
            'data'    => UserResource::collection($users)
        ], 200);
    }

    public function store(StoreUserRequest  $request)
    {
        $user = User::create($request->validated());

        if ($request->role === 'student') {
            Student::create([
                'user_id'       => $user->id,
                'department_id' => $request->department_id,
                'student_code'  => 'STU-' . strtoupper(uniqid())
            ]);
        }

        return response()->json([
            'message' => 'User created successfully',
            'data'    => new UserResource($user->load('student'))
        ], 201);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->json([
            'message' => 'User deleted successfully'
        ], 200);
    }
}