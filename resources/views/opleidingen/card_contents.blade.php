<div class="card-body d-flex justify-content-between align-items-center">
    <h5 class="card-title"><a class="force-show stretched-link text-decoration-none" target="_blank"href="{{ route('opleidingen.uitvoeren.show', [$opleiding, $uitvoer]) }}">{{ $uitvoer->naam }}</a></h5>
    @if($uitvoer->studiepunten_oke)
        <i class="fa-solid fa-fw fa-check text-secondary hover-hide"></i>
    @else
        <i class="fa-solid fa-fw fa-triangle-exclamation text-primary"></i>
    @endif
</div>
<ul class="list-group list-group-flush">
    @foreach($uitvoer->cohorten as $cohort)
        <li class="list-group-item">{{ $cohort->naam }}</li>
    @endforeach
</ul>