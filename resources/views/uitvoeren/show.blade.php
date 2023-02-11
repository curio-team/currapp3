@extends('layouts.app')

@section('container-class', 'container-fluid')

@section('subnav')
    <nav class="navbar navbar-dark bg-secondary subnav">
        <div class="container-fluid">
            <div class="navbar-brand">{{ $uitvoer->naam }}</div>
            <div class="d-print-none btn-group">
                <button class="btn btn-outline-light"><i class="fa-regular fa-comments fa-fw"></i> Comments</button>
                <button class="btn btn-outline-light" data-bs-toggle="modal" data-bs-target="#linkModuleModal"><i class="fa-solid fa-plus fa-fw"></i> Module</button>
                <button class="btn btn-outline-light" data-bs-toggle="modal" data-bs-target="#linkVakModal"><i class="fa-regular fa-edit fa-fw"></i> Vakken</button>
            </div>
        </div>
    </nav>
@endsection

@section('main')

    @livewire('leerplan', ['opleiding' => $opleiding, 'uitvoer' => $uitvoer])

    <!-- Modals -->
    @include('uitvoeren.link_module')
    @include('uitvoeren.link_vak')

@endsection