@extends('layouts.app')

@section('container-class', 'container-fluid mt-3')

@section('subnav')
    <nav class="navbar navbar-dark bg-secondary subnav">
        <div class="container-fluid">
            <div class="navbar-brand">{{ $versie->parent->naam }}</div>
            <div class="d-print-none btn-group">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-outline-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">{{ $versie->naam }}</button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        @foreach($module->versies as $v)
                            <li><a class="dropdown-item" href="{{ route('opleidingen.modules.show.versie', [$opleiding, $module, $v]) }}">{{ $v->naam }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <button class="btn btn-outline-light" data-bs-toggle="modal" data-bs-target="#linkVakModal"><i class="fa-regular fa-plus fa-fw"></i></button>
            </div>
        </div>
    </nav>
@endsection

@section('main')

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row">
        <div class="col">
            <div class="accordion">
                @if($module->omschrijving)
                    <div class="accordion-item">
                        <button class="accordion-header accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panel1" aria-expanded="true" aria-controls="panel1">
                            Omschrijving module
                        </button>
                        <div id="panel1" class="accordion-collapse collapse">
                            <div class="accordion-body">{{ $module->omschrijving }}</div>
                        </div>
                    </div>
                @endif
                @if($module->map_url)
                    <div class="accordion-item">
                        <button class="accordion-header accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panel2" aria-expanded="true" aria-controls="panel2">
                            Link naar map
                        </button>
                        <div id="panel2" class="accordion-collapse collapse">
                            <div class="accordion-body"><a href="{{ $module->map_url }}" target="_blank">link</a></div>
                        </div>
                    </div>
                @endif
                <div class="accordion-item">
                    <button class="accordion-header accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panel4" aria-expanded="true" aria-controls="panel4">
                        Koppeling module aan vakken (<em>alle versies</em>)
                    </button>
                    <div id="panel4" class="accordion-collapse collapse">
                        <div class="accordion-body">
                            <ul>
                                @foreach($module->versies as $v)
                                    <li>
                                        {{ $module->naam }} {{ $v->naam }}
                                        <ul>
                                            @foreach($v->vakken as $vak)
                                                <li>{{ $vak->parent->naam }} in {{ $vak->uitvoer->naam }}</li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <button class="accordion-header accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panel3" aria-expanded="true" aria-controls="panel3">
                        Koppeling module aan vakken (<em>huidige versie</em>)
                    </button>
                    <div id="panel3" class="accordion-collapse collapse show">
                        <div class="accordion-body">
                            <table class="table table-bordered table-hover">
                                <tr class="table-light">
                                    <th>Vak</th>
                                    <th>Blok</th>
                                    <th>Punten vak</th>
                                    <th>Weken</th>
                                </tr>
                                @foreach($versie->vakken as $vak)
                                    <tr>
                                        <td>{{ $vak->parent->naam }}</td>
                                        <td>{{ $vak->uitvoer->naam }}</td>
                                        <td>{{ $vak->points }}</td>
                                        <td>{{ $vak->pivot->week_start }} - {{ $vak->pivot->week_eind }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <button class="accordion-header accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panel5" aria-expanded="true" aria-controls="panel5">
                        Feedbackmomenten
                    </button>
                    <div id="panel5" class="accordion-collapse collapse show">
                        <div class="accordion-body">
                            @livewire('feedbackmomenten', ['versie' => $versie])
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="accordion">
                <div class="accordion-item">
                    <button class="accordion-header accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panel6" aria-expanded="true" aria-controls="panel6">
                        Acceptatiecriteria
                    </button>
                    <div id="panel6" class="accordion-collapse collapse">
                        <div class="accordion-body">
                            TODO
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <button class="accordion-header accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panel7" aria-expanded="true" aria-controls="panel7">
                        Comments
                    </button>
                    <div id="panel7" class="accordion-collapse collapse show">
                        <div class="accordion-body">
                            TODO
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="fbmCreateModal" tabindex="-1" role="dialog" aria-labelledby="fbmCreateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-fullscreen-md-down" role="document">
            <div class="modal-content">
                <form action="{{ route('opleidingen.modules.fbm.create', [$opleiding, $module, $versie]) }}" method="POST">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="fbmCreateModalLabel">Nieuw feedbackmoment</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click.prevent="clearItem()"></button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="naam">Onderwerp *:</label>
                                    <input type="text" class="form-control" id="naam" name="naam" required>
                                    @error('item.naam') <span class="text-danger error">{{ $message }}</span>@enderror
                                </div>
                                <div class="mb-3">
                                    <label for="points">Punten *:</label>
                                    <input type="number" class="form-control" id="points" name="points" required>
                                    @error('item.points') <span class="text-danger error">{{ $message }}</span>@enderror
                                </div>
                                <div class="mb-3">
                                    <label for="cesuur">Cesuur *:</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="cesuur" name="cesuur" placeholder="70" required>
                                        <span class="input-group-text">%</span>
                                    </div>
                                    @error('item.cesuur') <span class="text-danger error">{{ $message }}</span>@enderror
                                </div>
                                <div class="mb-3">
                                    <label for="week">Blokweek *:</label>
                                    <input type="number" class="form-control" id="week" name="week" required>
                                    @error('item.week') <span class="text-danger error">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="checks">Checks:</label>
                                    <textarea id="checks" name="checks" class="form-control" rows="13"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuleren</button>
                        <input type="submit" class="btn btn-success" value="Opslaan" />
                    </div>
                </form>
            </div>
        </div>
    </div>
    

@endsection