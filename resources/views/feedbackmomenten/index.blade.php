<div>
    <table class="table table-bordered table-hover">
        <tr class="table-primary">
            <td colspan="3">Totaal: <strong>{{ $versie->feedbackmomenten->sum('points') }}pts</strong></td>
            <td colspan="3"><button class="btn btn-link link-primary" data-bs-toggle="modal" data-bs-target="#fbmCreateModal"><i class="fa-solid fa-fw fa-plus"></i> nieuw</button></td>
        </tr>
        <tr class="table-light">
            <th>Code</th>
            <th>Onderwerp</th>
            <th>Punten</th>
            <th>Cesuur</th>
            <th>Week</th>
            <th></th>
        </tr>
        @foreach($versie->feedbackmomenten()->orderBy('pivot_week')->get() as $fbm)
            <tr class="hover-show">
                <td>{{ $fbm->code }}</td>
                <td>{{ $fbm->naam }}</td>
                <td>{{ $fbm->points }}</td>
                <td>{{ $fbm->cesuur }}</td>
                <td>{{ $fbm->pivot->week }}</td>
                <td>
                    <button class="btn btn-link" data-bs-toggle="modal" data-bs-target="#fbmEditModal" wire:click="setFbmItem({{ $fbm }}, {{ $fbm->pivot->week }})"><i class="fa-solid fa-fw fa-edit hover-hide"></i></button>
                    <button class="btn btn-link" data-bs-toggle="modal" data-bs-target="#fbmDeleteModal" wire:click="setFbmItem({{ $fbm }}, {{ $fbm->pivot->week }})"><i class="fa-solid fa-fw fa-trash hover-hide"></i></button>
                </td>
            </tr>
        @endforeach
    </table>
    
    <div wire:ignore.self class="modal fade" id="fbmEditModal" tabindex="-1" role="dialog" aria-labelledby="fbmEditModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-fullscreen-md-down" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="fbmEditModalLabel">Aanpassen</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click.prevent="clearItem()"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <form>
                                <div class="mb-3">
                                    <label>Code:</label>
                                    <input type="text" disabled class="form-control" value="{{ $item->code }}">
                                </div>
                                <div class="mb-3">
                                    <label>Onderwerp:</label>
                                    <input type="text" disabled class="form-control" value="{{ $item->naam }}">
                                </div>
                                <div class="mb-3">
                                    <label for="points">Punten</span>:</label>
                                    <input type="number" class="form-control" id="points" name="points" wire:model="item.points">
                                    @error('item.points') <span class="text-danger error">{{ $message }}</span>@enderror
                                </div>
                                <div class="mb-3">
                                    <label for="cesuur">Cesuur</span>:</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="cesuur" name="cesuur" wire:model="item.cesuur">
                                        <span class="input-group-text">%</span>
                                    </div>
                                    @error('item.cesuur') <span class="text-danger error">{{ $message }}</span>@enderror
                                </div>
                                <div class="mb-3">
                                    <label for="week">Week</span>:</label>
                                    <input type="number" class="form-control" id="week" wire:model="week">
                                    @error('week') <span class="text-danger error">{{ $message }}</span>@enderror
                                </div>
                            </form>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="checks">Checks:</label>
                                <textarea id="checks" class="form-control" wire:model="item.checks" rows="13"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light"   data-bs-dismiss="modal" wire:click.prevent="clearItem()">Annuleren</button>
                    <button type="button" class="btn btn-success" wire:click.prevent="edit()">
                        <span class="d-none spinner-border spinner-border-sm" role="status" aria-hidden="true" wire:loading.class.remove="d-none" wire:target="edit"></span>
                        <i class="fa-regular fa-floppy-disk fa-fw" wire:loading.class="d-none" wire:target="edit"></i>
                        Opslaan
                    </button>
                    <input type="hidden" name="id" wire:model="item.id">
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="fbmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="fbmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen-md-down" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="fbmDeleteModalLabel">Weet je het zeker?</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click.prevent="clearItem()"></button>
                </div>
                @if($fbm)
                    <div class="modal-body">
                        Dit feedbackmoment is gekoppeld aan in totaal {{ $fbm->modules->count() }} module(versie).
                        @if($fbm->modules->count() > 1)
                            Dit kan onverwachte gevolgen hebben voor de andere gekoppelde versies!
                        @endif
                    </div>
                @endif
                <div class="modal-footer">
                    <button type="button" class="btn btn-light"   data-bs-dismiss="modal" wire:click.prevent="clearItem()">Annuleren</button>
                    <button type="button" class="btn btn-danger" wire:click.prevent="destroy()">
                        <span class="d-none spinner-border spinner-border-sm" role="status" aria-hidden="true" wire:loading.class.remove="d-none" wire:target="destroy"></span>
                        <i class="fa-solid fa-trash fa-fw" wire:loading.class="d-none" wire:target="destroy"></i>
                        Verwijderen
                    </button>
                    <input type="hidden" name="id" wire:model="item.id">
                </div>
            </div>
        </div>
    </div>

</div>