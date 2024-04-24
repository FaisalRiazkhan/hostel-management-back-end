<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
class StudentController extends Controller
{
    public function addStudent(Request $request)
    {
        // Validate incoming request data
        $data = $request->all();
        $validator = $request->validate([
            'first_name' => 'required|string|regex:/^[a-zA-Z]+$/',
            'last_name' => 'required|string|regex:/^[a-zA-Z]+$/',
            'national_id_no' => ['required', 'regex:/^[0-9]{5}-[0-9]{7}-[0-9]$/'],
            'email' => 'required|email',
            'contact_no' =>  ['required', 'regex:/^03[0-9]{9}$/'],
            'nationality' => 'required|string|regex:/^[a-zA-Z]+$/',
            'religion' => 'required|string|regex:/^[a-zA-Z]+$/',
            'gender' => 'required|string|regex:/^[a-zA-Z]+$/',
            'permanent_address' => 'required|string',
            'district' => 'required|string',
            'province' => 'required|string',
            'current_address' => 'nullable|string',
            'current_district' => 'nullable|string',
            'current_province' => 'nullable|string',
            'guardian_name' => 'required|string|regex:/^[a-zA-Z]+$/',
            'guardian_id_no' =>  ['required', 'regex:/^[0-9]{5}-[0-9]{7}-[0-9]$/'],
            'guardian_contact_no' => ['required', 'regex:/^03[0-9]{9}$/'],
            'guardian_occupation' => 'required|string',
            // Add validation rules for other fields
        ]);
        if ($validator->fails()) {
            return responseValidationError('Fields Validation Failed.', $validator->errors());
        }
    
        // Create a new student using validated data
        $student = Student::create([
            'first_name' => $request->input('first_name'), // Access first_name field from request
            'last_name' => $request->input('last_name'),
            'national_id_no' => $request->input('national_id_no'),
            'email' => $request->input('email'),
            'contact_no' => $request->input('contact_no'),
            'nationality' => $request->input('nationality'),
            'religion' => $request->input('religion'),
            'gender' => $request->input('gender'),
            'permanent_address' => $request->input('permanent_address'),
            'district' => $request->input('district'),
            'province' => $request->input('province'),
            'current_address' => $request->input('current_address'),
            'current_province' => $request->input('current_province'),
            'guardian_name' => $request->input('guardian_name'),
            'guardian_id_no' => $request->input('guardian_id_no'),
            'guardian_contact_no' => $request->input('guardian_contact_no'),
            'guardian_occupation' => $request->input('guardian_occupation'),
        ]);
    
        // Optionally, you can return the created student as a response
        return response()->json($student, 201);
    }
}

