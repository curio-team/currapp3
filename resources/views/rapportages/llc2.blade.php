@extends('layouts.app')


@section('subnav')
    <nav class="navbar navbar-dark navbar-expand bg-secondary subnav">
        <div class="container-fluid justify-content-between">
            <div class="navbar-brand">LLC: LeerLijnCoördinatoren</div>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('opleidingen.rapportage.llc', $opleiding) }}">per blok en vak</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('opleidingen.rapportage.llc.2', $opleiding) }}">per leerlijn of gebruiker</a>
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

    <div class="mb-3" style="display: grid; grid-template-columns: repeat(2, 1fr); column-gap: 4rem;">
        <div>
            <div class="mb-3">
                <h3 class="mb-0">Per leerlijn</h3>
                <em>Op alfabet:</em>
            </div>
            <table class="table table-sm table-hover">
                @foreach ($opleiding->leerlijnen as $leerlijn)
                    <tr>
                        <td class="ps-0">{{ $leerlijn->naam }}</td>
                        <td>{{ $leerlijn->eigenaar_id }}</td>
                    </tr>
                @endforeach
            </table>
        </div>

        <div>
            <div class="mb-3">
                <h3 class="mb-0">Per gebruiker</h3>
                <em>Op alfabet:</em>
            </div>
            <table class="table table-sm table-hover">
                @foreach ($per_eigenaar as $eigenaar_id => $leerlijnen)
                    <tr>
                        <td class="ps-0">{{ $eigenaar_id }}</td>
                        <td>
                            @foreach($leerlijnen as $leerlijn)
                                {{ $leerlijn['naam'] }}<br />
                            @endforeach
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>

@endsection