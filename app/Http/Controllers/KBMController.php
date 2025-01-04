<?php

namespace App\Http\Controllers;

use App\Models\Kbm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class KBMController extends Controller
{
    public function getStudentSchedule($studentId)
    {
        $schedules = Kbm::with(['teacher', 'student'])
        ->where('student_id', $studentId)
        ->get();
        // dd($schedules);

        return response()->json($schedules->map(function ($schedule) {
            return [
                'id' => $schedule->id,
                // kalo mau object student
                // 'student' => $schedule->student ?? 'N/A',
                // kalo cuma mau ambil nama doang
                'student' => $schedule->student->full_name ?? 'N/A',
                'date' => $schedule->date,
                'start_time' => $schedule->start_time,
                'end_time' => $schedule->end_time,
                'subject' => $schedule->subject,
                'location' => $schedule->location,
                'teacher' => $schedule->teacher->full_name ?? 'N/A',
                'fee' => $schedule->fee,
            ];
        }));
    }
    function storeScheduleKbm(Request $request)
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

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $startTime = Carbon::createFromFormat('H:i', $request->start_time);
        $endTime = Carbon::createFromFormat('H:i', $request->end_time);

        if ($endTime->lessThanOrEqualTo($startTime)) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => [
                    'end_time' => ['End time must be greater than start time.']
                ],
            ], 422);
        }

        try {
            $schedule = Kbm::create($request->all());

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
    public function editSchedule($id)
    {
        $schedule = Kbm::findOrFail($id);
        return response()->json($schedule);
    }

    function updateSchedule(Request $request, $id)
    {
        $rules = [
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'subject' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'teacher_id' => 'required|exists:users,id',
            'fee' => 'nullable|numeric|min:0',
        ];
    
        $validator = Validator::make($request->all(), $rules);
    
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $validator->errors(),
            ], 422);
        }
    
        $schedule = Kbm::findOrFail($id);
    
        try {
            $schedule->update($request->all());
    
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
