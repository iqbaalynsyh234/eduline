<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CoachingSchedule;

class CoachingController extends Controller
{
    function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'teacher_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'method' => 'required|string|in:home_visit,office_visit,online_zoom,phone_call',
        ]);

        $student = User::find($request->student_id);
        $teacher = User::find($request->teacher_id);

        if (!$student->hasRole('student')) {
            return response()->json(['error' => 'The selected student_id does not have the "student" role.'], 422);
        }

        if (!$teacher->hasRole('teacher')) {
            return response()->json(['error' => 'The selected teacher_id does not have the "teacher" role.'], 422);
        }

        CoachingSchedule::create([
            'student_id' => $request->student_id,
            'teacher_id' => $request->teacher_id,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'method' => $request->method,
        ]);

        return response()->json(['message' => 'Coaching schedule added successfully.'], 201);
    }
    function update(Request $request, $id)
    {
        $schedule = CoachingSchedule::findOrFail($id);

        $request->validate([
            'student_id' => 'required|exists:users,id',
            'teacher_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'method' => 'required|string|in:home_visit,office_visit,online_zoom,phone_call',
        ]);

        $schedule->update([
            'student_id' => $request->student_id,
            'teacher_id' => $request->teacher_id,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'method' => $request->method,
        ]);

        return response()->json(['message' => 'Coaching schedule updated successfully.']);
    }

    function destroy($id)
    {
        $schedule = CoachingSchedule::findOrFail($id);
        $schedule->delete();

        return response()->json(['message' => 'Coaching schedule deleted successfully.']);
    }
}
