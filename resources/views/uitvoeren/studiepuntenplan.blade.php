<style>
    .table-fixed {
        table-layout: fixed;
        width: 100%;
    }
</style>
<form class="modal-content">
    @csrf
    <div class="modal-header">
        <h1 class="modal-title fs-5" id="editStudiepuntenVakModalLabel"><span class="fw-normal">Puntenplan</span> {{ optional(optional($vak_voor_punten)->parent)->naam }} <span class="fw-normal">in</span> {{ $uitvoer->naam }}</h1>
        @if($mode == 'modal')
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click.prevent="clearItem()"></button>
        @endif
    </div>
    <div class="modal-body">
        @if($vak_voor_punten->gelinkt_aan_vak_id && $mode == 'modal')
            {{-- <div class="alert alert-secondary mb-4">Dit vak is gelinkt aan <strong>{{ \App\Models\VakInUitvoer::find($vak_voor_punten->gelinkt_aan_vak_id)->parent->naam }}</strong>. Het totaal aantal studiepunten wordt hiervan overgenomen. Je dient wel een eigen studiepuntenplan op te bouwen. In het totaal van blok telt slechts één van deze vakken mee, omdat studenten er maar eentje volgen.</div> --}}
        @endif
        <div class="my-3">
            @if($vak_voor_punten->modules->sum('aantal_feedbackmomenten') < 1)
                <div class="text-primary"><strong><i class="fa-solid fa-fw fa-triangle-exclamation text-warning"></i> Aantal feedbackmomenten moet groter zijn dan één.</strong></div>
            @endif
            @if($vak_voor_punten->modules->sum('aantal_checks_niet_oke') > 0)
                <div class="text-primary"><strong><i class="fa-solid fa-fw fa-triangle-exclamation text-warning"></i> Niet alle checks zijn ingevuld.</strong></div>
            @endif
        </div>

        @if($mode == 'modal')
            <table class="table table-fixed table-bordered">
                <tr class="table-primary">
                    <th>Code</th>
                    <th>Blokweek</th>
                    <th>Onderwerp</th>
                    <th>Cesuur</th>
                    <th>Checks</th>
                </tr>
                @foreach ($vak_voor_punten->modules as $m)
                    <tr class="table-secondary">
                        <td colspan="5">{{ $m->parent->naam }}</td>
                    </tr>
                    @foreach ($m->feedbackmomenten()->whereBetween('week', [$m->pivot->week_start, $m->pivot->week_eind])->orderBy('pivot_week')->get() as $fbm)
                        <tr>
                            <td>{{ $fbm->code }}</td>
                            <td>{{ $fbm->pivot->week }}</td>
                            <td>{{ $fbm->naam }}</td>
                            <td>{{ $fbm->cesuur }}%</td>
                            <td>
                                @if($fbm->checks)
                                    <div class="trix-content">{!! $fbm->checks !!}</div>
                                @else
                                    <div class="text-primary"><strong><i class="fa-solid fa-fw fa-triangle-exclamation text-warning"></i></strong></div>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @endforeach
            </table>
        @else
            <table class="table table-fixed table-bordered">
                <tbody>
                    <tr class="table-primary">
                        <th>Code</th>
                        <th>Blokweek</th>
                        <th>Onderwerp</th>
                        <th>Cesuur</th>
                    </tr>
                </tbody>
            </table>
            @foreach ($vak_voor_punten->modules as $m)
                <table class="table table-fixed table-bordered">
                    <tbody>
                        <tr class="table-secondary">
                            <td colspan="4" style="page-break-after: avoid;">Module {{ $m->parent->naam }}</td>
                        </tr>
                        @foreach ($m->feedbackmomenten()->whereBetween('week', [$m->pivot->week_start, $m->pivot->week_eind])->orderBy('pivot_week')->get() as $fbm)
                            @if(!$loop->first) <tbody> @endif
                                <tr class="table-light">
                                    <td>{{ $fbm->code }}</td>
                                    <td>Week {{ $fbm->pivot->week }}</td>
                                    <td>{{ $fbm->naam }}</td>
                                    <td>{{ $fbm->cesuur }}%</td>
                                </tr>
                                <tr>
                                    <td colspan="4">
                                        @if($fbm->checks)
                                            <div class="trix-content">{!! $fbm->checks !!}</div>
                                        @else
                                            <div class="text-primary"><strong><i class="fa-solid fa-fw fa-triangle-exclamation text-warning"></i></strong> Checks nog niet ingevuld</div>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        @endforeach
                </table>
            @endforeach
        @endif
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
