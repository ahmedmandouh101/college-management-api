<?php

namespace App\Http\Controllers\Api\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\Grade;
use Illuminate\Http\Request;
use App\Http\Requests\AssignGradeRequest;
class GradeController extends Controller
{
    public function myCourses(Request $request)
    {
        $courses = $request->user()->taughtCourses()
            ->with(['department', 'enrollments.student.user'])
            ->get();

        return response()->json([
            'message' => 'Courses retrieved successfully',
            'data'    => $courses
        ], 200);
    }

    public function store(AssignGradeRequest  $request)
    {
        $enrollment = Enrollment::findOrFail($request->enrollment_id);

        // Make sure this teacher owns this course
        if ($enrollment->course->teacher_id !== $request->user()->id) {
            return response()->json([
                'message' => 'Unauthorized - This is not your course'
            ], 403);
        }

        $grade = Grade::updateOrCreate(
            ['enrollment_id' => $request->enrollment_id],
            [
                'grade'        => $request->grade,
                'letter_grade' => $this->getLetterGrade($request->grade)
            ]
        );

        return response()->json([
            'message' => 'Grade assigned successfully',
            'data'    => $grade
        ], 201);
    }

    private function getLetterGrade($grade)
    {
        if ($grade >= 90) return 'A';
        if ($grade >= 80) return 'B';
        if ($grade >= 70) return 'C';
        if ($grade >= 60) return 'D';
        return 'F';
    }
}