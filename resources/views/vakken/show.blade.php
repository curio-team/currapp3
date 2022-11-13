<div wire:ignore.self class="modal fade" id="showModal" tabindex="-1" role="dialog" aria-labelledby="showModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="showModalLabel">{{ $vak->naam }} <span class="text-muted">{{ $vak->omschrijving }}</span></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click.prevent="clearVak()"></button>
            </div>
            <div class="modal-body">
                <p>Dit vak wordt uitgevoerd in:</p>
                <ul>
                    @forelse ($vak->uitvoeren->sortBy('uitvoer.datum_start') as $uitvoer)
                        <li>{{ $uitvoer->uitvoer->naam }}</li>
                    @empty
                        <li><em>(geen uitvoeren gekoppeld)</em></li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>