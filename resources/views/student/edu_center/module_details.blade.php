@extends('layouts.dashboard') 
@section('content')
<div class="container my-5">
    <!-- Back Button -->
    <div class="mb-4">
        <a href="{{ route('student.edu_center.overview') }}" class="btn btn-light">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
    <div class="card">
        <div class="card-header border-0 pb-0 flex-wrap">
            <h4 class="mb-0">E - Module ✨</h4>
            <!-- Scrollable Tabs -->
            <div class="nav-tabs-wrapper overflow-auto">
                <ul class="nav nav-tabs food-tabs" id="myTab" role="tablist" style="white-space: nowrap;">
                    @foreach ($subjects as $key => $subject)
                        <li class="nav-item" role="presentation" style="display: inline-block;">
                            <button class="nav-link {{ $key === 0 ? 'active' : '' }}" id="subject-{{ $subject->id }}-tab" 
                                data-bs-toggle="tab" 
                                data-bs-target="#subject-{{ $subject->id }}-pane" 
                                type="button" role="tab" 
                                aria-controls="subject-{{ $subject->id }}-pane" 
                                aria-selected="{{ $key === 0 ? 'true' : 'false' }}">
                                {{ $subject->name }}
                            </button>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="card-body">
            <div class="tab-content" id="myTabContent">
                @foreach ($subjects as $key => $subject)
                    <div class="tab-pane fade {{ $key === 0 ? 'show active' : '' }}" id="subject-{{ $subject->id }}-pane" role="tabpanel" aria-labelledby="subject-{{ $subject->id }}-tab" tabindex="0">
                        <div class="table-responsive">
                            <table class="table table-details">
                                <tbody>
                                    @forelse ($subject->modules as $module)
                                        <tr>
                                            <!-- Module Information -->
                                            <td style="width:100px;">
                                                <div class="food-menu d-flex align-items-center">
                                                    <img class="me-3 rounded avatar avatar-xl" src="{{ asset('eduline/images/educenter/Learning-bro.svg') }}" alt="Module Image">
                                                    <div class="food-info">
                                                        <span class="badge badge-sm badge-primary mb-2">Module</span>
                                                        <h5>
                                                            <a href="javascript:void(0);">{{ $module->name }}</a>
                                                        </h5>
                                                    </div>
                                                </div>
                                            </td>
                                            <!-- Views -->
                                            <td>
                                                <ul class="d-flex align-items-center">
                                                    <li>
                                                        <span>{{ $module->title ?? 'No Title' }}</span>
                                                    </li>
                                                </ul>
                                            </td>
                                            <!-- Actions Dropdown -->
                                            <td class="text-end">
                                                <div class="dropdown custom-dropdown">
                                                    <div class="btn sharp btn-light" data-bs-toggle="dropdown">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </div>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a class="dropdown-item" href="{{ asset('storage/' . $module->pdf_path) }}">View PDF</a>
                                                        @if ($module->youtube_link)
                                                            <button 
                                                                class="dropdown-item" 
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#videoModal-{{ $module->id }}">
                                                                Watch Video
                                                            </button>
                                                        @else
                                                            <p class="text-muted dropdown-item mb-0">No Video Available</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Video Modal -->
                                        @if ($module->youtube_link)
                                            <div class="modal fade" id="videoModal-{{ $module->id }}" tabindex="-1" aria-labelledby="videoModalLabel-{{ $module->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="videoModalLabel-{{ $module->id }}">{{ $module->title ?? 'No Title' }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body text-center">
                                                            <iframe 
                                                                width="100%" 
                                                                height="400" 
                                                                src="https://www.youtube.com/embed/{{ $module->youtube_link }}" 
                                                                title="YouTube video player" 
                                                                frameborder="0" 
                                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                                                allowfullscreen>
                                                            </iframe>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @empty
                                        <!-- No Modules Available -->
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">No modules available for this subject.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
