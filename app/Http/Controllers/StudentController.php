<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::all();
        return view('students.index', compact('students')); 
    }

    public function create()
    {
        return view('students.create'); 
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'class' => 'required',
        ]);

        Student::create($request->all()); 
        return redirect()->route('students.index')->with('success', 'Student created successfully');
    }

    public function show(Student $student)
    {
        return view('students.show', compact('student')); // Detail siswa
    }

    public function edit(Student $student)
    {
        return view('students.edit', compact('student')); // Form edit siswa
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'name' => 'required',
            'class' => 'required',
        ]);

        $student->update($request->all()); // Update data siswa
        return redirect()->route('students.index')->with('success', 'Student updated successfully');
    }

    public function destroy(Student $student)
    {
        $student->delete(); // Hapus data siswa
        return redirect()->route('students.index')->with('success', 'Student deleted successfully');
    }
}
