<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\StudentStoreRequest;
use App\Http\Requests\v1\StudentUpdateRequest;
use App\Http\Resources\v1\StudentResource;
use App\Imports\StudentsImport;
use App\Models\Student;
use App\Traits\ApiPaginatorTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

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

    public function store(StudentStoreRequest $request)
    {
        $validated = $request->validated();
        $student = new Student;
        $data = $student->create($validated);

        return $this->return_api(true, Response::HTTP_CREATED, null, new StudentResource($data), null, null);
    }

    public function update(StudentUpdateRequest $request, Student $student)
    {
        // Get Validate Request
        $validated = $request->validated();
        $student = Student::find($student->id);
        $student->update($validated);

        return $this->return_api(true, Response::HTTP_ACCEPTED, 'Data Updated', new StudentResource($student), null, null);
    }

    public function show(Student $student)
    {
        return $this->return_api(true, Response::HTTP_FOUND, 'Found', new StudentResource($student), null, null);
    }

    public function delete(Student $student)
    {
        $student = Student::find($student->id);
        $student->delete();
        return $this->return_api(true, Response::HTTP_ACCEPTED, 'This student has been Deleted', new StudentResource($student), null, null);
    }

    public function importExcel(Request $request)
    {
        // Validate the uploaded file
        $validated = Validator::make($request->all(), [
            'file' => 'required|mimes:csv,excel'
        ]);

        $file = $request->file('file');

        // Check if a file was uploaded
        if ($request->hasFile('file')) {
            try {
                // Generate a unique filename
                $filename = uniqid() . '.' . $file->getClientOriginalExtension();
                // Save the file to the "uploads" disk
                Storage::disk('uploads')->put($filename, file_get_contents($file));

                //Import Excel
                Excel::import(new StudentsImport, $file);
            } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
                $failures = $e->failures();
                return $this->return_api(false, Response::HTTP_BAD_REQUEST, 'Validation failed', $failures, null, null);
            } catch (\Exception $e) {
                return $this->return_api(false, Response::HTTP_INTERNAL_SERVER_ERROR, 'File import failed', null, $e->getMessage(), null);
            }

            return $this->return_api(true, Response::HTTP_ACCEPTED, 'File uploaded and saved successfully', null, null, null);
        } else {
            return $this->return_api(false, Response::HTTP_BAD_REQUEST, 'No File Upload', null, null, null);
        }
    }
}
