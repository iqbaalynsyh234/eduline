<?php

namespace App\Http\Controllers;

use App\Models\Kbm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class KBMController extends Controller
{
    function getStudentSchedule($studentId)
    {
        $schedules = Kbm::where('student_id', $studentId)
            ->with(['student', 'teacher'])
            ->get();
    
        return response()->json($schedules);
    }

    public function storeScheduleKbm(Request $request)
    {
        $rules = [
            'student_id' => 'required|exists:users,id',
            'program_id' => 'required|exists:programs,id',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'subject' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'teacher_id' => 'required|exists:users,id',
            'fee' => 'required|numeric|min:0',
        ];

        $messages = [
            'student_id.required' => 'Student ID is required.',
            'student_id.exists' => 'The selected student does not exist.',
            'program_id.required' => 'Program ID is required.',
            'program_id.exists' => 'The selected program does not exist.',
            'date.required' => 'Date is required.',
            'date.date' => 'Invalid date format.',
            'start_time.required' => 'Start time is required.',
            'start_time.date_format' => 'Start time must be in HH:mm format.',
            'end_time.required' => 'End time is required.',
            'end_time.date_format' => 'End time must be in HH:mm format.',
            'subject.required' => 'Subject is required.',
            'subject.max' => 'Subject must not exceed 255 characters.',
            'location.required' => 'Location is required.',
            'location.max' => 'Location must not exceed 255 characters.',
            'teacher_id.required' => 'Teacher ID is required.',
            'teacher_id.exists' => 'The selected teacher does not exist.',
            'fee.required' => 'Fee is required.',
            'fee.numeric' => 'Fee must be a numeric value.',
            'fee.min' => 'Fee must be at least 0.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $schedule = Kbm::create([
                'student_id' => $request->student_id,
                'program_id' => $request->program_id,
                'date' => $request->date,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'time' => $request->start_time, 
                'subject' => $request->subject,
                'location' => $request->location,
                'teacher_id' => $request->teacher_id,
                'fee' => $request->fee,
            ]);

            return response()->json([
                'message' => 'KBM schedule added successfully.',
                'schedule' => $schedule,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to add KBM schedule.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    function updateSchedule(Request $request, $id)
    {
        $schedule = Kbm::findOrFail($id);

        $validated = $request->validate([
            'student_id' => 'required|exists:users,id',
            'teacher_id' => 'nullable|exists:users,id',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'location' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'fee' => 'nullable|numeric',
            'notes' => 'nullable|string|max:500',
        ]);

        try {
            $schedule->update($validated);

            return response()->json([
                'message' => 'Schedule updated successfully.',
                'schedule' => $schedule,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update schedule.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    function destroySchedule($id)
    {
        $schedule = Kbm::findOrFail($id);

        try {
            $schedule->delete();

            return response()->json([
                'message' => 'Schedule deleted successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to delete schedule.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
