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
                <button type="button" class="btn btn-primary" wire:click.prevent="unlinkModulePreview()">
                    <span class="d-none spinner-border spinner-border-sm" role="status" aria-hidden="true" wire:loading.class.remove="d-none" wire:target="unlinkModule"></span>
                    <i class="fa-solid fa-unlink fa-fw" wire:loading.class="d-none" wire:target="unlinkModule"></i>
                    Ontkoppelen
                </button>
                <input type="hidden" name="id" wire:model="item.id">
            </div>
        </div>
    </div>
</div>


<div wire:ignore.self class="modal fade" id="unlinkModulePreviewModal" tabindex="-1" role="dialog" aria-labelledby="unlinkModulePreviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-fullscreen-md-down" role="document">
        <form class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="unlinkModulePreviewModalLabel">Module ontkoppelen</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click.prevent="clearItem()"></button>
            </div>
            <div class="modal-body">
                Je gaat de volgende wijzigingen toepassen op <strong>{{ $uitvoer->naam }}</strong>:
                <div class="text-danger fw-bold"><i class="fa-solid fa-minus"></i> {{ optional($item->parent)->naam }} verwijderen uit {{ $vaknaam }}</div>
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
                <button type="button" class="btn btn-primary" wire:click.prevent="unlinkModule()">
                    <span class="d-none spinner-border spinner-border-sm" role="status" aria-hidden="true" wire:loading.class.remove="d-none" wire:target="unlinkModule"></span>
                    <i class="fa-solid fa-unlink fa-fw" wire:loading.class="d-none" wire:target="unlinkModule"></i>
                    Ontkoppelen
                </button>
            </div>
        </form>
    </div>
</div>