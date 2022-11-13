<div>
    <div class="title-header">
        <div>
            <span class="subheader">Basisdata:</span>
            <h1>Vakken</h1>
        </div>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createModal" wire:click.prevent="clearVak()"><i class="fa-solid fa-plus fa-fw"></i></button>
    </div>
    
    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th>Naam</th>
                <th>Omschrijving</th>
                <th>Volgorde</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($opleiding->vakken as $item)
                <tr class="hover-show">
                    <td>{{ $item->naam }}</td>
                    <td>{{ $item->omschrijving }}</td>
                    <td>{{ $item->volgorde }}</td>
                    <td class="text-end">
                        <button class="btn btn-lg btn-link link-primary"   data-bs-toggle="modal" data-bs-target="#showModal"   wire:click="setVak({{ $item->id }})"><i class="fa-regular fa-eye"></i></button>
                        <button class="btn btn-lg btn-link link-secondary" data-bs-toggle="modal" data-bs-target="#updateModal" wire:click="setVak({{ $item->id }})"><i class="fa-solid fa-pen-to-square"></i></button>
                        <button class="btn btn-lg btn-link link-danger"    data-bs-toggle="modal" data-bs-target="#deleteModal" wire:click="setVak({{ $item->id }})"><i class="fa-regular fa-trash-can">  </i></button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Modals -->
    @include('vakken.form', ['action' => 'create'])
    @include('vakken.form', ['action' => 'update'])
    @include('vakken.show')
    @include('vakken.delete')
</div>
