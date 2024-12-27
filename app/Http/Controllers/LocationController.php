<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\District;
use App\Models\Subdistrict;

class LocationController extends Controller
{
    public function getCities($provinceId)
    {
        $cities = City::where('id_prov', $provinceId)->get();
        // dd($cities);
        return response()->json($cities);
    }

    public function getDistricts($cityId)
    {
        $districts = District::where('id_kab', $cityId)->get();
        return response()->json($districts);
    }

    public function getSubdistricts($districtId)
    {
        $subdistricts = Subdistrict::where('id_kec', $districtId)->get();
        return response()->json($subdistricts);
    }
}
