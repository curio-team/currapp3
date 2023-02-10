@extends('layouts.app')

@section('main')
    
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); row-gap: 1rem; column-gap: 3rem;">

        <h3 style="grid-row: 1; grid-column: 1;">Afgelopen blokken</h3>
        @foreach ($uitvoeren_verleden as $uitvoer)
            <div class="card hover-show" style="grid-row: {{ $loop->iteration+1 }}; grid-column: 1;">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <h5 class="card-title">{{ $uitvoer->naam }}</h5>
                    <a target="_blank" href="{{ route('opleidingen.uitvoeren.show', [$opleiding, $uitvoer]) }}" class="btn btn-sm btn-outline-secondary"><i class="fa-solid fa-eye fa-fw"></i></a>
                </div>
                <ul class="list-group list-group-flush">
                    @foreach($uitvoer->cohorten as $cohort)
                        <li class="list-group-item">{{ $cohort->naam }}</li>
                    @endforeach
                </ul>
            </div>
        @endforeach

        <h3 style="grid-row: 1; grid-column: 2;">Actuele blokken</h3>
        @foreach ($uitvoeren_actueel as $uitvoer)
            <div class="card hover-show border-secondary bg-light" style="grid-row: {{ $loop->iteration+1 }}; grid-column: 2;">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <h5 class="card-title">{{ $uitvoer->naam }}</h5>
                    <a target="_blank" href="{{ route('opleidingen.uitvoeren.show', [$opleiding, $uitvoer]) }}" class="btn btn-sm btn-outline-secondary"><i class="fa-solid fa-eye fa-fw"></i></a>
                </div>
                <ul class="list-group list-group-flush">
                    @foreach($uitvoer->cohorten as $cohort)
                        <li class="list-group-item">{{ $cohort->naam }}</li>
                    @endforeach
                </ul>
            </div>
        @endforeach

        <h3 style="grid-row: 1; grid-column: 3;">Aankomende blokken</h3>
        @foreach ($uitvoeren_toekomst as $uitvoer)
            <div class="card hover-show" style="grid-row: {{ $loop->iteration+1 }}; grid-column: 3;">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <h5 class="card-title">{{ $uitvoer->naam }}</h5>
                    <a target="_blank" href="{{ route('opleidingen.uitvoeren.show', [$opleiding, $uitvoer]) }}" class="btn btn-sm btn-outline-secondary"><i class="fa-solid fa-eye fa-fw"></i></a>
                </div>
                <ul class="list-group list-group-flush">
                    @foreach($uitvoer->cohorten as $cohort)
                        <li class="list-group-item">{{ $cohort->naam }}</li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </div>

@endsection