<div wire:ignore.self class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-md-down" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="deleteModalLabel">Weet je het zeker?</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click.prevent="clearItem()"></button>
            </div>
            <div class="modal-body">
                @if($item->versies->count())
                    <p>Je wil deze module verwijderen, maar de module bevat nog versies.</p>
                @else
                    <p>Je gaat de module <strong>{{ $item->naam }}</strong> verwijderen.</p>
                    <p>Deze module kent nog geen versies, dus je verwijdert alleen de module.</p>
                @endif                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light"  data-bs-dismiss="modal" wire:click.prevent="clearItem()">Annuleren</button>
                @unless($item->versies->count())
                    <button type="button" class="btn btn-danger" wire:click.prevent="destroy()">
                        <span class="d-none spinner-border spinner-border-sm" role="status" aria-hidden="true" wire:loading.class.remove="d-none" wire:target="destroy"></span>
                        <i class="fa-regular fa-trash-can fa-fw" wire:loading.class="d-none" wire:target="destroy"></i>
                        Verwijderen
                    </button>
                @endunless
            </div>
        </div>
    </div>
</div>