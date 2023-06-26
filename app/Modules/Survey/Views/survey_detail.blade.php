@extends('layouts.app')

@section('page-css')
@endsection

@section('main')
<div class="page-heading">
    <div class="page-title">
        <div class="row mb-2">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <a href="{{ route('survey.index') }}" class="btn btn-sm icon icon-left btn-outline-secondary"><i class="fa fa-arrow-left"></i> Kembali </a>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('survey.index') }}">{{ $title }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $survey->nama }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <h6 class="card-header">
                Detail Data {{ $title }}: {{ $survey->nama }}
            </h6>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-10 offset-lg-2">
                        <div class="row">
                            <div class='col-lg-2'><p>Desa</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $survey->desa->id }}</p></div>
									<div class='col-lg-2'><p>Jenis Lahan</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $survey->jenisLahan->id }}</p></div>
									<div class='col-lg-2'><p>Nama</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $survey->nama }}</p></div>
									<div class='col-lg-2'><p>Luas</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $survey->luas }}</p></div>
									<div class='col-lg-2'><p>Koordinat</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $survey->koordinat }}</p></div>
									<div class='col-lg-2'><p>Keterangan</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $survey->keterangan }}</p></div>
									
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
</div>
@endsection

@section('page-js')
@endsection

@section('inline-js')
@endsection