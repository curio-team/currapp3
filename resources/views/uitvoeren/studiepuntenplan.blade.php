<form class="modal-content">
    @csrf
    <div class="modal-header">
        <h1 class="modal-title fs-5" id="editStudiepuntenVakModalLabel"><span class="fw-normal">Studiepuntenplan</span> {{ optional(optional($vak_voor_punten)->parent)->naam }} <span class="fw-normal">in</span> {{ $uitvoer->naam }}</h1>
        @if($mode == 'modal')
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click.prevent="clearItem()"></button>
        @endif
    </div>
    <div class="modal-body">
        <div class="my-3">
            @if($vak_voor_punten->points != $vak_voor_punten->modules->sum('points'))
                <div class="text-primary"><strong><i class="fa-solid fa-fw fa-triangle-exclamation text-warning"></i> Aantal punten verdeeld niet gelijk aan totaal punten voor vak.</strong></div>
            @endif
            @if($vak_voor_punten->modules->sum('aantal_feedbackmomenten') < 1)
                <div class="text-primary"><strong><i class="fa-solid fa-fw fa-triangle-exclamation text-warning"></i> Aantal feedbackmomenten moet groter zijn dan één.</strong></div>
            @endif
            @if($vak_voor_punten->modules->max('max_punten') > $uitvoer->points*0.10)
                <div class="text-primary"><strong><i class="fa-solid fa-fw fa-triangle-exclamation text-warning"></i> Punten per feedbackmoment mogen niet groter zijn dan 10% van totaal van het blok.</strong></div>
            @endif
            @if($vak_voor_punten->modules->sum('aantal_checks_niet_oke') > 0)
                <div class="text-primary"><strong><i class="fa-solid fa-fw fa-triangle-exclamation text-warning"></i> Niet alle checks zijn ingevuld.</strong></div>
            @endif
        </div>
        @if($mode == 'modal')
            <div class="input-group my-3">
                <span class="input-group-text">Aantal punten nu verdeeld voor {{ optional(optional($vak_voor_punten)->parent)->naam }}:</span>
                <input type="number" disabled class="form-control" value="{{ $vak_voor_punten->modules->sum('points') }}">
                <span class="input-group-text">van in totaal:</span>
                <input type="number" class="form-control" wire:model="vak_voor_punten.points" required>
            </div>
        @elseif($mode == 'print' && $vak_voor_punten->points != $vak_voor_punten->modules->sum('points'))
            <div class="alert alert-secondary my-3">Aantal punten verdeeld: {{ $vak_voor_punten->modules->sum('points') }} / {{ $vak_voor_punten->points }}.</div>
        @endif
        <table class="table table-bordered">
            <tr class="table-primary">
                <th>Code</th>
                <th>Blokweek</th>
                <th>Onderwerp</th>
                <th>Punten</th>
                <th>Cesuur</th>
                <th style="width: 50%;">Checks</th>
            </tr>
            @foreach ($vak_voor_punten->modules as $m)
                <tr class="table-light">
                    <td colspan="6">{{ $m->parent->naam }}</td>
                </tr>
                @foreach ($m->feedbackmomenten()->orderBy('pivot_week')->get() as $fbm)
                    <tr>
                        <td>{{ $fbm->code }}</td>
                        <td>{{ $fbm->pivot->week }}</td>
                        <td>{{ $fbm->naam }}</td>
                        <td>{{ $fbm->points }}</td>
                        <td>{{ $fbm->cesuur }}%</td>
                        <td>
                            @if($fbm->checks)
                                {!! nl2br($fbm->checks) !!}
                            @else
                                <div class="text-primary"><strong><i class="fa-solid fa-fw fa-triangle-exclamation text-warning"></i>
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endforeach
        </table>
    </div>
    @if($mode == 'modal')
        <div class="modal-footer">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuleren</button>
            <a class="btn btn-primary" target="_blank" href="{{ route('studiepuntenplan.vak.show', $vak_voor_punten) }}"><i class="fa-solid fa-print fa-fw"></i> Afdrukken</a>
            <button type="button" class="btn btn-success" wire:click.prevent="editStudiepuntenVakPreview()">
                <span class="d-none spinner-border spinner-border-sm" role="status" aria-hidden="true" wire:loading.class.remove="d-none" wire:target="editStudiepuntenVak"></span>
                <i class="fa-solid fa-save fa-fw" wire:loading.class="d-none" wire:target="editStudiepuntenVak"></i>
                Opslaan
            </button>
        </div>
    @endif
</form>