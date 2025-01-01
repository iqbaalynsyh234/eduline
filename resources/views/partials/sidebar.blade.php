<div class="dlabnav">
    <div class="dlabnav-scroll">
        <ul class="metismenu" id="menu">
            @role('student')
            <li class="{{ Request::routeIs('student.profile') ? 'active' : '' }}">
                <a href="{{ route('student.profile') }}">
                    <i class="material-symbols-outlined">person</i>
                    <span class="nav-text">My Profile</span>
                </a>
            </li>
            <li class="{{ Request::routeIs('student.targets.my_targets') ? 'active' : '' }}">
                <a href="{{ route('student.targets.my_targets') }}">
                    <i class="material-symbols-outlined">school</i>
                    <span class="nav-text">My Targets</span>
                </a>
            </li>
            <li class="{{ Request::routeIs('student.edu_center.overview') ? 'active' : '' }}">
                <a href="{{ route('student.edu_center.overview') }}">
                    <i class="material-symbols-outlined">menu_book</i>
                    <span class="nav-text">EduCenter</span>
                </a>
            </li>
            <li class="{{ Request::routeIs('student.teacher.profile') ? 'active' : '' }}">
                <a href="{{ route('student.teacher.profile') }}">
                    <i class="material-symbols-outlined">person</i>
                    <span class="nav-text">Teacher Profile</span>
                </a>
            </li>
            <li class="{{ Request::routeIs('student.learning_report.*') ? 'active' : '' }}">
                <a class="has-arrow" href="javascript:void(0);" aria-expanded="false">
                    <i class="material-symbols-outlined">assessment</i>
                    <span class="nav-text">Learning Report</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('student.learning_report.my_score.assessment') }}">My Score - Assessment</a></li>
                    <li><a href="{{ route('student.learning_report.my_score.kbm') }}">My Score - KBM</a></li>
                    <li><a href="{{ route('student.learning_report.my_score.drilling') }}">My Score - Drilling</a></li>
                    <li><a href="{{ route('student.learning_report.my_score.try_out') }}">My Score - Try Out</a></li>
                    <li><a href="{{ route('student.learning_report.my_report') }}">My Report</a></li>
                </ul>
            </li>
            @endrole
            
            <!-- Admin Sidebar role -->
            @role('owner')
            <li class="{{ Request::routeIs('dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}">
                    <i class="material-symbols-outlined">home</i>
                    <span class="nav-text">Dashboard Admin</span>
                </a>
            </li>
            <li class="{{ Request::routeIs('admin.master-data.*') ? 'active' : '' }}">
                <a class="has-arrow" href="javascript:void(0);" aria-expanded="false">
                    <i class="material-symbols-outlined">settings</i>
                    <span class="nav-text">Master Data</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('admin.master-data.brand.index') }}">Brand</a></li>
                    <li><a href="{{ route('admin.master-data.program.index') }}">Program</a></li>
                    <li><a href="{{ route('admin.master-data.sub-program.index') }}">Sub Program</a></li>
                    <li><a href="{{ route('admin.master-data.sla.index') }}">SLA</a></li>
                    <li><a href="{{ route('admin.master-data.user.index') }}">User</a></li>
                    <li><a href="{{ route('admin.master-data.teacher.index') }}">Guru</a></li>
                    <li><a href="{{ route('admin.master-data.student.index') }}">Siswa</a></li>
                    <li><a href="{{ route('admin.master-data.target.index') }}">Target Students</a></li>
                    <li><a href="{{ route('admin.master-data.class.index') }}">Kelas</a></li>
                    <li><a href="{{ route('admin.subject.index') }}">Mata Pelajaran</a></li>
                    <li><a href="{{ route('admin.master-data.material.index') }}">Materi</a></li>
                    <li><a href="{{ route('admin.master-data.academic-year.index') }}">Tahun Ajaran</a></li>
                    <li><a href="{{ route('admin.master-data.student-program.index') }}">Data Program Siswa</a></li>
                </ul>
            </li>
            <li class="{{ Request::routeIs('admin.educenter.index') ? 'active' : '' }}">
                <a href="{{ route('admin.educenter.index') }}">
                    <i class="material-symbols-outlined">menu_book</i>
                    <span class="nav-text">EduCenter</span>
                </a>
            </li>
            <li class="{{ Request::routeIs('admin.schedule.index') ? 'active' : '' }}">
                <a href="{{ route('admin.schedule.index') }}">
                    <i class="material-symbols-outlined">schedule</i>
                    <span class="nav-text">My Schedule</span>
                </a>
            </li>

            @endrole

            <!-- Teacher Routes (Only visible to teachers) -->
            @role('teacher')
            <li class="{{ Request::routeIs('teacher.dashboard') ? 'active' : '' }}">
                <a href="{{ route('teacher.dashboard') }}">
                    <i class="material-symbols-outlined">person</i>
                    <span class="nav-text">Teacher Dashboard</span>
                </a>
            </li>
            @endrole
        </ul>
        <div class="copyright">
            <p><strong>Eduline Dashboard</strong></p>
        </div>
    </div>
</div>
