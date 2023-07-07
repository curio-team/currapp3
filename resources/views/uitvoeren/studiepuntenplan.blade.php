<form class="modal-content">
    @csrf
    <div class="modal-header">
        <h1 class="modal-title fs-5" id="editStudiepuntenVakModalLabel"><span class="fw-normal">Studiepuntenplan</span> {{ optional(optional($vak_voor_punten)->parent)->naam }} <span class="fw-normal">in</span> {{ $uitvoer->naam }}</h1>
        @if($mode == 'modal')
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click.prevent="clearItem()"></button>
        @endif
    </div>
    <div class="modal-body">
        @if($vak_voor_punten->gelinkt_aan_vak_id && $mode == 'modal')
            <div class="alert alert-secondary mb-4">Dit vak is gelinkt aan <strong>{{ \App\Models\VakInUitvoer::find($vak_voor_punten->gelinkt_aan_vak_id)->parent->naam }}</strong>. Het totaal aantal studiepunten wordt hiervan overgenomen. Je dient wel een eigen studiepuntenplan op te bouwen. In het totaal van blok telt slechts één van deze vakken mee, omdat studenten er maar eentje volgen.</div>
        @endif
        <div class="my-3">
            @if($vak_voor_punten->points != $vak_voor_punten->sum_points)
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
            @if(!$vak_voor_punten->bpoints)
                <div class="text-primary"><strong><i class="fa-solid fa-fw fa-triangle-exclamation text-warning"></i> B-punten nog niet ingevuld.</strong></div>
            @endif
        </div>

        @if($mode == 'modal')
            <div class="input-group my-3">
                <span class="input-group-text">
                    <i class="fa-solid fa-user-tie fa-fw me-2"></i>
                    {{ $vak_voor_punten->eigenaars }}
                </span>
                <span class="input-group-text">Aantal punten nu verdeeld voor {{ optional(optional($vak_voor_punten)->parent)->naam }}:</span>
                <input type="number" disabled class="form-control" value="{{ $vak_voor_punten->sum_points }}">
                <span class="input-group-text">van in totaal:</span>
                <input type="number" class="form-control" wire:model="vak_voor_punten.points" required @if($vak_voor_punten->gelinkt_aan_vak_id) disabled @endif>
            </div>
        @elseif($mode == 'print' && $vak_voor_punten->points != $vak_voor_punten->sum_points)
            <div class="alert alert-secondary my-3">Aantal punten verdeeld: {{ $vak_voor_punten->sum_points }} / {{ $vak_voor_punten->points }}.</div>
        @else
            <div class="alert alert-secondary my-3">Totaal punten: {{ $vak_voor_punten->points }}.</div>
        @endif

        @if($mode == 'modal')
            <table class="table table-bordered">
                <tr class="table-primary">
                    <th>Code</th>
                    <th>Blokweek</th>
                    <th>Onderwerp</th>
                    <th>Punten</th>
                    <th>Cesuur</th>
                    <th>Checks</th>
                </tr>
                @foreach ($vak_voor_punten->modules as $m)
                    <tr class="table-secondary">
                        <td colspan="6">{{ $m->parent->naam }}</td>
                    </tr>
                    @foreach ($m->feedbackmomenten()->whereBetween('week', [$m->pivot->week_start, $m->pivot->week_eind])->orderBy('pivot_week')->get() as $fbm)
                        <tr>
                            <td>{{ $fbm->code }}</td>
                            <td>{{ $fbm->pivot->week }}</td>
                            <td>{{ $fbm->naam }}</td>
                            <td>{{ $fbm->points }}</td>
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
            <table class="table table-bordered">
                <tr class="table-primary">
                    <th>Code</th>
                    <th>Blokweek</th>
                    <th>Onderwerp</th>
                    <th>Punten</th>
                    <th>Cesuur</th>
                </tr>
                @foreach ($vak_voor_punten->modules as $m)
                    <tr><td colspan="5" style="border: none;"></td></tr>
                    <tr class="table-secondary">
                        <td colspan="5">Module {{ $m->parent->naam }}</td>
                    </tr>
                    @foreach ($m->feedbackmomenten()->whereBetween('week', [$m->pivot->week_start, $m->pivot->week_eind])->orderBy('pivot_week')->get() as $fbm)
                        <tbody style="page-break-inside: avoid;">
                            <tr class="table-light">
                                <td>{{ $fbm->code }}</td>
                                <td>Week {{ $fbm->pivot->week }}</td>
                                <td>{{ $fbm->naam }}</td>
                                <td>{{ $fbm->points }}pt</td>
                                <td>{{ $fbm->cesuur }}%</td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    @if($fbm->checks)
                                        <div class="trix-content">{!! $fbm->checks !!}</div>
                                    @else
                                        <div class="text-primary"><strong><i class="fa-solid fa-fw fa-triangle-exclamation text-warning"></i></strong> Checks nog niet ingevuld</div>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    @endforeach
                @endforeach
            </table>
        @endif

        @if($mode == 'modal')
            <div wire:ignore>
                <hr class="my-4">
                <h2 class="fs-5">B-punten</h2>
                <p class="text-muted">Geef hier aan waar studenten op kunnen letten voor het wel/niet behalen van de twee B-punten voor dit vak. Let op: aanwezigheid mag hierin alleen een onderdeel zijn als dat heel duidelijk is aangekondigd en als studenten die ziek of RA zijn hiervan geen nadeel ondervinden.</p>
                <trix-editor
                    class="trix-content"
                    x-data
                    x-on:trix-change="$dispatch('input', event.target.value)"
                    x-ref="trix"
                    wire:model.debounce.60s="vak_voor_punten.bpoints"
                    wire:key="uniqueKey"
                ></trix-editor>

                <script type="text/javascript">
                (function() {
                    addEventListener("trix-initialize", function(e) {
                        const file_tools = document.querySelector(".trix-button-group--file-tools");
                        file_tools.remove();
                    })
                    addEventListener("trix-file-accept", function(e) {
                        e.preventDefault();
                    })
                })();
                </script>
            </div>
        @else
            <hr class="my-4">
            <h2 class="fs-6">B-punten</h2>
            @if($vak_voor_punten->bpoints)
                <div class="alert alert-secondary trix-content" style="background-color: white !important;">
                    {!! $vak_voor_punten->bpoints !!}
                </div>
            @else
                <div class="text-primary"><strong><i class="fa-solid fa-fw fa-triangle-exclamation text-warning"></i> B-punten nog niet ingevuld.</strong></div>
            @endif
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