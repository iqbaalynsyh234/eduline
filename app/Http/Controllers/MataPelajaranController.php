<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class MataPelajaranController extends Controller
{
    public function index()
    {
        $subjects = Subject::all();
        return view('admin.matapelajaran.index', compact('subjects'));
    }

    public function create()
    {
        return view('admin.subject.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:subjects',
            'type' => 'required|in:mandatory,optional',
        ]);
    
        Subject::create($request->all());

        return redirect()->route('admin.subject.index')->with('success', 'Subject created successfully.');
    }

    public function edit($slug)
    {
        $subject = Subject::where('slug', $slug)->firstOrFail();
        return view('admin.subject.edit', compact('subject'));
    }

    public function update(Request $request, Subject $subject)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:subjects,code,' . $subject->id,
            'type' => 'required|in:mandatory,optional',
        ]);

        $subject->update($request->all());
        return redirect()->route('admin.subject.index')->with('success', 'Subject updated successfully.');
    }

    public function destroy($slug)
    {
        $subject = Subject::where('slug', $slug)->firstOrFail();
        $subject->delete();
        return redirect()->route('admin.subject.index')->with('success', 'Subject deleted successfully.');
    }
}
