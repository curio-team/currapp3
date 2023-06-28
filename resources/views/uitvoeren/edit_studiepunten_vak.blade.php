<div wire:ignore.self class="modal fade" id="editStudiepuntenVakModal" tabindex="-1" role="dialog" aria-labelledby="editStudiepuntenVakModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-fullscreen-md-down" role="document">
        <form class="modal-content">
            @csrf
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editStudiepuntenVakModalLabel">Studiepunten {{ optional(optional($vak_voor_punten)->parent)->naam }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click.prevent="clearItem()"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text">Totaal punten:</span>
                        <input type="number" class="form-control" wire:model="vak_voor_punten.points" required>
                    </div>
                </div>
                <table class="table table-bordered">
                    <tr class="table-primary">
                        <th>Code</th>
                        <th>Onderwerp</th>
                        <th>Punten</th>
                        <th>Week</th>
                    </tr>
                    @if($vak_voor_punten)
                        @foreach ($vak_voor_punten->modules as $m)
                            <tr class="table-light">
                                <td colspan="4">{{ $m->parent->naam }}</td>
                            </tr>
                            @foreach ($m->feedbackmomenten as $fbm)
                                <tr>
                                    <td>{{ $fbm->code }}</td>
                                    <td>{{ $fbm->naam }}</td>
                                    <td>{{ $fbm->points }}</td>
                                    <td>{{ $fbm->pivot->week }}</td>
                                </tr>
                            @endforeach
                        @endforeach
                    @endif
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuleren</button>
                <button type="button" class="btn btn-success" wire:click.prevent="editStudiepuntenVakPreview()">
                    <span class="d-none spinner-border spinner-border-sm" role="status" aria-hidden="true" wire:loading.class.remove="d-none" wire:target="editStudiepuntenVak"></span>
                    <i class="fa-solid fa-save fa-fw" wire:loading.class="d-none" wire:target="editStudiepuntenVak"></i>
                    Opslaan
                </button>
            </div>
        </form>
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