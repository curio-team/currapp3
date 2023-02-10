<div>
    <div class="title-header">
        <div>
            <h1>Cohorten</h1>
        </div>
        <div class="btn-group">
            <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#createModal" wire:click.prevent="clearItem()"><i class="fa-solid fa-plus fa-fw"></i></button>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#copyModal" wire:click.prevent="clearItem()"><i class="fa-regular fa-copy fa-fw"></i></button>
        </div>
    </div>
    
    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th>Naam</th>
                <th>Start-datum</th>
                <th>Eind-datum</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($opleiding->cohorten as $cohort)
                <tr class="hover-show">
                    <td>{{ $cohort->naam; }}</td>
                    <td>{{ $cohort->datum_start; }}</td>
                    <td>{{ $cohort->datum_eind; }}</td>
                    <td class="text-end">
                        <a class="btn btn-lg p-1 p-md-3 btn-link link-primary" href="{{ route('opleidingen.cohorten.show', [$opleiding, $cohort]) }}"><i class="fa-regular fa-eye"></i></a>
                        <button class="btn btn-lg p-1 p-md-3 btn-link link-secondary" data-bs-toggle="modal" data-bs-target="#updateModal" wire:click="setItem({{ $cohort->id }})"><i class="fa-solid fa-pen-to-square"></i></button>
                        <button class="btn btn-lg p-1 p-md-3 btn-link link-danger"    data-bs-toggle="modal" data-bs-target="#deleteModal" wire:click="setItem({{ $cohort->id }})"><i class="fa-regular fa-trash-can">  </i></button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Modals -->
    @include('cohorten.form', ['action' => 'create'])
    @include('cohorten.form', ['action' => 'update'])
    @include('cohorten.delete')
    @include('cohorten.copy')
</div>
