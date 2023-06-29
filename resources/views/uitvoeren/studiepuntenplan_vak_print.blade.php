@extends('layouts.app')
@section('container-class', 'container-fluid mt4')
@section('main')
    @include('uitvoeren.studiepuntenplan', ['mode' => 'print'])
    
    <script>
        window.onload = function() { window.print(); }
    </script>

@endsection
