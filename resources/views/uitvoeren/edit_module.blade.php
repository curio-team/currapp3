<div wire:ignore.self class="modal fade" id="editModuleModal" tabindex="-1" role="dialog" aria-labelledby="editModuleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-md-down" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editModuleModalLabel">Module aanpassen</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click.prevent="clearItem()"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <strong>{{ optional($item->parent)->naam }}</strong> in <strong>{{ $uitvoer->naam }}</strong>
                    </div>
                    <div class="mb-3">
                        <label for="versie_id">Versie *:</label>
                        <select id="versie_id" wire:model="versie_id" class="form-select">
                            @foreach (optional($item->parent)->versies ?? [] as $versie)
                                <option value="{{ $versie->id }}">{{ $versie->naam }}</option>
                            @endforeach
                        </select>
                        @error('versie_id') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="module_id">Weken *:</label>
                        <div class="input-group">
                            <span class="input-group-text">Week start:</span>
                            <input type="number" wire:model="item.pivot.week_start" class="form-control" required>
                            <span class="input-group-text">Week eind:</span>
                            <input type="number" wire:model="item.pivot.week_eind" class="form-control" required>
                        </div>
                    </div>
                    <input type="hidden" wire:model="item.pivot.vak_in_uitvoer_id">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light"   data-bs-dismiss="modal" wire:click.prevent="clearItem()">Annuleren</button>
                <button type="button" class="btn btn-success" wire:click.prevent="editModule()">
                    <span class="d-none spinner-border spinner-border-sm" role="status" aria-hidden="true" wire:loading.class.remove="d-none" wire:target="editModule"></span>
                    <i class="fa-regular fa-floppy-disk fa-fw" wire:loading.class="d-none" wire:target="editModule"></i>
                    Opslaan
                </button>
                <input type="hidden" name="id" wire:model="item.id">
            </div>
        </div>
    </div>
</div>