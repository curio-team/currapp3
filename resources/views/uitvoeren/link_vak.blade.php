<div class="modal fade" id="linkVakModal" tabindex="-1" role="dialog" aria-labelledby="linkVakModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-fullscreen-md-down" role="document">
        <form class="modal-content" method="POST" action="{{ route('uitvoeren.link.vak', $uitvoer) }}">
            @csrf
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="linkVakModalLabel">Vakken aanpassen</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click.prevent="clearItem()"></button>
            </div>
            <div class="modal-body">
                @foreach ($opleiding->vakken as $vak)
                    <div>
                        <input type="checkbox" name="vakken[]" value="{{ $vak->id }}" id="vak_{{ $vak->id }}" @if($uitvoer->vakken->contains('vak_id', $vak->id)) checked @endif>
                        <label for="vak_{{ $vak->id }}">
                            <span style="display: inline-block; min-width: 50px;">{{ $vak->naam }}</span>
                            {{ $vak->omschrijving }}
                        </label>
                    </div>
                @endforeach
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuleren</button>
                <button type="submit" class="btn btn-success">
                    <i class="fa-regular fa-floppy-disk fa-fw"></i>
                    Opslaan
                </button>
            </div>
        </form>
    </div>
</div>