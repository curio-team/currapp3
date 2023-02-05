<div>
    <div class="title-header">
        <div>
            <span class="subheader">Cohort:</span>
            <h1>{{ $cohort->naam }}</h1>
        </div>
        <div>
            <a class="btn btn-light me-1" href="{{ route('opleidingen.cohorten', $opleiding) }}"><i class="fa-solid fa-circle-left fa-fw"></i> Cohorten</a>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#linkModal"><i class="fa-solid fa-link fa-fw"></i></button>
        </div>
    </div>

    @for ($schooljaar = $cohort->uitvoeren->pluck('schooljaar')->unique()->min(); $schooljaar <= $cohort->uitvoeren->pluck('schooljaar')->unique()->max(); $schooljaar++)
        <div class="my-4" style="display: grid; grid-template-columns: auto repeat({{ $opleiding->blokken_per_jaar }}, 1fr); grid-gap: 1.5rem;">
            <div class="d-flex align-items-center" style="grid-column: 1;">{{ substr($schooljaar, 2, 2) }} / {{ substr($schooljaar+1, 2, 2) }}</div>
            @foreach($cohort->uitvoeren()->where('schooljaar', $schooljaar)->orderBy('datum_start')->get() as $uitvoer)
                <div class="card hover-show" style="grid-column: {{ $uitvoer->blok_in_schooljaar+1 }};">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <span>{{ $uitvoer->naam }}</span>
                        <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#unlinkModal" wire:click="setItem({{ $uitvoer->id }})"><i class="fa-solid fa-unlink fa-fw"></i></button>
                    </div>
                </div>
            @endforeach
        </div>
    @endfor

    <!-- Modals -->
    @include('cohort_uitvoeren.unlink')
    @include('cohort_uitvoeren.link')

</div>
