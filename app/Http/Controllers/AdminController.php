<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Program;
use App\Models\SubProgram;
use App\Models\Schedule;
use App\Models\Kbm;
use App\Models\CoachingSchedule;
use App\Models\Assessment;
use App\Models\Coaching;
use App\Models\User;
use App\Models\PrivateSchedule;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    function dashboard()
    {
        return view('admin.dashboard');
    }
    function coachDashboard()
    {
        return view('admin.coach_dashboard');
    }

    function indexBrand()
    {
        $brands = Brand::orderBy('created_at', 'desc')->get();

        return view('admin.master.brand.index', compact('brands'));
    }
    function storeBrand(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['name', 'description']);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        Brand::create($data);

        // dd($data);

        return redirect()->route('admin.master-data.brand.index')->with('success', 'Brand created successfully.');
    }
    function updateBrand(Request $request, Brand $brand)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['name', 'description']);

        if ($request->hasFile('logo')) {
            if ($brand->logo && Storage::disk('public')->exists($brand->logo)) {
                Storage::disk('public')->delete($brand->logo);
            }
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $brand->update($data);

        return redirect()->route('admin.master-data.brand.index')->with('success', 'Brand updated successfully.');
    }
    function destroyBrand(Brand $brand)
    {
        $brand->delete();

        return redirect()->route('admin.master-data.brand.index')->with('success', 'Brand deleted successfully.');
    }

    // function programs 
    function indexProgram()
    {
        $programs = Program::with('brand')->orderBy('created_at', 'desc')->get();
        $brands = Brand::orderBy('name', 'desc')->get();

        return view('admin.master.program.index', compact('programs', 'brands'));
    }
    function storeProgram(Request $request)
    {
        $request->validate([
            'brand_id' => 'required|exists:brands,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Program::create([
            'brand_id' => $request->brand_id,
            'name' => $request->name,
            'description' => $request->description,
        ]);

        // dd($request->all());

        return redirect()->route('admin.master-data.program.index')->with('success', 'Program created successfully.');
    }

    function updateProgram(Request $request, Program $program)
    {
        $request->validate([
            'brand_id' => 'required|exists:brands,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
    
        $program->update([
            'brand_id' => $request->brand_id,
            'name' => $request->name,
            'description' => $request->description,
        ]);

        // dd($request->all());
    
        return redirect()->route('admin.master-data.program.index')->with('success', 'Program updated successfully.');
    }

    function destroyProgram(Program $program)
    {
        $program->delete();

        return response()->json(['success' => 'Program deleted succesfully.']);
    }
    
    // Sub Program function
    function indexSubProgram()
    {
        $subPrograms = SubProgram::with(['program', 'brand'])->orderBy('created_at', 'desc')->get();
        $programs = Program::orderBy('name', 'asc')->get();
        $brands = Brand::orderBy('name', 'asc')->get();

        return view('admin.master.sub_program.index', compact('subPrograms', 'programs', 'brands'));
    }

    function storeSubProgram(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'program_id' => 'required|exists:programs,id',
            'brand_id' => 'required|exists:brands,id',
        ]);

        SubProgram::create($request->all());

        return redirect()->route('admin.master-data.sub-program.index')->with('success', 'Sub Program created successfully.');
    }

    function updateSubProgram(Request $request, SubProgram $subProgram)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'program_id' => 'required|exists:programs,id',
            'brand_id' => 'required|exists:brands,id',
        ]);

        $subProgram->update($request->all());

        return redirect()->route('admin.master-data.sub-program.index')->with('success', 'Sub Program updated successfully.');
    }

    function destroySubProgram(SubProgram $subProgram)
    {
        $subProgram->delete();

        return response()->json(['success' => 'Sub Program deleted successfully.']);
    }
    
    public function indexSchedule(Request $request)
    {
        $assessments = Assessment::with('student')->get();
        $kbms = Kbm::with(['student', 'teacher'])->get();
        $coachings = Coaching::with('student')->get();
        $coachings = Coaching::with(['student', 'teacher'])->get();
        $students = User::role('student')->paginate(3);
        $teachers = User::role('teacher')->get();
        $programs = Program::all();
        $coachings = CoachingSchedule::with(['student', 'teacher'])->get();
        $studentId = $request->get('student_id'); 
        $kbmPrivateSchedules = PrivateSchedule::with('student', 'teacher')
            ->when($studentId, function ($query) use ($studentId) {
                return $query->where('student_id', $studentId);
            })
        ->get();
    
        return view('admin.schedule.index', compact('assessments', 'kbms', 'coachings', 'students', 'teachers', 'programs', 'kbmPrivateSchedules'));
    }
    
    function storeSchedule(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'datetime' => 'required|date_format:Y-m-d\TH:i', 
            'location' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'material' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        try {
            $datetime = Carbon::parse($request->input('datetime'));
            $date = $datetime->toDateString();
            $time = $datetime->toTimeString();

            Assessment::create([
                'student_id' => $request->student_id,
                'date' => $date,
                'time' => $time,
                'location' => $request->location,
                'subject' => $request->subject,
                'material' => $request->material,
                'notes' => $request->notes,
            ]);

            return redirect()->route('admin.schedule.index')->with('success', 'Schedule added successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.schedule.index')->with('error', 'Failed to add schedule. Please try again.');
        }
    }
    function updateSchedule(Request $request, Assessment $assessment)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'datetime' => 'required|date_format:Y-m-d\TH:i',
            'location' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'material' => 'required|string|max:255',
            'notes' => 'nullable|string|max:500',
        ]);

        try {
            $datetime = Carbon::parse($request->input('datetime'));
            $date = $datetime->toDateString();
            $time = $datetime->toTimeString();

            $assessment->update([
                'student_id' => $request->student_id,
                'date' => $date,
                'time' => $time,
                'location' => $request->location,
                'subject' => $request->subject,
                'material' => $request->material,
                'notes' => $request->notes,
            ]);

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Assessment schedule updated successfully.',
                ]);
            }

            return redirect()->route('admin.schedule.index')
                ->with('success', 'Assessment schedule updated successfully.');
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update schedule: ' . $e->getMessage(),
                ], 500);
            }

            return redirect()->route('admin.schedule.index')
                ->with('error', 'Failed to update schedule: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $schedule = Assessment::findOrFail($id);
            $schedule->delete();

            return response()->json([
                'success' => true,
                'message' => 'Schedule deleted successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete the schedule: ' . $e->getMessage(),
            ], 500);
        }
    }


}
