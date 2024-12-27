<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Program;
use App\Models\Province;
use App\Models\City;
use App\Models\District; 
use App\Models\Subdistrict;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class OnboardingController extends Controller
{
    // Step 1: Select Brand
    public function show(): View
    {
        $brands = Brand::all();
        return view('auth.onboarding.step1', compact('brands'));
    }

    public function store(Request $request)
    {
        $request->validate(['brand' => 'required|exists:brands,id']);
        $user = Auth::user();
        $user->update(['brand_id' => $request->input('brand')]);

        return redirect()->route('onboarding.program')->with('success', 'Step 1 completed. Proceed to Step 2.');
    }

    // Step 2: Select Program
    public function showProgram(): View
    {
        $programs = Program::all();
        return view('auth.onboarding.step2', compact('programs'));
    }

    public function storeProgram(Request $request)
    {
        $request->validate(['program' => 'required|exists:programs,id']);
        $user = Auth::user();
        $user->update(['program_id' => $request->input('program')]);

        return redirect()->route('onboarding.details')->with('success', 'Step 2 completed. Proceed to Step 3.');
    }

    // Step 3: Complete Profile
    public function showDetails(): View
    {
        $provinces = Province::all(); 
        $cities = [];
        $districts = [];
        $subdistricts = [];
        $user = Auth::user(); 
    
        if ($user->province) {
            $cities = City::where('id_prov', $user->province)->get();
    
            if ($user->city) {
                $districts = District::where('id_kab', $user->city)->get();
                dd($districts);
               
                if ($user->district) {
                    $subdistricts = Subdistrict::where('id_kec', $user->district)->get();
                }
            }
        }
    
        return view('auth.onboarding.step3', compact('provinces', 'cities', 'districts', 'subdistricts'));
    }

    public function storeDetails(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'birth_city' => 'nullable|string|max:255',
            'birth_date' => 'required|date',
            'religion' => 'nullable|string|max:50',
            'gender' => 'required|string|in:male,female',
            'address.province' => 'required|exists:provinces,id_prov',
            'address.city' => 'required|exists:cities,id_kab',
            'address.district' => 'required|exists:districts,id_kec',
            'address.subdistrict' => 'required|exists:subdistricts,id_kel',
            'address.postal_code' => 'required|string|max:10',
            'address.detail' => 'required|string|max:500',
        ]);

        $user = Auth::user();
        
        $user->update([
            'full_name' => $request->input('full_name'),
            'birth_city' => $request->input('birth_city'),
            'birth_date' => $request->input('birth_date'),
            'religion' => $request->input('religion'),
            'gender' => $request->input('gender'),
            'province' => $request->input('address.province'),
            'city' => $request->input('address.city'),
            'district' => $request->input('address.district'),
            'subdistrict' => $request->input('address.subdistrict'),
            'postal_code' => $request->input('address.postal_code'),
            'address' => [
                'detail' => $request->input('address.detail'),
            ],
        ]);

        return redirect()->route('onboarding.step4')->with('success', 'Step 3 completed. Proceed to Step 4.');
    } 

    // Step 4: Parent Information
    public function showParent(): View
    {
        return view('auth.onboarding.step4');
    }

    public function storeParent(Request $request)
    {
        $request->validate([
            'father_name' => 'required|string|max:255',
            'father_job' => 'required|string|max:255',
            'father_email' => 'nullable|email|max:255',
            'father_phone' => 'required|string|max:20',
            'mother_name' => 'required|string|max:255',
            'mother_job' => 'required|string|max:255',
            'mother_email' => 'nullable|email|max:255',
            'mother_phone' => 'required|string|max:20',
        ]);

        $user = Auth::user();
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

        return redirect()->route('onboarding.complete')->with('success', 'Step 4 completed. Proceed to final step.');
    }

    // Step 5: Final Step (Completion)
    public function showComplete(): View
    {
        return view('auth.onboarding.complete');
    }

    public function completeOnboarding()
    {
        $user = Auth::user();
    
        // Debugging logs
        \Log::info('Completing onboarding for user:', ['id' => $user->id]);
    
        $user->update(['onboarding_completed' => true]);
    
        \Log::info('Onboarding completed status:', ['onboarding_completed' => $user->onboarding_completed]);
    
        return redirect()->route('dashboard')->with('success', 'Onboarding completed. Welcome to the platform!');
    }
    
    
}
