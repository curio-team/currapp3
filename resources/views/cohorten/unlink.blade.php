<div wire:ignore.self class="modal fade" id="unlinkModal" tabindex="-1" aria-labelledby="unlinkModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-md-down" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="unlinkModalLabel">Weet je het zeker?</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click.prevent="clearItem()"></button>
            </div>
            <div class="modal-body">
                    <p>Je gaat het blok <strong>{{ optional($item->blok)->naam }}</strong> ontkoppelen van cohort <strong>{{ $cohort->naam }}</strong>.</p>
                    <p>Wil je alleen ontkoppelen, of wil de hele uitvoer verwijderen? De uitvoer verwijderen zal ook koppelingen met modules, comments, enzovoort verwijderen! Je kunt dit niet ongedaan maken.</p>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-outline-danger" wire:click.prevent="destroy()">
                    <span class="d-none spinner-border spinner-border-sm" role="status" aria-hidden="true" wire:loading.class.remove="d-none" wire:target="destroy"></span>
                    <i class="fa-regular fa-trash-can fa-fw" wire:loading.class="d-none" wire:target="destroy"></i>
                    Verwijderen
                </button>
                <div>
                    <button type="button" class="btn btn-light"  data-bs-dismiss="modal" wire:click.prevent="clearItem()">Annuleren</button>
                    <button type="button" class="btn btn-secondary" wire:click.prevent="unlink()">
                        <span class="d-none spinner-border spinner-border-sm" role="status" aria-hidden="true" wire:loading.class.remove="d-none" wire:target="unlink"></span>
                        <i class="fa-solid fa-unlink fa-fw" wire:loading.class="d-none" wire:target="unlink"></i>
                        Ontkoppelen
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>