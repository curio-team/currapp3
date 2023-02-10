@extends('layouts.app')

@section('container-class', 'container-fluid')

@section('subnav')
    <nav class="navbar navbar-dark bg-secondary subnav">
        <div class="container-fluid">
            <div class="navbar-brand">{{ $uitvoer->naam }}</div>
            <div>
                <button class="btn btn-outline-light me-2" data-bs-toggle="modal" data-bs-target="#linkModuleModal"><i class="fa-solid fa-plus fa-fw"></i> Module</button>
                <button class="btn btn-outline-light" data-bs-toggle="modal" data-bs-target="#linkVakModal"><i class="fa-regular fa-edit fa-fw"></i> Vakken</button>
            </div>
        </div>
    </nav>
@endsection

@section('main')

    <div class="leerplan" style="display: grid; grid-template-columns: auto repeat({{ $uitvoer->vakken->count() }}, 1fr) auto; column-gap: 1rem;">
        @for ($i = 1; $i <= 16; $i++)
            <div class="d-flex justify-content-center align-items-center" style="grid-column: 1; grid-row: {{ $i+1 }}; text-align: center;"><em>{{ $i }}</em></div>
            <div class="d-flex justify-content-center align-items-center" style="grid-column: {{ $uitvoer->vakken->count()+2 }}; grid-row: {{ $i+1 }}; text-align: center;"><em>{{ $i }}</em></div>
        @endfor
        
        @foreach($uitvoer->vakken as $vak)
            <div style="grid-column: {{ $loop->iteration+1 }}; grid-row: 1; text-align: center;"><strong>{{ $vak->parent->naam }}</strong></div>
            @foreach ($vak->modules as $module)
                <div class="module p-2 text-center" style="grid-column: {{ $loop->parent->iteration+1 }}; grid-row: {{ $module->pivot->week_start+1 }} / {{ $module->pivot->week_eind+2 }};">
                    {{ $module->parent->naam }} {{ $module->naam }}
                </div>
            @endforeach
        @endforeach
    </div>

    <!-- Modals -->
    @include('uitvoeren.link_module')
    @include('uitvoeren.link_vak')

@endsection