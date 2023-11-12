<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\StudentStoreRequest;
use App\Http\Requests\v1\StudentUpdateRequest;
use App\Http\Resources\v1\StudentResource;
use App\Models\Student;
use App\Traits\ApiPaginatorTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class StudentController extends Controller
{
    use ApiPaginatorTrait;

    public function listStudent(Request $request)
    {
        // Get take and search value from params
        $take = request()->get('take', 100000);
        $search = request()->get('search', '');

        // Return list of paginated data
        $data = Student::query();

        // Search name from student table
        if ($search !== '') {
            $data->where(function ($query) use ($search) {
                $query->where('name', 'LIKE', '%' . $search . '%')
                    ->orWhere('email', 'LIKE', '%' . $search . '%');
            });
        }

        $data = $data->latest()->paginate($take);

        return $this->return_paginated_api(true, Response::HTTP_OK, null, StudentResource::collection($data), null, $this->apiPaginator($data));
    }

    public function importExcel()
    {
    }

    public function store(StudentStoreRequest $request)
    {
        $validated = $request->validated();

        $validated['study_course_id'] = $validated['course']['id'];
        $student = new Student;
        $data = $student->create($validated);

        return $this->return_api(true, Response::HTTP_CREATED, null, new StudentResource($data), null,null);
    }

    public function update(StudentUpdateRequest $request, Student $student)
    {
        // Get Validate Request
        $validated = $request->validated();
        $student = Student::find($student->id);
        $student->update($validated);

        return $this->return_api(true, Response::HTTP_ACCEPTED, null, new StudentResource($student), null,null);
    }

    public function show()
    {
    }
}
