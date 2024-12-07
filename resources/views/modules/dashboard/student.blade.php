@extends('layouts.backend.app')

@section('title', 'Dashboard')

@section('content')
<section class="section dashboard">
    <div class="col-12">
        <div class="row">
            <div class="col-6 col-lg-4 col-md-6">
                <div class="card summary">
                    <div class="card-body px-4 py-4-5">
                        <div class="row">
                            <div class="col-3">
                                <div class="stats-icon mb-2">
                                    <i class="bi bi-award-fill"></i>
                                </div>
                            </div>
                            <div class="col-9">
                                <h6 class="text-muted font-semibold">Tahun Akademik</h6>
                                <h4 class="font-semibold mb-0 value">{{ $academic_year}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-4 col-md-6">
                <div class="card summary">
                    <div class="card-body px-4 py-4-5">
                        <div class="row">
                            <div class="col-3">
                                <div class="stats-icon mb-2">
                                    <i class="bi bi-diagram-3-fill"></i>
                                </div>
                            </div>
                            <div class="col-9">
                                <h6 class="text-muted font-semibold">SKS Kumulatif</h6>
                                <h4 class="font-semibold mb-0 value">{{ $total_sks}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-4 col-md-6">
                <div class="card summary">
                    <div class="card-body px-4 py-4-5">
                        <div class="row">
                            <div class="col-3">
                                <div class="stats-icon mb-2">
                                    <i class="bi bi-person-video3"></i>
                                </div>
                            </div>
                            <div class="col-9">
                                <h6 class="text-muted font-semibold">Dosen Wali</h6>
                                <h4 class="font-semibold mb-0 value">{{$academic_advisor }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
