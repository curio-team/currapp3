@extends('layouts.app')

@section('container-class', 'container-fluid')

@section('subnav')
    <nav class="navbar navbar-dark bg-secondary subnav">
        <div class="container-fluid">
            <div class="navbar-brand">{{ $uitvoer->naam }}</div>
            <div class="d-print-none btn-group">
                <button class="btn btn-outline-light"><i class="fa-regular fa-comments fa-fw"></i> Comments</button>
                <button class="btn btn-outline-light" data-bs-toggle="modal" data-bs-target="#linkModuleModal"><i class="fa-solid fa-plus fa-fw"></i> Module</button>
                <button class="btn btn-outline-light" data-bs-toggle="modal" data-bs-target="#linkVakModal"><i class="fa-regular fa-edit fa-fw"></i> Vakken</button>
            </div>
        </div>
    </nav>
@endsection

@section('main')

    @livewire('leerplan', ['opleiding' => $opleiding, 'uitvoer' => $uitvoer])

    <!-- Modals -->
    @include('uitvoeren.link_module')
    @include('uitvoeren.link_vak')

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

@endsection