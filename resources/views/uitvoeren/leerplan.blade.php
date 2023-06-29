<div class="leerplan" style="display: grid; grid-template-columns: auto repeat({{ $uitvoer->vakken->sum('aantal_kolommen') }}, 1fr) auto; column-gap: 1rem;">
    @for ($i = 1; $i <= $uitvoer->weeks; $i++)
        <div class="d-flex justify-content-center align-items-center" style="grid-column: 1; grid-row: {{ $i+1 }}; text-align: center;"><em>{{ $i }}</em></div>
        <div class="d-flex justify-content-center align-items-center" style="grid-column: {{ $uitvoer->vakken->sum('aantal_kolommen')+2 }}; grid-row: {{ $i+1 }}; text-align: center;"><em>{{ $i }}</em></div>
    @endfor
    
    <?php $counter = 1; ?>
    @foreach($uitvoer->vakken as $vak)
        <div class="vak-header lh-1 mt-1 mb-2" style="grid-column: {{ $counter+1 }} / span {{ $vak->aantal_kolommen }}; grid-row: 1;">
            <?php $counter += $vak->aantal_kolommen; ?>
            <div class="vak-header-left">
                <strong>{{ $vak->parent->naam }}</strong><br>
                <small>
                    @if($vak->points != $vak->modules->sum('points') || $vak->modules->sum('aantal_feedbackmomenten') < 1 || $vak->modules->max('max_punten') > $uitvoer->points*0.10 || $vak->modules->sum('aantal_checks_niet_oke') > 0)
                        {{ $vak->modules->sum('points') }} / {{ $vak->points }}pts
                        <i class="fa-solid fa-fw fa-triangle-exclamation text-warning"></i>
                    @else
                        {{ $vak->points }}pts
                    @endif
                </small>
            </div>
            <div class="vak-header-right btn-group">
                <button class="btn btn-sm btn-outline-primary" onclick="prefillModal({{ $vak->id }})" data-bs-toggle="modal" data-bs-target="#linkModuleModal"><i class="fa-solid fa-plus fa-fw"></i> Module</button>
                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editStudiepuntenVakModal" wire:click="setVakItem({{ $vak }})">
                    <i class="fa-solid fa-eye fa-fw"></i> punten
                </button>
            </div>
        </div>
        {{-- {{ var_dump($vak->kolom_indeling) }} --}}
        @foreach ($vak->modules as $module)
            <div class="position-relative module p-2 text-center hover-show" style="background-color: {{ $module->parent->leerlijn->color }}; color: {{ $module->parent->leerlijn->textcolor }}; grid-column: {{ $counter - ($vak->kolom_indeling[$module->id]) }}; grid-row: {{ $module->pivot->week_start+1 }} / {{ $module->pivot->week_eind+2 }};">
                <div class="module-titel">{{ $module->parent->naam }}</div>
                <div class="fw-light hover-hide">{{ $module->naam }}</div>
                <div class="d-print-none btn-group btn-group-sm position-absolute top-50 left-50 translate-middle shadow" style="background-color: {{ $module->parent->leerlijn->color }};">
                    <button class="btn btn-outline-{{ $module->parent->leerlijn->textcolor }}"><i class="fa-regular fa-comments fa-fw"></i></button>
                    <button class="btn btn-outline-{{ $module->parent->leerlijn->textcolor }}" data-bs-toggle="modal" data-bs-target="#editModuleModal" wire:click="setVersieItem({{ $module->id }}, {{ $vak->id }})"><i class="fa-regular fa-edit fa-fw"></i></button>
                    <button class="btn btn-outline-{{ $module->parent->leerlijn->textcolor }}" data-bs-toggle="modal" data-bs-target="#unlinkModuleModal" wire:click="setVersieItem({{ $module->id }}, {{ $vak->id }})"><i class="fa-solid fa-unlink fa-fw"></i></button>
                    <a class="btn btn-outline-{{ $module->parent->leerlijn->textcolor }}" target="_blank" href="{{ route('opleidingen.modules.show.versie', [$opleiding, $module->parent, $module]) }}"><i class="fa-solid fa-eye fa-fw"></i></a>
                </div>
            </div>
        @endforeach
    @endforeach

    <!-- Modals -->
    @include('uitvoeren.edit_module')
    @include('uitvoeren.unlink_module')
    @include('uitvoeren.edit_studiepunten_vak')

    <script>
        document.addEventListener('livewire:load', () => {
            Livewire.on('unlinkModulePreview', param => {
                new bootstrap.Modal('#unlinkModulePreviewModal').show();
            })
        })

        document.addEventListener('livewire:load', () => {
            Livewire.on('editModulePreview', param => {
                new bootstrap.Modal('#editModulePreviewModal').show();
            })
        })

        document.addEventListener('livewire:load', () => {
            Livewire.on('editStudiepuntenVakPreview', param => {
                new bootstrap.Modal('#editStudiepuntenVakPreviewModal').show();
            })
        })

        function prefillModal(id)
        {
            document.querySelector(".modal-body #vak_id").value = id;
        };
    </script>
</div>