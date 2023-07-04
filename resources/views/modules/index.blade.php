<div>
    <div class="title-header">
        <h1>Modules</h1>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createModal" wire:click.prevent="clearItem()"><i class="fa-solid fa-plus fa-fw"></i></button>
    </div>
    
    <table class="table">
        <thead>
            <tr>
                <th></th>
                <th class="ps-4">Naam</th>
                <th>Omschrijving</th>
                <th>Link naar map</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($opleiding->modules as $module)
                <tr class="hover-show">
                    <td style="background-color: {{ $module->leerlijn->color }}; color: {{ $module->leerlijn->textColor }}">
                        <div class="d-flex justify-content-center align-items-center"><small>{{ $module->leerlijn->naam }}</small></div>
                    </td>
                    <td class="ps-4">{{ $module->naam }}</td>
                    <td>{{ $module->omschrijving }}</td>
                    <td>
                        @if(!empty($module->map_url))
                            <a target="_blank" class="force-show" href="{{ $module->map_url }}">link</a>
                        @endif
                    </td>
                    <td class="text-end">
                        <a class="btn btn-lg p-1 p-md-3 btn-link link-primary" href="{{ route('opleidingen.modules.show', [$opleiding, $module]) }}"><i class="fa-regular fa-eye"></i></a>
                        <button class="btn btn-lg p-1 p-md-3 btn-link link-secondary" data-bs-toggle="modal" data-bs-target="#updateModal" wire:click="setItem({{ $module->id }})"><i class="fa-solid   fa-pen-to-square"></i></button>
                        <button class="btn btn-lg p-1 p-md-3 btn-link link-danger"    data-bs-toggle="modal" data-bs-target="#deleteModal" wire:click="setItem({{ $module->id }})"><i class="fa-regular fa-trash-can">  </i></button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Modals -->
    @include('modules.form', ['action' => 'create'])
    @include('modules.form', ['action' => 'update'])
    @include('modules.delete')
</div>
