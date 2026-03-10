<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\Course;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function myCourses(Request $request)
    {
        $student = $request->user()->student;

        if (!$student) {
            return response()->json([
                'message' => 'Student profile not found'
            ], 404);
        }

        $enrollments = $student->enrollments()
            ->with(['course.department', 'course.teacher', 'grade'])
            ->get();

        return response()->json([
            'message' => 'Courses retrieved successfully',
            'data'    => $enrollments
        ], 200);
    }

    public function enroll(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id'
        ]);

        $student = $request->user()->student;

        if (!$student) {
            return response()->json([
                'message' => 'Student profile not found'
            ], 404);
        }

        $alreadyEnrolled = Enrollment::where('student_id', $student->id)
            ->where('course_id', $request->course_id)
            ->exists();

        if ($alreadyEnrolled) {
            return response()->json([
                'message' => 'Already enrolled in this course'
            ], 409);
        }

        $enrollment = Enrollment::create([
            'student_id' => $student->id,
            'course_id'  => $request->course_id
        ]);

        return response()->json([
            'message' => 'Enrolled successfully',
            'data'    => $enrollment->load(['course.department', 'course.teacher'])
        ], 201);
    }

    public function myGrades(Request $request)
    {
        $student = $request->user()->student;

        if (!$student) {
            return response()->json([
                'message' => 'Student profile not found'
            ], 404);
        }

        $grades = $student->enrollments()
            ->with(['course', 'grade'])
            ->get()
            ->map(function ($enrollment) {
                return [
                    'course'       => $enrollment->course->name,
                    'grade'        => $enrollment->grade?->grade ?? 'Not graded yet',
                    'letter_grade' => $enrollment->grade?->letter_grade ?? 'N/A'
                ];
            });

        return response()->json([
            'message' => 'Grades retrieved successfully',
            'data'    => $grades
        ], 200);
    }
}