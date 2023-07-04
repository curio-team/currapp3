@extends('layouts.app')

@section('container-class', 'container-fluid')

@section('subnav')
    <nav class="navbar navbar-dark bg-secondary subnav">
        <div class="container-fluid">
            <div class="navbar-brand">{{ $uitvoer->naam }}</div>
            <div class="d-print-none btn-group">
                <button class="btn btn-outline-light" data-bs-toggle="modal" data-bs-target="#editStudiepuntenBlokModal">
                    @if($uitvoer->points == $uitvoer->totaal_punten)
                        <i class="fa-solid fa-fw fa-check"></i>
                    @else
                        <i class="fa-solid fa-fw fa-triangle-exclamation text-warning"></i>
                        {{ $uitvoer->totaal_punten }} / 
                    @endif
                    {{ $uitvoer->points }} studiepunten</button>
                <button class="btn btn-outline-light"><i class="fa-regular fa-comments fa-fw"></i> Comments</button>
                <button class="btn btn-outline-light" data-bs-toggle="modal" data-bs-target="#linkVakModal"><i class="fa-regular fa-edit fa-fw"></i> Vakken</button>
                <button class="btn btn-outline-light" data-bs-toggle="modal" data-bs-target="#editWeeksModal"><i class="fa-regular fa-edit fa-fw"></i></button>
            </div>
        </div>
    </nav>
@endsection

@section('main')

    @livewire('leerplan', ['opleiding' => $opleiding, 'uitvoer' => $uitvoer])

    <!-- Modals -->
    @include('uitvoeren.link_module')
    @include('uitvoeren.link_vak')
    @include('uitvoeren.edit_studiepunten_blok')

    @if(session('vakken_update_preview'))
        <div class="modal fade" id="linkVakPreviewModal" tabindex="-1" role="dialog" aria-labelledby="linkVakPreviewModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-fullscreen-md-down" role="document">
                <form class="modal-content" method="POST" action="{{ route('uitvoeren.link.vak', $uitvoer) }}">
                    @csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="linkVakPreviewModalLabel">Vakken aanpassen</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click.prevent="clearItem()"></button>
                    </div>
                    <div class="modal-body">
                        Je gaat de volgende wijzigingen toepassen op <strong>{{ $uitvoer->naam }}</strong>:
                        @foreach (session('vakken_update_preview')['added'] as $vak)
                            <div class="text-success fw-bold"><i class="fa-solid fa-plus"></i> {{ \App\Models\Vak::find($vak)->naam }}</div>
                            <input type="hidden" name="added[]" value="{{ $vak }}">
                        @endforeach
                        @foreach (session('vakken_update_preview')['removed'] as $vak)
                            <div class="text-danger fw-bold"><i class="fa-solid fa-minus"></i> {{ \App\Models\Vak::find($vak)->naam }}</div>
                            <input type="hidden" name="removed[]" value="{{ $vak }}">
                        @endforeach
                        @foreach (session('vakken_update_preview')['keuzegroep_added'] as $key => $value)
                            <div class="text-primary fw-bold"><i class="fa-solid fa-link"></i> {{ \App\Models\Vak::find($key)->naam }} koppelen aan {{ \App\Models\Vak::find($value)->naam }}</div>
                            <input type="hidden" name="keuzegroep_added[{{ $key }}]" value="{{ $value }}">
                        @endforeach
                        @foreach (session('vakken_update_preview')['keuzegroep_removed'] as $key => $value)
                            <div class="text-primary fw-bold"><i class="fa-solid fa-unlink"></i> {{ \App\Models\VakInUitvoer::find($value)->parent->naam }} niet meer gekoppeld aan een ander vak.</div>
                            <input type="hidden" name="keuzegroep_removed[{{ $key }}]" value="{{ $value }}">
                        @endforeach
                        <hr class="my-3">
                        Wil je deze wijzigingen <strong>ook toepassen</strong> op de volgende niet-gestarte uitvoeren van dit blok?
                        <input type="hidden" name="uitvoeren[]" value="{{ $uitvoer->id }}">
                        @foreach(\App\Models\Uitvoer::where('blok_id', $uitvoer->blok_id)->whereDate('datum_start', '>', date('Y-m-d'))->where('id', '<>', $uitvoer->id)->orderBy('datum_start')->get() as $u)
                            <div>
                                <input type="checkbox" name="uitvoeren[]" value="{{ $u->id }}" id="uitvoer_{{ $u->id }}" checked>
                                <label for="uitvoer_{{ $u->id }}">{{ $u->naam }}</label>
                            </div>
                        @endforeach
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuleren</button>
                        <button type="submit" class="btn btn-success">
                            <i class="fa-regular fa-floppy-disk fa-fw"></i>
                            Opslaan
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <script>
            window.addEventListener('load', function (){
                new bootstrap.Modal('#linkVakPreviewModal').show();
            });
        </script>
    @endif

    @if(session('link_module_preview'))
        <div class="modal fade" id="linkModulePreviewModal" tabindex="-1" role="dialog" aria-labelledby="linkModulePreviewModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-fullscreen-md-down" role="document">
                <form class="modal-content" method="POST" action="{{ route('uitvoeren.link.module', $uitvoer) }}">
                    @csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="linkModulePreviewModalLabel">Module toevoegen</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click.prevent="clearItem()"></button>
                    </div>
                    <div class="modal-body">
                        Je gaat de volgende wijzigingen toepassen op <strong>{{ $uitvoer->naam }}</strong>:
                        <div class="text-success fw-bold">
                            <i class="fa-solid fa-plus"></i>
                            {{ \App\Models\Module::find(session('link_module_preview')['module_id'])->naam }}
                            <span class="fw-normal">bij</span>
                            {{ \App\Models\VakInUitvoer::find(session('link_module_preview')['vak_id'])->parent->naam }}
                            <span class="fw-normal">in week</span>
                            {{ session('link_module_preview')['week_start'] }}
                            <span class="fw-normal">t/m</span>
                            {{ session('link_module_preview')['week_eind'] }}

                            <input type="hidden" name="vak_id" value="{{ session('link_module_preview')['vak_id'] }}">
                            <input type="hidden" name="module_id" value="{{ session('link_module_preview')['module_id'] }}">
                            <input type="hidden" name="week_start" value="{{ session('link_module_preview')['week_start'] }}">
                            <input type="hidden" name="week_eind" value="{{ session('link_module_preview')['week_eind'] }}">
                        </div>
                        <hr class="my-3">
                        Wil je deze wijzigingen <strong>ook toepassen</strong> op de volgende niet-gestarte uitvoeren van dit blok?
                        <input type="hidden" name="uitvoeren[]" value="{{ $uitvoer->id }}">
                        @foreach(\App\Models\Uitvoer::where('blok_id', $uitvoer->blok_id)->whereDate('datum_start', '>', date('Y-m-d'))->where('id', '<>', $uitvoer->id)->orderBy('datum_start')->get() as $u)
                            <div>
                                <input type="checkbox" name="uitvoeren[]" value="{{ $u->id }}" id="uitvoer_{{ $u->id }}" checked>
                                <label for="uitvoer_{{ $u->id }}">{{ $u->naam }}</label>
                            </div>
                        @endforeach
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuleren</button>
                        <button type="submit" class="btn btn-success">
                            <i class="fa-regular fa-floppy-disk fa-fw"></i>
                            Opslaan
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <script>
            window.addEventListener('load', function (){
                new bootstrap.Modal('#linkModulePreviewModal').show();
            });
        </script>
    @endif

    @if(session('edit_points_preview'))
        <div class="modal fade" id="editStudiepuntenBlokPreviewModal" tabindex="-1" role="dialog" aria-labelledby="editStudiepuntenBlokPreviewModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-fullscreen-md-down" role="document">
                <form class="modal-content" method="POST" action="{{ route('uitvoeren.edit.points', $uitvoer) }}">
                    @csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="editStudiepuntenBlokPreviewModalLabel">Studiepunten aanpassen</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click.prevent="clearItem()"></button>
                    </div>
                    <div class="modal-body">
                        Je gaat de volgende wijzigingen toepassen op <strong>{{ $uitvoer->naam }}</strong>:
                        <div class="text-primary"><i class="fa-regular fa-edit fa-fw"></i>Van <strong>{{ $uitvoer->points }}</strong> <i class="fa-solid fa-arrow-right-long"></i> <strong>{{ session('edit_points_preview')['points'] }}</strong> studiepunten voor het gehele blok.</div>
                        <input type="hidden" name="points" value="{{ session('edit_points_preview')['points'] }}" />
                        <hr class="my-3">
                        Wil je deze wijzigingen <strong>ook toepassen</strong> op de volgende niet-gestarte uitvoeren van dit blok?
                        <input type="hidden" name="uitvoeren[]" value="{{ $uitvoer->id }}">
                        @foreach(\App\Models\Uitvoer::where('blok_id', $uitvoer->blok_id)->whereDate('datum_start', '>', date('Y-m-d'))->where('id', '<>', $uitvoer->id)->orderBy('datum_start')->get() as $u)
                            <div>
                                <input type="checkbox" name="uitvoeren[]" value="{{ $u->id }}" id="uitvoer_{{ $u->id }}" checked>
                                <label for="uitvoer_{{ $u->id }}">{{ $u->naam }}</label>
                            </div>
                        @endforeach
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuleren</button>
                        <button type="submit" class="btn btn-success">
                            <i class="fa-regular fa-floppy-disk fa-fw"></i>
                            Opslaan
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <script>
            window.addEventListener('load', function (){
                new bootstrap.Modal('#editStudiepuntenBlokPreviewModal').show();
            });
        </script>
    @endif

    <div class="modal fade" id="editWeeksModal" tabindex="-1" role="dialog" aria-labelledby="editWeeksModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-fullscreen-md-down" role="document">
            <form class="modal-content" method="POST" action="{{ route('uitvoeren.edit.weeks.preview', $uitvoer) }}">
                @csrf
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editWeeksModalLabel">Aanpassen {{ $uitvoer->naam }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click.prevent="clearItem()"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="weeks">Aantal weken *:</label>
                        <input type="number" class="form-control" id="weeks" name="weeks" value="{{ $uitvoer->weeks }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuleren</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fa-regular fa-floppy-disk fa-fw"></i>
                        Opslaan
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if(session('edit_weeks_preview'))
        <div class="modal fade" id="editWeeksPreviewModal" tabindex="-1" role="dialog" aria-labelledby="editWeeksPreviewModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-fullscreen-md-down" role="document">
                <form class="modal-content" method="POST" action="{{ route('uitvoeren.edit.weeks', $uitvoer) }}">
                    @csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="editWeeksPreviewModalLabel">Weken aanpassen</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click.prevent="clearItem()"></button>
                    </div>
                    <div class="modal-body">
                        Je gaat de volgende wijzigingen toepassen op <strong>{{ $uitvoer->naam }}</strong>:
                        <div class="text-primary"><i class="fa-regular fa-edit fa-fw"></i>Van <strong>{{ $uitvoer->weeks }}</strong> <i class="fa-solid fa-arrow-right-long"></i> <strong>{{ session('edit_weeks_preview')['weeks'] }}</strong> weken.</div>
                        <input type="hidden" name="weeks" value="{{ session('edit_weeks_preview')['weeks'] }}" />
                        <hr class="my-3">
                        Wil je deze wijzigingen <strong>ook toepassen</strong> op de volgende niet-gestarte uitvoeren van dit blok?
                        <input type="hidden" name="uitvoeren[]" value="{{ $uitvoer->id }}">
                        @foreach(\App\Models\Uitvoer::where('blok_id', $uitvoer->blok_id)->whereDate('datum_start', '>', date('Y-m-d'))->where('id', '<>', $uitvoer->id)->orderBy('datum_start')->get() as $u)
                            <div>
                                <input type="checkbox" name="uitvoeren[]" value="{{ $u->id }}" id="uitvoer_{{ $u->id }}" checked>
                                <label for="uitvoer_{{ $u->id }}">{{ $u->naam }}</label>
                            </div>
                        @endforeach
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuleren</button>
                        <button type="submit" class="btn btn-success">
                            <i class="fa-regular fa-floppy-disk fa-fw"></i>
                            Opslaan
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <script>
            window.addEventListener('load', function (){
                new bootstrap.Modal('#editWeeksPreviewModal').show();
            });
        </script>
    @endif

@endsection