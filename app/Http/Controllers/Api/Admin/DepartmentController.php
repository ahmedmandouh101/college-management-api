<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Resources\DepartmentResource;
use App\Http\Requests\StoreDepartmentRequest;   
use App\Http\Requests\UpdateDepartmentRequest;
class DepartmentController extends Controller
{
    public function index(){
        $departments = Department::all();
        return response()->json([
            'message' => 'Departments retrieved successfully',
            'data'    => DepartmentResource::collection($departments)
        ], 200);
    }

    public function store(StoreDepartmentRequest  $request){
        $department = Department::create($request->validated());
        return response()->json([
            'message' => 'Department created successfully',
            'data'    => new DepartmentResource($department)
        ], 201);
    }

    //Laravel automatically finds the department by ID from the URL and passes it to the function. If it doesn't exist, Laravel returns 404 automatically
    public function show(Department $department){
        return response()->json([
            'message' => 'Department retrieved successfully',
            'data'    => new DepartmentResource($department)
        ], 200);
    }

    public function update(UpdateDepartmentRequest $request, Department $department){
        $department->update($request->validated());

        return response()->json([
            'message' => 'Department updated successfully',
            'data'    => new DepartmentResource($department)
        ], 200);
    }

    public function destroy(Department $department){
        $department->delete();
        return response()->json([
            'message' => 'Department deleted successfully',
        ], 200);
    }
}
