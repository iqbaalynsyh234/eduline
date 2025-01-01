<?php

namespace App\Http\Controllers;

use App\Models\PrivateSchedule;
use App\Models\User;
use Illuminate\Http\Request;

class PrivateScheduleController extends Controller
{

    function getStudentSchedules($studentId)
    {
        $student = User::findOrFail($studentId);
        $kbmPrivateSchedules = PrivateSchedule::with(['student', 'teacher'])
        ->where('student_id', $studentId)
        ->get();
    
        $teachers = User::role('teacher')->get(); 
    
        return view('admin.schedule.private', compact('student', 'kbmPrivateSchedules', 'teachers'));
    }
    function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'subject' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'teacher_id' => 'nullable|exists:users,id',
            'fee' => 'nullable|numeric|min:0',
        ]);
    
        PrivateSchedule::create($validated);
    
        return redirect()
            ->route('admin.admin.kbm.private.schedule', $validated['student_id'])
            ->with('success', 'Jadwal KBM Private berhasil ditambahkan!');
    }
    
    public function update(Request $request, $id)
    {
        // dd($request->all());

        $validated = $request->validate([
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'subject' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'teacher_id' => 'nullable|exists:users,id',
            'fee' => 'required|numeric|min:0',
        ]);

        $schedule = PrivateSchedule::findOrFail($id); 

        $schedule->update($validated); 

        return redirect()
        ->route('admin.kbm.private.schedule', $schedule->student_id)
        ->with('success', 'Jadwal KBM Private berhasil diperbarui!');
    }
    
    function destroy($id)
    {
        $schedule = PrivateSchedule::findOrFail($id);
        $schedule->delete();
        return response()->json(['message' => 'Schedule deleted successfully!']);
    }
}
