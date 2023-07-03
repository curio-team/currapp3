@extends('layouts.app')

@section('main')
    
    <div class="mb-3" style="display: grid; grid-template-columns: repeat(3, 1fr); row-gap: 1rem; column-gap: 3rem;">

        <h3 style="grid-row: 1; grid-column: 1;">Afgelopen blokken</h3>
        @foreach ($uitvoeren_verleden as $uitvoer)
            <div class="card hover-show" style="grid-row: {{ $loop->iteration+1 }}; grid-column: 1;">
                @include('opleidingen.card_contents', ['uitvoer' => $uitvoer])
            </div>
        @endforeach

        <h3 style="grid-row: 1; grid-column: 2;">Actuele blokken</h3>
        @foreach ($uitvoeren_actueel as $uitvoer)
            <div class="card hover-show border-secondary bg-light" style="grid-row: {{ $loop->iteration+1 }}; grid-column: 2;">
                @include('opleidingen.card_contents', ['uitvoer' => $uitvoer])
            </div>
        @endforeach

        <h3 style="grid-row: 1; grid-column: 3;">Aankomende blokken</h3>
        @foreach ($uitvoeren_toekomst as $uitvoer)
            <div class="card hover-show" style="grid-row: {{ $loop->iteration+1 }}; grid-column: 3;">
                @include('opleidingen.card_contents', ['uitvoer' => $uitvoer])
            </div>
        @endforeach
    </div>

@endsection