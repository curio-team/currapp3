<div wire:ignore.self class="modal fade" id="unlinkModuleModal" tabindex="-1" role="dialog" aria-labelledby="unlinkModuleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-md-down" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="unlinkModuleModalLabel">Weet je het zeker?</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click.prevent="clearItem()"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        Je gaat module <strong>{{ optional($item->parent)->naam }}</strong> verwijderen uit <strong>{{ $uitvoer->naam }}</strong>. De module blijft bestaan, maar is niet meer gekoppeld aan deze uitvoer.
                    </div>
                    <input type="hidden" wire:model="item.pivot.vak_in_uitvoer_id">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light"   data-bs-dismiss="modal" wire:click.prevent="clearItem()">Annuleren</button>
                <button type="button" class="btn btn-primary" wire:click.prevent="unlinkModule()">
                    <span class="d-none spinner-border spinner-border-sm" role="status" aria-hidden="true" wire:loading.class.remove="d-none" wire:target="unlinkModule"></span>
                    <i class="fa-solid fa-unlink fa-fw" wire:loading.class="d-none" wire:target="unlinkModule"></i>
                    Ontkoppelen
                </button>
                <input type="hidden" name="id" wire:model="item.id">
            </div>
        </div>
    </div>
</div>