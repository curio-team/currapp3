@extends('layouts.app')
@section('container-class', 'container-fluid mt4')
@section('title', 'Printen: ' . $vak_voor_punten->parent->naam . ' in ' . $uitvoer->naam)
@section('main')
    @include('uitvoeren.studiepuntenplan', ['mode' => 'print'])

    <script>
        window.onload = function() { window.print(); }
    </script>

@endsection
