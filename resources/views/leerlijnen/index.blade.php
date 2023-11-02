<div>
    <div class="title-header">
        <div>
            <span class="subheader">Basisdata:</span>
            <h1>Leerlijnen</h1>
        </div>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createModal" wire:click.prevent="clearItem()"><i class="fa-solid fa-plus fa-fw"></i></button>
    </div>
    
    <table class="table">
        <tbody>
            @foreach ($opleiding->leerlijnen as $leerlijn)
                <tr class="hover-show" style="background-color: {{ $leerlijn->color }}; color: {{ $leerlijn->textColor }}">
                    <td class="fs-5 ps-3">
                        <small><span class="badge me-3" style="font-weight: normal; vertical-align: text-bottom; background-color: {{ $leerlijn->textColor }}; color: {{ $leerlijn->color }}">{{ $leerlijn->eigenaar_id }}</span></small>
                        <strong>{{ $leerlijn->naam }}</strong>
                    </td>
                    <td class="text-end">
                        <button style="color: {{ $leerlijn->textColor }}" class="btn btn-lg p-1 p-md-3 btn-link" data-bs-toggle="modal" data-bs-target="#updateModal" wire:click="setItem({{ $leerlijn->id }})"><i class="fa-solid fa-pen-to-square"></i></button>
                        <button style="color: {{ $leerlijn->textColor }}" class="btn btn-lg p-1 p-md-3 btn-link" data-bs-toggle="modal" data-bs-target="#deleteModal" wire:click="setItem({{ $leerlijn->id }})"><i class="fa-regular fa-trash-can">  </i></button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Modals -->
    @include('leerlijnen.form', ['action' => 'create'])
    @include('leerlijnen.form', ['action' => 'update'])
    @include('leerlijnen.delete')
</div>
