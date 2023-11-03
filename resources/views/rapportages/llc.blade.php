@extends('layouts.app')

@section('title', 'LLC\'s')
@section('container-class', 'container-fluid p-0')

@section('subnav')
    <nav class="navbar navbar-dark navbar-expand bg-secondary subnav">
        <div class="container-fluid justify-content-between">
            <div class="navbar-brand">LLC: LeerLijnCoördinatoren</div>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('opleidingen.rapportage.llc', $opleiding) }}">per blok en vak</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('opleidingen.rapportage.llc.2', $opleiding) }}">per leerlijn of gebruiker</a>
                    </li>
                </ul>
            </div>
            <div>
                @if(Auth::user()->leerlijnen->count())
                    <div class="me-2 d-inline-block"><small><em>Mijn leerlijnen:</em></small></div>
                    @foreach (Auth::user()->leerlijnen as $leerlijn)
                        <span class="badge me-2" style="background-color: {{ $leerlijn->color }}; color: {{ $leerlijn->textColor }}">{{ $leerlijn->naam }}</span>
                    @endforeach
                @endif
            </div>
        </div>
    </nav>
@endsection

@section('main')
    <table class="table table-sm table-hover table-striped-columns text-center m-0">
        <tr>
            <th class="table-secondary"></th>
            @foreach($per_vak->first() as $blok => $values)
                <th class="table-secondary">{{ $blok }}</th>
            @endforeach
        </tr>

        @foreach($per_vak as $vak => $blokken)
            <tr>
                <th class="table-secondary text-start" style="padding-left: calc(var(--bs-gutter-x) * 0.5);">{{ $vak }}</th>
                @foreach($blokken as $blok => $eigenaars)
                    <td>{{ $eigenaars }}</td>
                @endforeach
            </tr>
        @endforeach
    </table>
@endsection