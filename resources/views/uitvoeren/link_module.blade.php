<div class="modal fade" id="linkModuleModal" tabindex="-1" role="dialog" aria-labelledby="linkModuleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-md-down" role="document">
        <form class="modal-content" method="POST" action="{{ route('uitvoeren.link.module', $uitvoer) }}">
            @csrf
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="linkModuleModalLabel">Nieuwe module koppelen</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click.prevent="clearItem()"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="vak_id">Vak *:</label>
                    <select class="form-select" name="vak_id" id="vak_id" required>
                        <option />
                        @foreach ($uitvoer->vakken as $vak)
                            <option value="{{ $vak->id }}">{{ $vak->parent->naam }} {{ $vak->parent->omschrijving }}</option>
                        @endforeach
                    </select>
                    @error('item.vak_id') <span class="text-danger error">{{ $message }}</span>@enderror
                </div>
                <div class="mb-3">
                    <label for="module_id">Module *:</label>
                    <select class="form-select" name="module_id" id="module_id" required>
                        <option />
                        @foreach ($opleiding->modules as $module)
                            <option value="{{ $module->id }}">{{ $module->naam }} {{ $module->omschrijving }}</option>
                        @endforeach
                    </select>
                    @error('item.module_id') <span class="text-danger error">{{ $message }}</span>@enderror
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