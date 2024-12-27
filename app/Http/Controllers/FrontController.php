<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function myProfile()
    {
        return view('student.profile');
    }

    public function parentProfile()
    {
        return view('student.parent_profile');
    }

    public function targetAcademic()
    {
        return view('student.targets.academic');
    }

    public function targetPsychology()
    {
        return view('student.targets.psychology');
    }

    public function targetPhysical()
    {
        return view('student.targets.physical');
    }

    public function targetHealth()
    {
        return view('student.targets.health');
    }

    public function eduAssessment()
    {
        return view('student.edu_center.assessment');
    }

    public function eduDrilling()
    {
        return view('student.edu_center.drilling');
    }

    public function eduEmodule()
    {
        return view('student.edu_center.e_module');
    }

    public function eduTryOut()
    {
        return view('student.edu_center.try_out');
    }

    public function mySchedule()
    {
        return view('student.schedule');
    }

    public function teacherProfile()
    {
        return view('student.teacher_profile');
    }

    public function learningScoreAssessment()
    {
        return view('student.learning_report.score.assessment');
    }

    public function learningScoreKbm()
    {
        return view('student.learning_report.score.kbm');
    }

    public function learningScoreDrilling()
    {
        return view('student.learning_report.score.drilling');
    }

    public function learningScoreTryOut()
    {
        return view('student.learning_report.score.try_out');
    }

    public function learningReport()
    {
        return view('student.learning_report.report');
    }
}
