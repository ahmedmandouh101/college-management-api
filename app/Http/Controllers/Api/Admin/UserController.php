<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        return response()->json([
            'message' => 'Users retrieved successfully',
            'data'    => $users
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|string|email|unique:users',
            'password'      => 'required|string|min:6',
            'role'          => 'required|in:teacher,student',
            'department_id' => 'required_if:role,student|exists:departments,id'
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role
        ]);

        if ($request->role === 'student') {
            Student::create([
                'user_id'       => $user->id,
                'department_id' => $request->department_id,
                'student_code'  => 'STU-' . strtoupper(uniqid())
            ]);
        }

        return response()->json([
            'message' => 'User created successfully',
            'data'    => $user->load('student')
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