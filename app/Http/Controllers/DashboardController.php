<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Target;
use App\Models\StudentModule;
class DashboardController extends Controller
{
    function studentDashboard()
    {
        $student = auth()->user();
        $brands = Brand::all();
        
        $studentBrandName = $student->brand_id ? Brand::find($student->brand_id)?->name : null;

        return view('student.dashboard', compact('student', 'brands', 'studentBrandName'));
    }
    function editStudent()
    {
        $student = auth()->user();
        $brands = Brand::all();
        $studentBrandName = $student->brand_id ? Brand::find($student->brand_id)?->name : null;
        $studentAddress = $student->address;

        return view('student.profile', compact('student', 'brands', 'studentBrandName', 'studentAddress'));
    }
    function updateStudent(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'religion' => 'nullable|string|max:255',
            'gender' => 'required|in:male,female',
            'phone_number' => 'nullable|string|max:15',
            'birth_city' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date',
            'school_origin' => 'nullable|string|max:255',
            'class' => 'nullable|string|max:10',
            'instagram' => 'nullable|string|max:255',
            'subject' => 'nullable|string|max:255',
            'brand' => 'nullable|string|max:255',
            'hobby' => 'nullable|string|max:255',
            'address.detail' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only([
            'full_name', 'email', 'religion', 'gender', 'phone_number',
            'birth_city', 'birth_date', 'school_origin', 'class', 'instagram',
            'subject', 'brand', 'hobby'
        ]);

        if ($request->has('address.detail')) {
            $data['address'] = json_encode(['detail' => $request->input('address.detail')]);
        }

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
            $data['photo'] = $photoPath;
        }

        auth()->user()->update($data);

        return redirect()->route('student.profile')->with('success', 'Profile updated successfully.');
    }
    
    function updateParentProfile(Request $request)
    {
        $request->validate([
            'father_name' => 'required|string|max:255',
            'father_job' => 'required|string|max:255',
            'father_email' => 'nullable|email|max:255',
            'father_phone' => 'required|string|max:15',
            'mother_name' => 'required|string|max:255',
            'mother_job' => 'required|string|max:255',
            'mother_email' => 'nullable|email|max:255',
            'mother_phone' => 'required|string|max:15',
        ]);

        $user = auth()->user();

        $user->update([
            'father_name' => $request->input('father_name'),
            'father_job' => $request->input('father_job'),
            'father_email' => $request->input('father_email'),
            'father_phone' => $request->input('father_phone'),
            'mother_name' => $request->input('mother_name'),
            'mother_job' => $request->input('mother_job'),
            'mother_email' => $request->input('mother_email'),
            'mother_phone' => $request->input('mother_phone'),
        ]);

        return redirect()->route('student.profile')->with('success', 'Parent profile updated successfully.');
    }
    function parentProfile()
    {
        return view('student.parent_profile');
    }
    public function myTargets()
    {
        $student = auth()->user();

        $targets = $student->targets;

        return view('student.targets.my_targets', compact('targets', 'student'));
    }

    function targetDetails($slug)
    {
        $target = Target::with(['kkmDetails'])->where('slug', $slug)->firstOrFail();
    
        if ($target->title === 'Jasmani') {
            $target->kkmDetails = $target->kkmDetails->map(function ($kkm) {

                $kkmData = json_decode($kkm->kkm, true);
                // dd($kkmData);
                return [
                    'jumlah' => $kkmData['jumlah'] ?? 0,
                    'nilai' => $kkmData['nilai'] ?? 0,
                    'subject' => $kkm->subject,
                ];
            });
        }
    
        return view('student.targets.details', compact('target'));
    }

    function eduCenterOverview()
    {
        $modules = StudentModule::where('user_id', auth()->id())->get();
    
        return view('student.edu_center.index', compact('modules'));
    }

    function moduleDetails($slug)
    {
        $module = StudentModule::where('slug', $slug)->with('subModules')->firstOrFail();

        return view('student.edu_center.module_details', compact('module'));
    }

    // Edu Center
    function assessment()
    {
        return view('student.edu_center.assessment');
    }

    function drilling()
    {
        return view('student.edu_center.drilling');
    }

    function eModule()
    {
        return view('student.edu_center.e_module');
    }

    function tryOut()
    {
        return view('student.edu_center.try_out');
    }

    // My Schedule
    function schedule()
    {
        return view('student.schedule');
    }

    // Teacher Profile
    function teacherProfile()
    {
        return view('student.teacher_profile');
    }

    // Learning Report: My Score
    function myScoreAssessment()
    {
        return view('student.learning_report.my_score_assessment');
    }

    function myScoreKBM()
    {
        return view('student.learning_report.my_score_kbm');
    }

    function myScoreDrilling()
    {
        return view('student.learning_report.my_score_drilling');
    }

    function myScoreTryOut()
    {
        return view('student.learning_report.my_score_try_out');
    }
    function myReport()
    {
        return view('student.learning_report.my_report');
    }
}
