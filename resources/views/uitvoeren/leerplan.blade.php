<div class="leerplan" style="display: grid; grid-template-columns: auto repeat({{ $uitvoer->vakken->count() }}, 1fr) auto; column-gap: 1rem;">
    @for ($i = 1; $i <= 16; $i++)
        <div class="d-flex justify-content-center align-items-center" style="grid-column: 1; grid-row: {{ $i+1 }}; text-align: center;"><em>{{ $i }}</em></div>
        <div class="d-flex justify-content-center align-items-center" style="grid-column: {{ $uitvoer->vakken->count()+2 }}; grid-row: {{ $i+1 }}; text-align: center;"><em>{{ $i }}</em></div>
    @endfor
    
    @foreach($uitvoer->vakken as $vak)
        <div style="grid-column: {{ $loop->iteration+1 }}; grid-row: 1; text-align: center;"><strong>{{ $vak->parent->naam }}</strong></div>
        @foreach ($vak->modules as $module)
            <div class="position-relative module p-2 text-center hover-show" style="background-color: {{ $module->parent->leerlijn->color }}; color: {{ $module->parent->leerlijn->textcolor }}; grid-column: {{ $loop->parent->iteration+1 }}; grid-row: {{ $module->pivot->week_start+1 }} / {{ $module->pivot->week_eind+2 }};">
                <div class="module-titel">{{ $module->parent->naam }} {{ $module->naam }}</div>
                <div class="d-print-none btn-group btn-group position-absolute top-50 left-50 translate-middle shadow" style="background-color: {{ $module->parent->leerlijn->color }};">
                    <button class="btn btn-outline-{{ $module->parent->leerlijn->textcolor }}"><i class="fa-regular fa-comments fa-fw"></i></button>
                    <button class="btn btn-outline-{{ $module->parent->leerlijn->textcolor }}" data-bs-toggle="modal" data-bs-target="#editModuleModal" wire:click="setVersieItem({{ $module->id }}, {{ $vak->id }})"><i class="fa-regular fa-edit fa-fw"></i></button>
                    <button class="btn btn-outline-{{ $module->parent->leerlijn->textcolor }}" data-bs-toggle="modal" data-bs-target="#unlinkModuleModal" wire:click="setVersieItem({{ $module->id }}, {{ $vak->id }})"><i class="fa-solid fa-unlink fa-fw"></i></button>
                </div>
            </div>
        @endforeach
    @endforeach

    <!-- Modals -->
    @include('uitvoeren.edit_module')
    @include('uitvoeren.unlink_module')
</div>