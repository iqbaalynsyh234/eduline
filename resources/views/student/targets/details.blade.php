@extends('layouts.dashboard')
@section('title', 'Target Details')
@section('content')
<div class="container-fluid py-4">
    <h4 class="mb-4"><span>✨</span> My Target - {{ $target->title }}</h4>
    <a href="{{ route('student.targets.my_targets') }}" class="btn btn-secondary mb-3"><- Back</a>
    <div class="card shadow-sm">
        <div class="card-body">
            <h5>{{ $target->description }}</h5>
            <p>Schedule: {{ $target->schedule }} | Time: {{ $target->time }}</p>

            @if ($target->title === 'Jasmani')
                <table class="table table-bordered text-center">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>
                                <div>PULL UP (x)</div>
                                <div class="text-muted">Jumlah | Nilai</div>
                            </th>
                            <th>
                                <div>PUSH UP</div>
                                <div class="text-muted">Jumlah | Nilai</div>
                            </th>
                            <th>
                                <div>SIT UP</div>
                                <div class="text-muted">Jumlah | Nilai</div>
                            </th>
                            <th>
                                <div>SHUTTLE RUN</div>
                                <div class="text-muted">Jumlah | Nilai</div>
                            </th>
                            <th>
                                <div>RENNANG</div>
                                <div class="text-muted">Jumlah | Nilai</div>
                            </th>
                            <th>
                                <div>NILAI AKHIR</div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($target->kkmDetails as $index => $kkm)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <span class="text-danger">{{ $kkm['jumlah'] }}</span>
                                    <br>
                                    <span>{{ $kkm['nilai'] }}</span>
                                </td>
                                <td>
                                    <span class="text-danger">{{ $kkm['jumlah'] }}</span>
                                    <br>
                                    <span>{{ $kkm['nilai'] }}</span>
                                </td>
                                <td>
                                    <span class="text-danger">{{ $kkm['jumlah'] }}</span>
                                    <br>
                                    <span>{{ $kkm['nilai'] }}</span>
                                </td>
                                <td>
                                    <span class="text-danger">{{ $kkm['jumlah'] }}</span>
                                    <br>
                                    <span>{{ $kkm['nilai'] }}</span>
                                </td>
                                <td>
                                    <span class="text-danger">{{ $kkm['jumlah'] }}</span>
                                    <br>
                                    <span>{{ $kkm['nilai'] }}</span>
                                </td>
                                <td>
                                    <span>{{ $kkm['nilai'] }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No Data Available in Data Table</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            @else
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Mata Pelajaran</th>
                            <th>KKM</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($target->kkmDetails as $index => $kkm)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $kkm->subject }}</td>
                                <td class="text-danger">{{ $kkm->kkm }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">No Data Available in datatable</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection
