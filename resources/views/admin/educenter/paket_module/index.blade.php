@extends('layouts.dashboard')
@section('title', 'Subjects List')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12">
            <div class="page-title flex-wrap">
                <div class="input-group search-area mb-md-0 mb-3">
                    <input type="text" class="form-control" placeholder="Search here...">
                    <span class="input-group-text">
                        <a href="javascript:void(0)">
                            <i class="material-icons" id="search-button">search</i>
                        </a>
                    </span>
                </div>
                <a href="javascript:history.back()" class="btn btn-light">
                    <i class="material-icons">arrow_back</i> Back
                </a>
            </div>
        </div>


        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Whoops!</strong> Ada kesalahan pada input Anda:<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="col-xl-12">
            <div class="accordion accordion-primary" id="subjectsAccordion">
                @forelse ($subjects as $subject)
                    <div class="accordion-item">
                        <div class="accordion-header rounded-lg" id="heading-{{ $subject->id }}" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $subject->id }}" aria-expanded="false" role="button">
                            <span class="accordion-header-text">{{ $subject->name }}</span>
                        </div>
                        <div id="collapse-{{ $subject->id }}" class="accordion-collapse collapse" data-bs-parent="#subjectsAccordion">
                            <div class="accordion-body">
                                <div>
                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editSubjectModal-{{ $subject->id }}">Upload PDF</button>
                                    <button 
                                        class="btn btn-danger btn-sm" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#uploadVideoModal-{{ $subject->id }}">
                                        Upload Video
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="editSubjectModal-{{ $subject->id }}" tabindex="-1" aria-labelledby="editSubjectModalLabel-{{ $subject->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editSubjectModalLabel-{{ $subject->id }}">Upload PDF for {{ $subject->name }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('admin.educenter.subjects.upload-pdf', $subject->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="edu_id" value="{{ $id }}"> 

                                    <div class="modal-body">
                                        <div class="pdf-upload-item mb-3">
                                            <label for="pdf" class="form-label">Choose PDF File</label>
                                            <input type="file" class="form-control" id="pdf" name="pdf" required>
                                            @error('pdf')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror

                                            <label for="title" class="form-label mt-2">Material Title</label>
                                            <input type="text" class="form-control" id="title" name="title" placeholder="Enter material title" required>
                                            @error('title')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Upload PDF</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    {{-- modal upload video --}}
                    <div class="modal fade" id="uploadVideoModal-{{ $subject->id }}" tabindex="-1" aria-labelledby="uploadVideoModalLabel-{{ $subject->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="uploadVideoModalLabel-{{ $subject->id }}">Upload YouTube Video Link for {{ $subject->name }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('admin.educenter.subjects.upload-video', $subject->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="edu_id" value="{{ $id }}">

                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="youtube_url" class="form-label">YouTube URL</label>
                                            <input type="url" class="form-control" id="youtube_url" name="youtube_url" placeholder="Enter YouTube video URL" required>
                                            @error('youtube_url')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Upload Video</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="alert alert-warning">No Subjects Available</div>
                @endforelse
            </div>

            <div class="mt-3">
                {{ $subjects->links() }}
            </div>
        </div>
    </div>
</div>     
@endsection