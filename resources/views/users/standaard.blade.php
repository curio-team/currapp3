@extends('layouts.app')

@section('main')

    <h1>Kies een opleiding</h1>
    <p>Kies een standaard-opleiding die wordt getoond wanneer je de app opent. Je kunt dit later nog aanpassen.</p>

    <form action="{{ route('standaard.store') }}" method="POST">
        @csrf
        <select class="form-select form-select-lg mb-3" name="opleiding_id">
            @foreach ($user->teams as $team)
                @foreach ($team->opleidingen as $opleiding)
                    <option value="{{ $opleiding->id }}">{{ $opleiding->naam }} | {{ $opleiding->omschrijving }}</option>
                @endforeach
            @endforeach
        </select>
        <button type="submit" class="btn btn-success btn-lg"><i class="fa-regular fa-floppy-disk me-2"></i>Opslaan</button>
    </form>

@endsection