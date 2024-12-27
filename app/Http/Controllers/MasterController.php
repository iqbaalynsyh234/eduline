<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MasterController extends Controller
{
    public function students()
    {
        return view('admin.master.students');
    }

    public function teachers()
    {
        return view('admin.master.teachers');
    }

    public function subjects()
    {
        return view('admin.master.subjects');
    }
}
