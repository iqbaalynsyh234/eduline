<?php

namespace App\Http\Controllers;

use App\Models\Target;
use App\Models\User;
use Illuminate\Http\Request;

class TargetController extends Controller
{
    function indexTarget()
    {
        $targets = Target::with('user')->get();
        $students = User::role('student')->get();

        return view('admin.master.target.index', compact('targets', 'students'));
    }
    function storeTarget(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:targets,slug',
            'description' => 'nullable|string',
            'icon' => 'nullable|file|mimes:jpg,png,jpeg|max:2048',
            'schedule' => 'nullable|date',
            'time' => 'nullable|date_format:H:i',
        ]);
    
        if ($request->hasFile('icon')) {
            $iconPath = $request->file('icon')->store('icons', 'public');
            $validated['icon'] = $iconPath;
        }
    
        Target::create($validated);
    
        return redirect()->route('admin.master-data.target.index')->with('success', 'Target created successfully!');
    }    
    function updateTarget(Request $request, Target $target)
    {
        // dd($request->all());

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:targets,slug,' . $target->id,
            'description' => 'nullable|string',
            'icon' => 'nullable|file|mimes:jpg,png,jpeg,svg|max:2048',
            'schedule' => 'nullable|date',
            'time' => 'nullable|date_format:H:i',
        ]);

        if ($request->hasFile('icon')) {
            try {
                $iconPath = $request->file('icon')->store('icons', 'public');
                $validated['icon'] = $iconPath;
            } catch (\Exception $e) {
                return back()->withErrors(['icon' => 'File upload failed: ' . $e->getMessage()]);
            }
        }
        

        $target->update($validated);

        return redirect()->route('admin.master-data.target.index')->with('success', 'Target updated successfully!');
    }
    function destroyTarget(Target $target)
    {
        $target->delete();

        return response()->json(['success' => 'Target deleted successfully!']);
    }
}
