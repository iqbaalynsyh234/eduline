<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Subject;
use App\Models\SubProgram;
use App\Models\EModule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class EduCenterController extends Controller
{
    function index()
    {
        return view('admin.educenter.index'); 
    }
    
    function eModuleBySlug($slug)
    {
        $subjects = Subject::with('modules')->get();
    
        // dd($subjects);
    
        $title = 'E - Module';
        return view('student.edu_center.module_details', compact('subjects', 'title'));
    }
    function eModuleStudent ($slug){

        $subject = Subject::where('slug', $slug)->with('modules')->firstOrFail();

        return view('student.edu_center.module_details', compact('subject'));
    }

    public function saveSelectedBrand(Request $request)
    {
        $request->validate([
            'brand_id' => 'required|exists:brands,id',
        ]);

        $eModule = EModule::create([
            'brand_id' => $request->brand_id,
        ]);

        return redirect()->route('admin.educenter.educenter.select_subprogram', ['eModuleId' => $eModule->id, 'brand_id' => $request->brand_id])
        ->with('success', 'Brand selected successfully!');    
    }

    public function eModule()
    {
        $brands = Brand::all();

        return view('admin.educenter.e_module', compact('brands'));
    }

    public function selectSubprogram($eModuleId)
    {
        $subprograms = SubProgram::all(); 
        return view('admin.educenter.select_subprogram', compact('subprograms', 'eModuleId'));
    }

    public function paketSoal(Request $request,$id = null)
    {
        $subprogram_id = $request["data"];

        $subjects = Subject::paginate(10);
        return view('admin.educenter.paket_module.index', compact('subjects','id'));
    }
    public function saveSelectedSubprogram(Request $request)
    {
        // dd($request->all());
        // $data = $request->subprogram_id;
        // $eModuleId = $request->subprogram_id;
        $request->validate([
            'subprogram_id' => 'required|exists:sub_programs,id',
        ]);

        $eModule = EModule::find($request->eModuleId);
        if (!$eModule) {
            return redirect()->route('admin.educenter.e_module')->with('error', 'eModule not found!');
        }

        $eModule->update([
            'subprogram_id' => $request->subprogram_id,
        ]);

        return redirect()->route('admin.educenter.paket_module',['eModuleId' => $request->eModuleId])->with('success', 'Subprogram selected successfully!');
    }

    public function uploadPdf(Request $request, $id)
    {
       
        $validator = Validator::make($request->all(), [
            'pdf' => 'required|mimes:pdf|max:4048', 
            'title' => 'required|string|max:255',  
        ]);

        if ($validator->fails()) {
            return redirect()->back()
            ->withErrors($validator)
            ->withInput();
        }

        $pdfPath = $request->file('pdf')->store('uploads/pdfs', 'public');

        $eModule = EModule::find($request->edu_id);

        if (!$eModule) {
            return redirect()->back()->withErrors(['error' => 'EModule entry not found for the given Subject and Subprogram.']);
        }

        $eModule->update([
            'subject_id' => $id,      
            'pdf_path' => $pdfPath,   
            'title' => $request->title, 
        ]);

        return back()->with('success', 'PDF and title updated successfully in EModule.');
    }

    public function uploadVideo(Request $request, $id)
    {
        $request->validate([
            'youtube_url' => 'required|url',
        ]);
    
        parse_str(parse_url($request->youtube_url, PHP_URL_QUERY), $queryParams);
        $videoId = $queryParams['v'] ?? null;
    
        if (!$videoId) {
            return redirect()->back()->withErrors(['error' => 'Invalid YouTube URL provided.']);
        }
    
        $eModule = EModule::find($request->edu_id);
    
        if (!$eModule) {
            return redirect()->back()->withErrors(['error' => 'EModule entry not found for the given Subject and Subprogram.']);
        }
    
        $eModule->update([
            'subject_id' => $id,
            'youtube_link' => $videoId,
        ]);
    
        return back()->with('success', 'YouTube video link updated successfully in EModule.');
    }    


}
