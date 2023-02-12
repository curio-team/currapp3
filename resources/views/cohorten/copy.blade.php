<div wire:ignore.self class="modal fade" id="copyModal" tabindex="-1" role="dialog" aria-labelledby="copyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-md-down" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="copyModalLabel">Nieuw (inrichting kopieëren)</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click.prevent="clearItem()"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="naam">Naam nieuwe cohort*:</label>
                        <input type="text" class="form-control" id="naam" name="naam" wire:model="item.naam" required>
                        @error('item.naam') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="kopieer_van">Kopieer inrichting van *:</label>
                        <select placeholder="yyyy-mm-dd" class="form-select" id="kopieer_van" name="kopieer_van" required wire:model="kopieer_van">
                            <option />
                            @foreach($opleiding->cohorten as $cohort)
                                <option value="{{ $cohort->id }}">{{ $cohort->naam }}</option>
                            @endforeach
                        </select>
                        @error('kopieer_van') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="kopieer_jaren">Kopieer aantal jaren later *:</label>
                        <input type="number" class="form-control" id="kopieer_jaren" name="kopieer_jaren" wire:model="kopieer_jaren" required>
                        <div class="form-text">Het nieuwe cohort start ... jaar na het cohort waarvan je kopieert.</div>
                        @error('kopieer_jaren') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="nieuwste_versie" wire:model="nieuwste_versie">
                            <label class="form-check-label" for="nieuwste_versie">Update gekoppelde modules automatisch naar laatste versie.</label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light"   data-bs-dismiss="modal" wire:click.prevent="clearItem()">Annuleren</button>
                <button type="button" class="btn btn-success" wire:click.prevent="copy()">
                    <span class="d-none spinner-border spinner-border-sm" role="status" aria-hidden="true" wire:loading.class.remove="d-none" wire:target="copy"></span>
                    <i class="fa-regular fa-floppy-disk fa-fw" wire:loading.class="d-none" wire:target="copy"></i>
                    Opslaan
                </button>
                <input type="hidden" name="id" wire:model="item.id">
            </div>
        </div>
    </div>
</div>