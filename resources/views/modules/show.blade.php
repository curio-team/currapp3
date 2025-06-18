@extends('layouts.app')

@section('title', 'Module ' . $versie->parent->naam)
@section('container-class', 'container-fluid mt-3')

@section('subnav')
    <nav class="navbar navbar-dark bg-secondary subnav">
        <div class="container-fluid">
            <div class="navbar-brand">
                <span class="badge me-2" style="background-color: {{ $module->leerlijn->color }}; color: {{ $module->leerlijn->textColor }}">{{ $versie->parent->leerlijn->naam }}</span>
                <strong>{{ $versie->parent->naam }}</strong>
            </div>
            <div class="d-print-none btn-group">
                <div class="btn btn-outline-light"><i class="fa-solid fa-user-tie fa-fw"></i> {{ $versie->parent->eigenaar_id }}</div>
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-outline-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">{{ $versie->naam }}</button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        @foreach($module->versies as $v)
                            <li><a class="dropdown-item" href="{{ route('opleidingen.modules.show.versie', [$opleiding, $module, $v]) }}">{{ $v->naam }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <button class="btn btn-outline-light" data-bs-toggle="modal" data-bs-target="#newVersionModal"><i class="fa-regular fa-plus fa-fw"></i></button>
                <button class="btn btn-outline-light" data-bs-toggle="modal" data-bs-target="#updateModuleModal"><i class="fa-regular fa-edit fa-fw"></i></button>
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
    <div class="row mb-4">
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
                    <button class="accordion-header accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panel5" aria-expanded="true" aria-controls="panel5">
                        Feedbackmomenten
                    </button>
                    <div id="panel5" class="accordion-collapse collapse show">
                        <div class="accordion-body">
                            @livewire('feedbackmomenten', ['versie' => $versie])
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <button class="accordion-header accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panel3" aria-controls="panel3">
                        Koppeling module aan vakken (<em>huidige versie</em>)
                    </button>
                    <div id="panel3" class="accordion-collapse collapse">
                        <div class="accordion-body">
                            <table class="table table-bordered table-hover">
                                <tr class="table-light">
                                    <th>Vak</th>
                                    <th>Blok</th>
                                    {{-- <th>Punten vak</th> --}}
                                    <th>Weken</th>
                                </tr>
                                @foreach($versie->vakken as $vak)
                                    <tr>
                                        <td>{{ $vak->parent->naam }}</td>
                                        <td>{{ $vak->uitvoer->naam }}</td>
                                        {{-- <td>{{ $vak->points }}</td> --}}
                                        <td>{{ $vak->pivot->week_start }} - {{ $vak->pivot->week_eind }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
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
                            <div class="col-5">
                                <div class="mb-3">
                                    <label for="naam">Onderwerp *:</label>
                                    <input type="text" class="form-control" id="naam" name="naam" required>
                                    <div class="text-muted"><em>Het onderwerp kan niet meer gewijzigd worden na aanmaken.</em></div>
                                    @error('item.naam') <span class="text-danger error">{{ $message }}</span>@enderror
                                </div>
                                {{-- <div class="mb-3">
                                    <label for="points">Punten *:</label>
                                    <input type="number" class="form-control" id="points" name="points" required>
                                    @error('item.points') <span class="text-danger error">{{ $message }}</span>@enderror
                                </div> --}}
                                <div class="mb-3">
                                    <label for="cesuur">Cesuur *:</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="cesuur" name="cesuur" placeholder="70" required>
                                        <span class="input-group-text">%</span>
                                    </div>
                                    <div class="text-muted"><em>Minstens 50%, maximaal 70%</em></div>
                                    @error('item.cesuur') <span class="text-danger error">{{ $message }}</span>@enderror
                                </div>
                                <div class="mb-3">
                                    <label for="week">Blokweek *:</label>
                                    <input type="number" class="form-control" id="week" name="week" required>
                                    @error('item.week') <span class="text-danger error">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <div class="col-7">
                                <div class="mb-3">
                                    <label for="checks">Checks:</label>
                                    <input id="checks" type="hidden" name="checks">
                                    <trix-editor class="trix-content" input="checks"></trix-editor>

                                    <script type="text/javascript">
                                    (function() {
                                        // check if button file tools group is present
                                        if(document.querySelector(".trix-button-group--file-tools")) {
                                            addEventListener("trix-initialize", function(e) {
                                                const file_tools = document.querySelector(".trix-button-group--file-tools");
                                                file_tools.remove();
                                            })
                                            addEventListener("trix-file-accept", function(e) {
                                                e.preventDefault();
                                            })
                                        }
                                    })();
                                    </script>
                                    <div class="text-muted"><em>Tip: bij leeglaten verschijnt een waarschuwing dat je de checks nog moet invullen.</em></div>
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

    <div class="modal fade" id="updateModuleModal" tabindex="-1" role="dialog" aria-labelledby="updateModuleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen-md-down" role="document">
            <form method="POST" action="{{ route('opleidingen.modules.update', [$opleiding, $module]) }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="updateModuleModalLabel">Aanpassen</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click.prevent="clearItem()"></button>
                    </div>
                    <div class="modal-body">
                            @csrf
                            <div class="mb-3">
                                <label for="naam">Naam *:</label>
                                <input type="text" class="form-control" id="naam" name="naam" value="{{ $module->naam }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="omschrijving">Omschrijving:</label>
                                <input type="text" class="form-control" id="omschrijving" name="omschrijving" value="{{ $module->omschrijving }}">
                            </div>
                            <div class="mb-3">
                                <label for="map_url">Link naar map:</label>
                                <input type="text" class="form-control" id="map_url" name="map_url" value="{{ $module->map_url }}">
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuleren</button>
                        <button type="submit" class="btn btn-success"><i class="fa-regular fa-floppy-disk fa-fw"></i>Opslaan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="newVersionModal" tabindex="-1" role="dialog" aria-labelledby="newVersionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen-md-down" role="document">
            <form method="POST" action="{{ route('opleidingen.modules.versie.create', [$opleiding, $module]) }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="newVersionModalLabel">Nieuwe versie maken</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click.prevent="clearItem()"></button>
                    </div>
                    <div class="modal-body">
                            @csrf
                            <p>Je gaat nu een nieuwe versie maken van deze module. Alle gegevens worden gekopieerd vanaf de huidige hoogste versie. De feedbackmomenten blijven bestaan en worden ook gelinkt aan deze nieuwe versie.</p>
                            <p>Hierna kun je deze nieuwe versie aan een vak koppelen, bijvoorbeeld in het blok dat volgend jaar start. Je kunt dan op de nieuwe versie wijzingen doen, terwijl het huidige blok met de vorige versie blijft werken.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuleren</button>
                        <button type="submit" class="btn btn-success"><i class="fa-regular fa-plus fa-fw"></i>Nieuwe versie</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


@endsection
