<div class="leerplan" style="display: grid; grid-template-columns: auto repeat({{ $uitvoer->vakken->count() }}, 1fr) auto; column-gap: 1rem;">
    @for ($i = 1; $i <= 16; $i++)
        <div class="d-flex justify-content-center align-items-center" style="grid-column: 1; grid-row: {{ $i+1 }}; text-align: center;"><em>{{ $i }}</em></div>
        <div class="d-flex justify-content-center align-items-center" style="grid-column: {{ $uitvoer->vakken->count()+2 }}; grid-row: {{ $i+1 }}; text-align: center;"><em>{{ $i }}</em></div>
    @endfor
    
    @foreach($uitvoer->vakken as $vak)
        <div style="grid-column: {{ $loop->iteration+1 }}; grid-row: 1; text-align: center;"><strong>{{ $vak->parent->naam }}</strong></div>
        @foreach ($vak->modules as $module)
            <div class="position-relative module p-2 text-center hover-show" style="background-color: {{ $module->parent->leerlijn->color }}; color: {{ $module->parent->leerlijn->textcolor }}; grid-column: {{ $loop->parent->iteration+1 }}; grid-row: {{ $module->pivot->week_start+1 }} / {{ $module->pivot->week_eind+2 }};">
                <div class="module-titel">{{ $module->parent->naam }}</div>
                <div class="fw-light hover-hide">{{ $module->naam }}</div>
                <div class="d-print-none btn-group btn-group position-absolute top-50 left-50 translate-middle shadow" style="background-color: {{ $module->parent->leerlijn->color }};">
                    <button class="btn btn-outline-{{ $module->parent->leerlijn->textcolor }}"><i class="fa-regular fa-comments fa-fw"></i></button>
                    <button class="btn btn-outline-{{ $module->parent->leerlijn->textcolor }}" data-bs-toggle="modal" data-bs-target="#editModuleModal" wire:click="setVersieItem({{ $module->id }}, {{ $vak->id }})"><i class="fa-regular fa-edit fa-fw"></i></button>
                    <button class="btn btn-outline-{{ $module->parent->leerlijn->textcolor }}" data-bs-toggle="modal" data-bs-target="#unlinkModuleModal" wire:click="setVersieItem({{ $module->id }}, {{ $vak->id }})"><i class="fa-solid fa-unlink fa-fw"></i></button>
                </div>
            </div>
        @endforeach
    @endforeach

    <!-- Modals -->
    @include('uitvoeren.edit_module')
    @include('uitvoeren.unlink_module')

    <div wire:ignore.self class="modal fade" id="unlinkModulePreviewModal" tabindex="-1" role="dialog" aria-labelledby="unlinkModulePreviewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-fullscreen-md-down" role="document">
            <form class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="unlinkModulePreviewModalLabel">Module ontkoppelen</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click.prevent="clearItem()"></button>
                </div>
                <div class="modal-body">
                    Je gaat de volgende wijzigingen toepassen op <strong>{{ $uitvoer->naam }}</strong>:
                    <div class="text-danger fw-bold"><i class="fa-solid fa-minus"></i> {{ optional($item->parent)->naam }}</div>
                    <hr class="my-3">
                    Wil je deze wijzigingen <strong>ook toepassen</strong> op de volgende niet-gestarte uitvoeren van dit blok?
                    <input type="hidden" wire:model="uitvoeren.0" value="{{ $uitvoer->id }}">
                    @foreach(\App\Models\Uitvoer::where('blok_id', $uitvoer->blok_id)->whereDate('datum_start', '>', date('Y-m-d'))->where('id', '<>', $uitvoer->id)->orderBy('datum_start')->get() as $u)
                        <div>
                            <input type="checkbox" wire:model="uitvoeren.{{ $loop->iteration }}" value="{{ $u->id }}" id="uitvoer_{{ $u->id }}" checked>
                            <label for="uitvoer_{{ $u->id }}">{{ $u->naam }}</label>
                        </div>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light"   data-bs-dismiss="modal" wire:click.prevent="clearItem()">Annuleren</button>
                    <button type="button" class="btn btn-primary" wire:click.prevent="unlinkModule()">
                        <span class="d-none spinner-border spinner-border-sm" role="status" aria-hidden="true" wire:loading.class.remove="d-none" wire:target="unlinkModule"></span>
                        <i class="fa-solid fa-unlink fa-fw" wire:loading.class="d-none" wire:target="unlinkModule"></i>
                        Ontkoppelen
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:load', () => {
            Livewire.on('unlinkModulePreview', param => {
                new bootstrap.Modal('#unlinkModulePreviewModal').show();
            })
        })
    </script>
</div>