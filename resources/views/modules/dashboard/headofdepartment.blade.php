@extends('layouts.backend.app')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@section('title', 'Dashboard')

<style>
    .col-xl{
        padding-left: 15px
    }
    .stats-icon{
        padding-top: 20px
    }
</style>

@section('content')
<div class="card">
    <div class="card-body px-4 py-4-5">
        <div class="row">
            <div class="col-4">
                <div class="col-xxl d-flex justify-content-center ">
                    <div class="stats-icon blue mb-2">
                        <i class="bi-person-fill"></i>
                    </div>
                    <div class="col-xl", style>
                        <h6 class="text-muted font-semibold">Jumlah Mahasiswa Total</h6>
                        <h6 class="font-extrabold mb-0">6.062</h6>
                    </div>
                </div>
                <div class="card text-center" style="width: 15rem; margin-left:100px; margin-bottom:0px; margin-top:50px">
                    <span class="border rounded-top">
                        <img src="storage/static/if_undip.jpg" class="card-img-top" style="margin-top: 20px;margin-bottom: 20px; height: 120px; width: 120px;" />
                    </span>
                    <span class="border rounded-bottom">
                        <div class="card-body">
                          <h5 class="card-title ">2024/2025 Ganjil</h5>
                          <h6 class="card-text">Status : Berlangsung</h6>
                          <h6 class="card-text">Mahasiswa Aktif : 844</h6>
                          <a href="schedule" class="btn btn-primary">Lihat Jadwal</a>
                        </div>
                    </span>
                </div>
            </div>
            <div class="col-8">
                <div class="card-header">
                    <h4>Jumlah Mahasiswa 5 Tahun Terakhir</h4>
                </div>
                <div class="card-body">
                    <canvas id="chart-profile-visit"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
    document.addEventListener("DOMContentLoaded", function () {
    new Chart(document.getElementById("chart-profile-visit"), {
        type: "bar",
        data: {
            labels: ["2019", "2020", "2021", "2022", "2023", "2024"],
            datasets: [{
                label: "Laki-Laki",
                backgroundColor: "rgba(0, 123, 255, 1)",
                borderColor: "rgba(0, 123, 255, 1)",
                data: [400,449, 550, 532, 670, 640],
                barPercentage: 0.75,
                categoryPercentage: 0.5,
            }, {
                label: "Perempuan",
                backgroundColor: "#dee2e6",
                borderColor: "#dee2e6",
                data: [75, 90, 82, 120, 150, 204],
                barPercentage: 0.75,
                categoryPercentage: 0.5,
            }],
        },
        options: {
            scales: {
                y: {
                    grid: {
                        display: false,
                    },
                },
                x: {
                    grid: {
                        color: "transparent",
                    },
                },
            },
        },
    });
});

</script>
