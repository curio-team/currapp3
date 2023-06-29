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
                    @if($action == 'create')
                        <div class="mb-3">
                            <label for="leerlijn_id">Leerlijn *:</label>
                            <select class="form-select" id="leerlijn_id" name="leerlijn_id" wire:model="item.leerlijn_id" required>
                                <option></option>
                                @foreach($opleiding->leerlijnen as $leerlijn)
                                    <option value="{{ $leerlijn->id }}">{{ $leerlijn->naam }}</option>
                                @endforeach
                            </select>
                            @error('item.leerlijn_id') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                    @endif
                    <div class="mb-3">
                        <label for="naam">Naam *:</label>
                        <input type="text" class="form-control" id="naam" name="naam" wire:model="item.naam" required>
                        @error('item.naam') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="omschrijving">Omschrijving *:</label>
                        <input type="text" class="form-control" id="omschrijving" name="omschrijving" wire:model="item.omschrijving" required>
                        @error('item.omschrijving') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                    @if($action == 'create')
                        <div class="mb-3">
                            <label for="versie">Laatste versie *:</label>
                            <div class="input-group">
                                <span class="input-group-text">v</span>
                                <input type="number" class="form-control" id="versie" name="versie" wire:model="item.versie" required>
                                <span class="input-group-text">.X</span>
                            </div>
                            @error('item.versie') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                    @endif
                    <div class="mb-3">
                        <label for="map_url">Link naar map:</label>
                        <input type="text" class="form-control" id="map_url" name="map_url" wire:model="item.map_url">
                        @error('item.map_url') <span class="text-danger error">{{ $message }}</span>@enderror
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