@extends('layouts.app')

@section('main')
    
    <div class="mb-3" style="display: grid; grid-template-columns: repeat(3, 1fr); column-gap: 3rem;">
        <div>
            <h3>Afgelopen blokken</h3>
            @foreach ($uitvoeren_verleden as $uitvoer)
                <div class="card hover-show mb-3">
                    @include('opleidingen.card_contents', ['uitvoer' => $uitvoer])
                </div>
            @endforeach
        </div>

        <div>
            <h3>Actuele blokken</h3>
            @foreach ($uitvoeren_actueel as $uitvoer)
                <div class="card hover-show border-secondary bg-light mb-3">
                    @include('opleidingen.card_contents', ['uitvoer' => $uitvoer])
                </div>
            @endforeach
        </div>

        <div>
            <h3>Aankomende blokken</h3>
            @foreach ($uitvoeren_toekomst as $uitvoer)
                <div class="card hover-show mb-3">
                    @include('opleidingen.card_contents', ['uitvoer' => $uitvoer])
                </div>
            @endforeach
        </div>
    </div>

@endsection