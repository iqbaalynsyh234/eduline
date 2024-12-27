<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function addSchedule()
    {
        return view('admin.schedule.add_schedule');
    }

    public function assessment()
    {
        return view('admin.schedule.assessment');
    }

    public function kbm()
    {
        return view('admin.schedule.kbm');
    }

    public function coaching()
    {
        return view('admin.schedule.coaching');
    }
}
