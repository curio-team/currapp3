<div wire:ignore.self class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-md-down" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="deleteModalLabel">Weet je het zeker?</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click.prevent="clearItem()"></button>
            </div>
            <div class="modal-body">
                @if($item->modules->count())
                    <p>Je wil de leerlijn <strong>{{ $item->naam }}</strong> verwijderen, maar deze bevat nog <strong>{{ $item->modules->count() }}</strong> modules.</p>
                @else
                    <p>Je gaat de leerlijn <strong>{{ $item->naam }}</strong> verwijderen.</p>
                    <p>Deze leerlijn bevat <em>geen</em> modules, je kunt deze dus verwijderen.</p>
                @endif                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light"  data-bs-dismiss="modal" wire:click.prevent="clearItem()">Annuleren</button>
                @unless($item->modules->count())
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