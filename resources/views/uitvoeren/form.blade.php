<div wire:ignore.self class="modal fade" id="{{ $action }}Modal" tabindex="-1" role="dialog" aria-labelledby="{{ $action }}ModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-md-down" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="{{ $action }}ModalLabel">
                @if($action == 'update')
                    Aanpassen
                @else
                    Nieuw (handmatig inrichten)
                @endif
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click.prevent="clearItem()"></button>
            </div>
            <div class="modal-body">
                <p>
                    Let op, dit formulier is enkel toegevoegd om fouten in automatisch geselecteerde eind datums te kunnen corrigeren.
                    <strong>Gebruik deze functionaliteit met mate!</strong>
                    - tl10
                </p>
                <form>
                    <div class="mb-3">
                        <label for="datum_start">Startdatum *:</label>
                        <input type="text" placeholder="yyyy-mm-dd" class="form-control" id="datum_start" name="datum_start" wire:model.defer="item.datum_start" required>
                        @error('item.datum_start') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="datum_eind">Einddatum *:</label>
                        <input type="text" placeholder="yyyy-mm-dd" class="form-control" id="datum_eind" name="datum_eind" wire:model.defer="item.datum_eind" required>
                        @error('item.datum_eind') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                    {{-- <div class="mb-3">
                        <label for="schooljaar">Schooljaar *:</label>
                        <input type="number" class="form-control" id="schooljaar" name="schooljaar" wire:model="item.schooljaar" required>
                        @error('item.schooljaar') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="blok_in_schooljaar">Blok in schooljaar *:</label>
                        <input type="number" class="form-control" id="blok_in_schooljaar" name="blok_in_schooljaar" wire:model="item.blok_in_schooljaar" required>
                        @error('item.blok_in_schooljaar') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="points">Punten *:</label>
                        <input type="number" class="form-control" id="points" name="points" wire:model="item.points" required>
                        @error('item.points') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div> --}}
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal" wire:click.prevent="clearItem()">Annuleren</button>
                <button type="button" class="btn btn-success" wire:click.prevent="{{ $action }}()">
                    <span class="d-none spinner-border spinner-border-sm" role="status" aria-hidden="true" wire:loading.class.remove="d-none" wire:target="{{ $action }}"></span>
                    <i class="fa-regular fa-floppy-disk fa-fw" wire:loading.class="d-none" wire:target="{{ $action }}"></i>
                    Opslaan
                </button>
                <input type="hidden" name="id" wire:model="item.id">
            </div>
        </div>
    </div>
</div>
