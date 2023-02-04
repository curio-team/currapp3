<div wire:ignore.self class="modal fade" id="{{ $action }}Modal" tabindex="-1" role="dialog" aria-labelledby="{{ $action }}ModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-md-down" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="{{ $action }}ModalLabel">
                @if($action == 'update')
                    Aanpassen
                @else
                    Nieuw
                @endif
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click.prevent="clearItem()"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="datum_start">Startdatum *:</label>
                        <input type="text" placeholder="yyyy-mm-dd" class="form-control" id="datum_start" name="datum_start" wire:model="item.datum_start" required>
                        @error('item.datum_start') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="datum_eind">Einddatum *:</label>
                        <input type="text" placeholder="yyyy-mm-dd" class="form-control" id="datum_eind" name="datum_eind" required wire:model="item.datum_eind">
                        @error('item.datum_eind') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light"   data-bs-dismiss="modal" wire:click.prevent="clearItem()">Annuleren</button>
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