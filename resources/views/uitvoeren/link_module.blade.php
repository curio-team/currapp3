<div class="modal fade" id="linkModuleModal" tabindex="-1" role="dialog" aria-labelledby="linkModuleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-md-down" role="document">
        <form class="modal-content" method="POST" action="{{ route('uitvoeren.link.module.preview', $uitvoer) }}">
            @csrf
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="linkModuleModalLabel">Nieuwe module koppelen</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="vak_id">Vak *:</label>
                    <select class="form-select" name="vak_id" id="vak_id" required>
                        <option />
                        @foreach ($uitvoer->vakken as $vak)
                            <option value="{{ $vak->id }}">{{ $vak->parent->naam }} {{ $vak->parent->omschrijving }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="module_id">Module *:</label>
                    <select class="form-select" name="module_id" id="module_id" required>
                        <option />
                        @foreach ($opleiding->modules as $module)
                            <option value="{{ $module->id }}">{{ $module->naam }} {{ $module->omschrijving }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="module_id">Weken *:</label>
                    <div class="input-group">
                        <span class="input-group-text">Week start:</span>
                        <input type="number" name="week_start" class="form-control" required>
                        <span class="input-group-text">Week eind:</span>
                        <input type="number" name="week_eind" class="form-control" required>
                    </div>
                </div>
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