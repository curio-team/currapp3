@extends('layouts.app')
@section('title', 'Printen: ' . $uitvoer->naam)
@section('container-class', 'container-fluid mt4 break-my-page')
@section('main')

    <div class="my-5">
        <h1>Studiepuntenplan {{ $uitvoer->naam }}</h1>
        <p><em>Export gemaakt op {{ Carbon\Carbon::now()->format("d-m-Y") }} door {{ \Auth::user()->id }}</em></p>
    </div>

    @foreach($uitvoer->vakken as $vak)
        @include('uitvoeren.studiepuntenplan', ['mode' => 'print', 'vak_voor_punten' => $vak])
    @endforeach
    
    <script>
        window.onload = function() { window.print(); }
    </script>

@endsection
