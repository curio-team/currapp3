<div wire:ignore.self class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-md-down" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="deleteModalLabel">Weet je het zeker?</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click.prevent="clearItem()"></button>
            </div>
            <div class="modal-body">
                @if($item->uitvoeren->count())
                    <p>Je gaat het blok <strong>{{ $item->naam }}</strong> verwijderen. Dit blok kent <strong>{{ $item->uitvoeren->count() }}</strong> uitvoeren.</p>
                    <p>Je verwijdert <em>alle</em> uitvoeren inclusief de koppelingen met vakken en modules.</p>
                    <p>Je verwijdert ook alle aspecten, omdat de koppelingen met leerdoelen worden verbroken.</p>
                    <p>Tenslotte verwijder je alle comments op dit blok <em>en</em> op modules, zolang het comment bij een uitvoer van dit blok hoort.</p>
                @else
                    <p>Je gaat het blok <strong>{{ $item->naam }}</strong> verwijderen.</p>
                    <p>Dit blok kent <em>geen</em> uitvoeren, er  worden dus geen koppelingen verbroken.</p>
                @endif                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light"  data-bs-dismiss="modal" wire:click.prevent="clearItem()">Annuleren</button>
                <button type="button" class="btn btn-danger" wire:click.prevent="destroy()">
                    <span class="d-none spinner-border spinner-border-sm" role="status" aria-hidden="true" wire:loading.class.remove="d-none" wire:target="destroy"></span>
                    <i class="fa-regular fa-trash-can fa-fw" wire:loading.class="d-none" wire:target="destroy"></i>
                    Verwijderen
                </button>
            </div>
        </div>
    </div>
</div>