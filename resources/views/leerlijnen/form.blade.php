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
                        <label for="naam">Afkorting <span class="text-muted">(korte naam)</span>*:</label>
                        <input type="text" class="form-control" id="naam" name="naam" wire:model="item.naam" required>
                        @error('item.naam') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="eigenaar_id">Eigenaar:</label>
                        <input type="text" class="form-control" id="eigenaar_id" name="eigenaar_id" wire:model="item.eigenaar_id" placeholder="ab01">
                        @error('item.eigenaar_id') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="color">Kleur</span>:</label>
                        <input type="color" class="form-control" id="color" name="color" wire:model="item.color">
                        @error('item.color') <span class="text-danger error">{{ $message }}</span>@enderror
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