<div>
    <div class="title-header">
        <div>
            <span class="subheader">Basisdata:</span>
            <h1>Blokken</h1>
        </div>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createModal" wire:click.prevent="clearItem()"><i class="fa-solid fa-plus fa-fw"></i></button>
    </div>
    
    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th>Naam</th>
                <th>Eigenaar</th>
                <th class="d-none d-sm-table-cell">Volgorde</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($opleiding->blokken as $blok)
                <tr class="hover-show">
                    <td>{{ $blok->naam }}</td>
                    <td>{{ $blok->eigenaar_id }}</td>
                    <td class="d-none d-sm-table-cell">{{ $blok->volgorde }}</td>
                    <td class="text-end">
                        <button class="btn btn-lg p-1 p-md-3 btn-link link-primary"   data-bs-toggle="modal" data-bs-target="#showModal"   wire:click="setItem({{ $blok->id }})"><i class="fa-regular fa-eye"></i></button>
                        <button class="btn btn-lg p-1 p-md-3 btn-link link-secondary" data-bs-toggle="modal" data-bs-target="#updateModal" wire:click="setItem({{ $blok->id }})"><i class="fa-solid fa-pen-to-square"></i></button>
                        <button class="btn btn-lg p-1 p-md-3 btn-link link-danger"    data-bs-toggle="modal" data-bs-target="#deleteModal" wire:click="setItem({{ $blok->id }})"><i class="fa-regular fa-trash-can">  </i></button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Modals -->
    @include('blokken.form', ['action' => 'create'])
    @include('blokken.form', ['action' => 'update'])
    @include('blokken.show')
    @include('blokken.delete')
</div>
