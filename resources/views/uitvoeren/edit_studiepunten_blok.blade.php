<div class="modal fade" id="editStudiepuntenBlokModal" tabindex="-1" role="dialog" aria-labelledby="editStudiepuntenBlokModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-fullscreen-md-down" role="document">
        <form class="modal-content" method="POST" action="{{ route('uitvoeren.edit.points.preview', $uitvoer) }}">
            @csrf
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editStudiepuntenBlokModalLabel">Studiepunten {{ $uitvoer->naam }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click.prevent="clearItem()"></button>
            </div>
            <div class="modal-body">
                @if($uitvoer->points == $uitvoer->vakken->sum('points'))
                    <i class="fa-solid fa-fw fa-check"></i>
                @else
                    <i class="fa-solid fa-fw fa-triangle-exclamation text-warning"></i>
                @endif
                {{ $uitvoer->vakken->sum('points') }} / {{ $uitvoer->points }} punten verdeeld over de vakken
                <div class="my-3">
                    <div class="input-group">
                        <span class="input-group-text">Totaal punten:</span>
                        <input type="number" class="form-control" name="points" value="{{ $uitvoer->points }}" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuleren</button>
                <a class="btn btn-primary" target="_blank" href="{{ route('studiepuntenplan.uitvoer.show', $uitvoer) }}"><i class="fa-solid fa-print fa-fw"></i> Afdrukken studiepuntenplan</a>
                <button type="submit" class="btn btn-success">
                    <i class="fa-regular fa-floppy-disk fa-fw"></i>
                    Opslaan
                </button>
            </div>
        </form>
    </div>
</div>