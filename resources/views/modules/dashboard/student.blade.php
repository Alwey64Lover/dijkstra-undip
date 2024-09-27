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
                                    <h6 class="text-muted font-semibold">IPK</h6>
                                    <h4 class="font-semibold mb-0 value">3.59</h4>
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
                                    <h4 class="font-semibold mb-0 value">87</h4>
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
                                    <h4 class="font-semibold mb-0 value">Sandy Kurniawan, S.Kom., M.Kom.</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3>Her-Registrasi</h3>
                </div>

                <div class="card-body">
                    <div class="academic-status">
                        <p>
                            Status Akademik Anda:
                            <span class="badge bg-danger">
                                Belum Registrasi
                            </span>
                        </p>

                        <p>
                            Informasi lebih lanjut mengenai her-registrasi, atau mekanisme serta pengajuan penangguhan pembayaran dapat ditanyakan melalui Biro Administrasi Akademik (BAA) atau program studi masing-masing.
                        </p>
                    </div>

                    <div class="her-registration pt-4">
                        <p>Silahkan menekan salah satu tombol di bawah untuk melakukan her-registrasi status akademik anda.</p>

                        <div class="action">
                            <button class="btn btn-warning">Ajukan Usulan Cuti</button>
                            <button class="btn btn-success ms-3">Saya Akan Aktif Kuliah</button>
                        </div>

                        <div class="note mt-4">
                            <p class="m-0">Catatan:</p>
                            <p class="m-0"><small>Aktif - Anda akan mengikuti kegiatan perkuliahan pada semester ini serta mengisi Isian Rencana Studi (IRS).</small></p>
                            <p class="m-0"><small>Cuti - Menghentikan kuliah sementara untuk semester ini tanpa kehilangan status sebagai mahasiswa Undip.</small></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
