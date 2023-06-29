<div wire:ignore.self class="modal fade" id="editStudiepuntenVakModal" tabindex="-1" role="dialog" aria-labelledby="editStudiepuntenVakModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable modal-fullscreen-md-down" role="document">
        @if($vak_voor_punten)
            @include('uitvoeren.studiepuntenplan', ['mode' => 'modal'])
        @endif
    </div>
</div>

<div wire:ignore.self class="modal fade" id="editStudiepuntenVakPreviewModal" tabindex="-1" role="dialog" aria-labelledby="editStudiepuntenVakPreviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-fullscreen-md-down" role="document">
        <form class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editStudiepuntenVakPreviewModalLabel">Studiepunten aanpassen</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click.prevent="clearItem()"></button>
            </div>
            <div class="modal-body">
                Je gaat de volgende wijzigingen toepassen op <strong>{{ $uitvoer->naam }}</strong>:
                <div class="text-primary"><i class="fa-regular fa-edit fa-fw"></i>Totaal <strong>{{ optional($vak_voor_punten)->points }}</strong> studiepunten voor het vak <strong>{{ optional(optional($vak_voor_punten)->parent)->naam }}</strong>.</div>
                <hr class="my-3">
                Wil je deze wijzigingen <strong>ook toepassen</strong> op de volgende niet-gestarte uitvoeren van dit blok?
                <input type="hidden" wire:model="uitvoeren.0" value="{{ $uitvoer->id }}">
                @foreach(\App\Models\Uitvoer::where('blok_id', $uitvoer->blok_id)->whereDate('datum_start', '>', date('Y-m-d'))->where('id', '<>', $uitvoer->id)->orderBy('datum_start')->get() as $u)
                    <div>
                        <input type="checkbox" wire:model="uitvoeren.{{ $loop->iteration }}" value="{{ $u->id }}" id="uitvoer_{{ $u->id }}" checked>
                        <label for="uitvoer_{{ $u->id }}">{{ $u->naam }}</label>
                    </div>
                @endforeach
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light"   data-bs-dismiss="modal" wire:click.prevent="clearItem()">Annuleren</button>
                <button type="button" class="btn btn-primary" wire:click.prevent="editStudiepuntenVak()">
                    <span class="d-none spinner-border spinner-border-sm" role="status" aria-hidden="true" wire:loading.class.remove="d-none" wire:target="editStudiepuntenVak"></span>
                    <i class="fa-solid fa-edit fa-fw" wire:loading.class="d-none" wire:target="editStudiepuntenVak"></i>
                    Aanpassen
                </button>
            </div>
        </form>
    </div>
</div>