<div wire:ignore.self class="modal fade" id="linkModal" tabindex="-1" role="dialog" aria-labelledby="linkModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-md-down" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="linkModalLabel">Nieuw blok koppelen</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click.prevent="clearItem()"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="blok_id">Blok *:</label>
                        <select class="form-select" name="blok_id" id="blok_id" wire:model="item.blok_id" required>
                            <option />
                            @foreach ($blokken as $blok)
                                <option value="{{ $blok->id }}">{{ $blok->naam }}</option>
                            @endforeach
                        </select>
                        @error('item.blok_id') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                    <p><em>Wanneer wordt dit blok uitgevoerd binnen</em> {{ $cohort->naam }}<em>? <strong>Tip:</strong> wanneer je een bestaande combinatie invoert, dan wordt die bestaande uitvoer gekoppeld. Iedere uitvoer bestaat namelijk maar één keer.</em></p>
                    <hr class="my-3">
                    <div class="mb-3">
                        <label for="schooljaar">Uitgevoerd in schooljaar... *</label>
                        <select class="form-select" id="schooljaar" name="schooljaar" wire:model="item.schooljaar" required>
                            <option />
                            @for($i = 2020; $i < date('Y')+10; $i++)
                                <option value="{{ $i }}">{{ substr($i, 2, 2) }}/{{ substr($i+1, 2, 2) }}</option>
                            @endfor
                        </select>
                        @error('item.schooljaar') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="blok_in_schooljaar">Als hoeveelste blok in het schooljaar? *</label>
                        <select class="form-select" id="blok_in_schooljaar" name="blok_in_schooljaar" required wire:model="item.blok_in_schooljaar">
                            <option />
                            @for($i = 1; $i <= $opleiding->blokken_per_jaar; $i++)
                                <option value="{{ $i }}">{{ $i }}e</option>
                            @endfor
                        </select>
                        @error('item.blok_in_schooljaar') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light"   data-bs-dismiss="modal" wire:click.prevent="clearItem()">Annuleren</button>
                <button type="button" class="btn btn-success" wire:click.prevent="link()">
                    <span class="d-none spinner-border spinner-border-sm" role="status" aria-hidden="true" wire:loading.class.remove="d-none" wire:target="link"></span>
                    <i class="fa-regular fa-floppy-disk fa-fw" wire:loading.class="d-none" wire:target="link"></i>
                    Opslaan
                </button>
            </div>
        </div>
    </div>
</div>