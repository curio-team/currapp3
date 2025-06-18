<div class="modal fade" id="linkVakModal" tabindex="-1" role="dialog" aria-labelledby="linkVakModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable modal-fullscreen-md-down" role="document">
        <form class="modal-content" method="POST" action="{{ route('uitvoeren.link.vak.preview', $uitvoer) }}">
            @csrf
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="linkVakModalLabel">Vakken aanpassen</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click.prevent="clearItem()"></button>
            </div>
            <div class="modal-body">
                <div class="text-muted">Wanneer je een vak linkt aan een ander vak, neemt het het aantal studiepunten van dat vak over. Ook telt voor het totaal maar één van deze vakken mee. Dit is dus bijvoorbeeld handig wanneer er twee vakken op het leerplan staan, waarvan een student er maar eentje zal volgen.</div>
                <table class="table">
                    <tr>
                        <th colspan="3">Naam</th>
                        <th>Link studiepunten aan...</th>
                    </tr>
                    @foreach ($opleiding->vakken as $vak)
                        <tr>
                            <td><input type="checkbox" name="vakken[]" value="{{ $vak->id }}" id="vak_{{ $vak->id }}" @if($uitvoer->vakken->contains('vak_id', $vak->id)) checked @endif></td>
                            <td><label for="vak_{{ $vak->id }}">{{ $vak->naam }}</label></td>
                            <td><label for="vak_{{ $vak->id }}">{{ $vak->omschrijving }}</label></td>
                            <td>
                                <select name="keuzegroep[{{ $vak->id }}]" style="min-width: 120px;">
                                    <option value=""></option>
                                    @foreach ($opleiding->vakken as $vak2)
                                        @if($vak->id != $vak2->id)
                                            <option value="{{ $vak2->id }}"
                                            <?php
                                                if($uitvoer->vakken->contains('vak_id', $vak->id))
                                                {
                                                    $vakinuitvoer = \App\Models\VakInUitvoer::where('uitvoer_id', $uitvoer->id)->where('vak_id', $vak->id)->first();
                                                    $gelinkt_vak = \App\Models\VakInUitvoer::find($vakinuitvoer->gelinkt_aan_vak_id);
                                                    if(optional($gelinkt_vak)->vak_id == $vak2->id)
                                                    {
                                                        echo "selected";
                                                    }
                                                }
                                            ?>
                                            >{{ $vak2->naam }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuleren</button>
                <button type="submit" class="btn btn-success">
                    <i class="fa-regular fa-floppy-disk fa-fw"></i>
                    Opslaan
                </button>
            </div>
        </form>
    </div>
</div>
