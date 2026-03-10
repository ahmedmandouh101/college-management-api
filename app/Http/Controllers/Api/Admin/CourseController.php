<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with(['department', 'teacher'])->get();

        return response()->json([
            'message' => 'Courses retrieved successfully',
            'data'    => $courses
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'code'          => 'required|string|unique:courses',
            'department_id' => 'required|exists:departments,id',
            'teacher_id'    => 'required|exists:users,id',
            'credits'       => 'required|integer|min:1|max:6'
        ]);

        $course = Course::create([
            'name'          => $request->name,
            'code'          => $request->code,
            'department_id' => $request->department_id,
            'teacher_id'    => $request->teacher_id,
            'credits'       => $request->credits
        ]);

        return response()->json([
            'message' => 'Course created successfully',
            'data'    => $course->load(['department', 'teacher'])
        ], 201);
    }

    public function show(Course $course)
    {
        return response()->json([
            'message' => 'Course retrieved successfully',
            'data'    => $course->load(['department', 'teacher'])
        ], 200);
    }

    public function update(Request $request, Course $course)
    {
        $request->validate([
            'name'          => 'sometimes|string|max:255',
            'code'          => 'sometimes|string|unique:courses,code,' . $course->id,
            'department_id' => 'sometimes|exists:departments,id',
            'teacher_id'    => 'sometimes|exists:users,id',
            'credits'       => 'sometimes|integer|min:1|max:6'
        ]);

        $course->update($request->only([
            'name', 'code', 'department_id', 'teacher_id', 'credits'
        ]));

        return response()->json([
            'message' => 'Course updated successfully',
            'data'    => $course->load(['department', 'teacher'])
        ], 200);
    }

    public function destroy(Course $course)
    {
        $course->delete();

        return response()->json([
            'message' => 'Course deleted successfully'
        ], 200);
    }
}