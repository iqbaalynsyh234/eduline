<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\SubProgram;
use App\Models\EModule;
use Illuminate\Http\Request;

class EduCenterController extends Controller
{
    function index()
    {
        return view('admin.educenter.index'); 
    }

    public function saveSelectedBrand(Request $request)
    {
        $request->validate([
            'brand_id' => 'required|exists:brands,id',
        ]);

        $eModule = EModule::create([
            'brand_id' => $request->brand_id,
        ]);

        return redirect()->route('admin.educenter.educenter.select_subprogram', ['eModuleId' => $eModule->id])
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

    function paketSoal(){
        return view('admin.educenter.paket_soal.index');
    }

    public function saveSelectedSubprogram(Request $request)
    {
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

        return redirect()->route('admin.educenter.paket_soal')->with('success', 'Subprogram selected successfully!');
    }

}
