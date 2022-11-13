<div wire:ignore.self class="modal fade" id="{{ $action }}Modal" tabindex="-1" role="dialog" aria-labelledby="{{ $action }}ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="{{ $action }}ModalLabel">Nieuw</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click.prevent="clearVak()"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="naam">Afkorting <span class="text-muted">(korte naam)</span>*:</label>
                        <input type="text" class="form-control" id="naam" name="naam" wire:model="vak.naam" required>
                        @error('vak.naam') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="omschrijving">Omschrijving <span class="text-muted">(lange naam)</span>:</label>
                        <input type="text" class="form-control" id="omschrijving" name="omschrijving" wire:model="vak.omschrijving">
                        @error('vak.omschrijving') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="omschrijving">Volgorde *:</label>
                        <input type="number" class="form-control" id="volgorde" name="volgorde" required wire:model="vak.volgorde">
                        @error('vak.volgorde') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light"   data-bs-dismiss="modal" wire:click.prevent="clearVak()">Annuleren</button>
                <button type="button" class="btn btn-success" wire:click.prevent="{{ $action }}()">
                    <span class="d-none spinner-border spinner-border-sm" role="status" aria-hidden="true" wire:loading.class.remove="d-none" wire:target="{{ $action }}"></span>
                    <i class="fa-regular fa-floppy-disk fa-fw" wire:loading.class="d-none" wire:target="{{ $action }}"></i>
                    Opslaan
                </button>
                <input type="hidden" name="id" wire:model="vak.id">
            </div>
        </div>
    </div>
</div>