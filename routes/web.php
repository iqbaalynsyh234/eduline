<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\KBMController;
use App\Http\Controllers\OauthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MataPelajaranController;
use App\Http\Controllers\CoachingController;
use App\Http\Controllers\TargetController;
use App\Http\Controllers\EduCenterController;
use App\Http\Controllers\PrivateScheduleController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

// Google OAuth Routes
Route::get('oauth/google', [OauthController::class, 'redirectToProvider'])->name('oauth.google');
Route::get('oauth/google/callback', [OauthController::class, 'handleProviderCallback'])->name('oauth.google.callback');

// Routes that require user to be authenticated
Route::middleware(['auth', 'check.status'])->group(function () {

    Route::get('/get-cities/{province}', [LocationController::class, 'getCities']);
    Route::get('/get-districts/{city}', [LocationController::class, 'getDistricts']);
    Route::get('/get-subdistricts/{district}', [LocationController::class, 'getSubdistricts']);

    // Onboarding Routes
    Route::get('onboarding', [OnboardingController::class, 'show'])->name('onboarding.show');
    Route::post('onboarding', [OnboardingController::class, 'store'])->name('onboarding.store');
    Route::get('onboarding/program', [OnboardingController::class, 'showProgram'])->name('onboarding.program');
    Route::post('onboarding/program', [OnboardingController::class, 'storeProgram'])->name('onboarding.program.store');
    Route::get('onboarding/details', [OnboardingController::class, 'showDetails'])->name('onboarding.details');
    Route::post('onboarding/details', [OnboardingController::class, 'storeDetails'])->name('onboarding.details.store');
    Route::get('/onboarding/step4', [OnboardingController::class, 'showParent'])->name('onboarding.step4');
    Route::post('/onboarding/parent', [OnboardingController::class, 'storeParent'])->name('onboarding.parent.store');
    Route::get('onboarding/complete', [OnboardingController::class, 'showComplete'])->name('onboarding.complete');
    Route::post('/onboarding/complete', [OnboardingController::class, 'completeOnboarding'])->name('onboarding.complete');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Main Dashboard Route with Role-Based Redirection
    Route::get('/dashboard', function () {
        $user = auth()->user();

        if ($user->hasRole('owner')) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->hasRole('teacher')) {
            return view('dashboard');
        } elseif ($user->hasRole('student')) {
            return redirect()->route('student.dashboard');
        }

        return abort(403, 'Unauthorized action.');
    })->name('dashboard');

    // Admin Routes
    Route::prefix('admin')->name('admin.')->middleware('role:owner')->group(function () {

        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
        // Master Data Routes
        Route::prefix('master-data')->name('master-data.')->group(function () {

            // Brand Routes
            Route::get('brand', [AdminController::class, 'indexBrand'])->name('brand.index');
            Route::get('brand/create', [AdminController::class, 'createBrand'])->name('brand.create');
            Route::post('brand', [AdminController::class, 'storeBrand'])->name('brand.store');
            Route::get('brand/{brand}/edit', [AdminController::class, 'editBrand'])->name('brand.edit');
            Route::put('brand/{brand}', [AdminController::class, 'updateBrand'])->name('brand.update');
            Route::delete('brand/{brand}', [AdminController::class, 'destroyBrand'])->name('brand.destroy');

            // Program Routes
            Route::get('program', [AdminController::class, 'indexProgram'])->name('program.index');
            Route::post('program', [AdminController::class, 'storeProgram'])->name('program.store');
            Route::get('program/{program}/edit', [AdminController::class, 'editProgram'])->name('program.edit');
            Route::put('program/{program}', [AdminController::class, 'updateProgram'])->name('program.update');
            Route::delete('program/{program}', [AdminController::class, 'destroyProgram'])->name('program.destroy');

            // Sub Program Routes
            Route::get('sub-program', [AdminController::class, 'indexSubProgram'])->name('sub-program.index');
            Route::post('sub-program', [AdminController::class, 'storeSubProgram'])->name('sub-program.store');
            Route::put('sub-program/{subProgram}', [AdminController::class, 'updateSubProgram'])->name('sub-program.update');
            Route::delete('sub-program/{subProgram}', [AdminController::class, 'destroySubProgram'])->name('sub-program.destroy');

            // SLA Routes
            Route::get('sla', [AdminController::class, 'indexSLA'])->name('sla.index');
            Route::get('sla/create', [AdminController::class, 'createSLA'])->name('sla.create');
            Route::post('sla', [AdminController::class, 'storeSLA'])->name('sla.store');
            Route::get('sla/{sla}/edit', [AdminController::class, 'editSLA'])->name('sla.edit');
            Route::put('sla/{sla}', [AdminController::class, 'updateSLA'])->name('sla.update');
            Route::delete('sla/{sla}', [AdminController::class, 'destroySLA'])->name('sla.destroy');

            // Target Management Routes
            Route::get('target', [TargetController::class, 'indexTarget'])->name('target.index');
            Route::get('target/create', [TargetController::class, 'createTarget'])->name('target.create');
            Route::post('target', [TargetController::class, 'storeTarget'])->name('target.store');
            Route::get('target/{target}/edit', [TargetController::class, 'editTarget'])->name('target.edit');
            Route::put('target/{target}', [TargetController::class, 'updateTarget'])->name('target.update');
            Route::delete('target/{target}', [TargetController::class, 'destroyTarget'])->name('target.destroy');


            // User Management Routes
            Route::get('user', [UserController::class, 'index'])->name('user.index');
            Route::post('user', [UserController::class, 'store'])->name('user.store');
            Route::put('user/{user}', [UserController::class, 'update'])->name('user.update'); 
            Route::delete('user/{user}', [UserController::class, 'destroy'])->name('user.destroy');
            Route::put('user/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('user.toggleStatus'); 

            Route::get('teacher', [AdminController::class, 'indexTeacher'])->name('teacher.index');
            Route::get('student', [AdminController::class, 'indexStudent'])->name('student.index');
            Route::get('class', [AdminController::class, 'indexClass'])->name('class.index');
            Route::get('material', [AdminController::class, 'indexMaterial'])->name('material.index');
            Route::get('academic-year', [AdminController::class, 'indexAcademicYear'])->name('academic-year.index');
            Route::get('student-program', [AdminController::class, 'indexStudentProgram'])->name('student-program.index');
        });

        // mata pelajaran routes
        Route::prefix('matapelajaran')->name('subject.')->group(function () {
            Route::get('/', [MataPelajaranController::class, 'index'])->name('index'); 
            Route::get('/create', [MataPelajaranController::class, 'create'])->name('create'); 
            Route::post('/', [MataPelajaranController::class, 'store'])->name('store'); 
            Route::get('/{subject}/edit', [MataPelajaranController::class, 'edit'])->name('edit'); 
            Route::put('/{subject}', [MataPelajaranController::class, 'update'])->name('update'); 
            Route::delete('/{subject}', [MataPelajaranController::class, 'destroy'])->name('destroy'); 
        });

        // educenter module 
        Route::prefix('educenter')->name('educenter.')->group(function () {
            Route::get('/select-brand', [EduCenterController::class, 'selectBrand'])->name('select_brand');
            Route::get('/select-subprogram/{eModuleId}', [EduCenterController::class, 'selectSubprogram'])->name('educenter.select_subprogram');
            Route::post('/save-selected-brand', [EduCenterController::class, 'saveSelectedBrand'])->name('save_selected_brand');
            Route::get('/', [EduCenterController::class, 'index'])->name('index');
            Route::post('/save-selected-subprogram', [EduCenterController::class, 'saveSelectedSubprogram'])
            ->name('educenter.save_selected_program');
            Route::get('/select-program', [EduCenterController::class, 'selectProgram'])->name('select_program');
            Route::get('/e-module', [EduCenterController::class, 'eModule'])->name('e_module');
            Route::get('/paket-soal', [EduCenterController::class, 'paketSoal'])->name('paket_soal');
            Route::get('/assign-paket-soal', [EduCenterController::class, 'assignPaketSoal'])->name('assign_paket_soal'); 
        });

        // Coaching Schedule Routes
        Route::post('/coaching/store', [CoachingController::class, 'store'])->name('coaching.store');
        Route::put('/coaching/update/{id}', [CoachingController::class, 'update'])->name('coaching.update');
        Route::delete('/coaching/delete/{id}', [CoachingController::class, 'destroy'])->name('coaching.delete');

        // My Schedule Routes
        Route::get('/schedule', [AdminController::class, 'indexSchedule'])->name('schedule.index');
        Route::post('/schedule', [AdminController::class, 'storeSchedule'])->name('schedule.store');
        Route::put('/assessment/{assessment}', [AdminController::class, 'updateSchedule'])->name('admin.schedule.update');
        Route::delete('/schedule/{schedule}', [AdminController::class, 'destroy'])->name('schedule.destroy');
        
        // route KBM 
        Route::prefix('kbm')->name('kbm.')->group(function () {
            Route::get('schedule/{studentId}/data', [KBMController::class, 'getStudentSchedule'])->name('schedule.data');
            Route::get('schedule/{id}/edit', [KBMController::class, 'editSchedule'])->name('schedule.edit'); 
            Route::post('schedule', [KBMController::class, 'storeScheduleKbm'])->name('schedule.store');
            Route::put('schedule/{id}', [KBMController::class, 'updateSchedule'])->name('schedule.update');
            Route::delete('schedule/{id}', [KBMController::class, 'destroySchedule'])->name('schedule.destroy');
        });
        
        // route kbm private 
        Route::prefix('kbm-private')->name('admin.kbm.private.')->group(function () {
            Route::get('schedule/{studentId}', [PrivateScheduleController::class, 'getStudentSchedules'])->name('schedule');
            Route::post('schedule', [PrivateScheduleController::class, 'store'])->name('schedule.store');
            Route::put('schedule/{id}', [PrivateScheduleController::class, 'update'])->name('schedule.update'); 
            Route::delete('schedule/{id}', [PrivateScheduleController::class, 'destroy'])->name('schedule.destroy'); 
        });           

    });

    // Student Routes
    Route::middleware(['role:student'])->prefix('student')->name('student.')->group(function () {

        // Dashboard student 
        Route::get('/dashboard', [DashboardController::class, 'studentDashboard'])->name('dashboard');
        Route::post('/student/profile', [DashboardController::class, 'updateStudent'])->name('student.profile.update');
        Route::get('/student/profile', [DashboardController::class, 'editStudent'])->name('profile'); 
        Route::get('/parent-profile', [ProfileController::class, 'parentProfile'])->name('parent.profile');
        Route::post('/student/parent/profile', [DashboardController::class, 'updateParentProfile'])
        ->name('student.parent.profile.update');

        // My Targets
        Route::prefix('targets')->name('targets.')->group(function () {
            Route::get('/my-targets', [DashboardController::class, 'myTargets'])->name('my_targets');
            Route::get('/{slug}', [DashboardController::class, 'targetDetails'])->name('details');
        });

        // Edu Center
        Route::get('/edu-center', [DashboardController::class, 'eduCenterOverview'])->name('edu_center.overview');
        Route::get('/edu-center/module/{slug}', [DashboardController::class, 'moduleDetails'])->name('edu_center.module');
    
        // My Schedule
        Route::get('/schedule', [DashboardController::class, 'schedule'])->name('schedule');
    
        // Teacher Profile
        Route::get('/teacher-profile', [DashboardController::class, 'teacherProfile'])->name('teacher.profile');
    
        // Learning Report
        Route::prefix('learning-report')->name('learning_report.')->group(function () {
            Route::get('/my-score/assessment', [DashboardController::class, 'myScoreAssessment'])->name('my_score.assessment');
            Route::get('/my-score/kbm', [DashboardController::class, 'myScoreKBM'])->name('my_score.kbm');
            Route::get('/my-score/drilling', [DashboardController::class, 'myScoreDrilling'])->name('my_score.drilling');
            Route::get('/my-score/try-out', [DashboardController::class, 'myScoreTryOut'])->name('my_score.try_out');
            Route::get('/my-report', [DashboardController::class, 'myReport'])->name('my_report');
        });
    });
});

require __DIR__.'/auth.php';
