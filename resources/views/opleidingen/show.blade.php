@extends('layouts.app')

@section('main')

    <div class="alert alert-primary mb-5" role="alert">
        <strong>Wat je moet weten over de CurrApp:</strong>
        <ul class="mb-0">
            <li>Ieder blok kent meerdere uitvoeren, voor ieder half jaar eentje. Het studievoortgangplan van een uitvoer is de basis voor Smartpoints.</li>
            <li>In het uitvoer-scherm maken we <u>wijzigingen voor alle toekomstige uitvoeren</u>, dit vraagt de CurrApp je ook.</li>
            <li><u>Inhoudelijke wijziging = nieuw feedbackmoment</u>. Een fbm-code staat voor een onveranderbaar toetsmoment.</li>
            <li>We <u>wijzigen de geschiedenis niet</u>: verandert er iets aan de fbm's, dan maak je een nieuwe versie van een module. Deze nieuwe versie koppel je aan de komende uitvoer (en die daarna). Aan de huidige of voorbije uitvoeren verandert dan niets; deze situatie blijft kloppen met hoe het ooit is uitgevoerd.</li>
            <li>Een nieuwe versie krijgt automatisch <em>dezelfde</em> feedbackmomenten. Wijzigt een fbm? Dan dus een nieuwe maken, anders wijzig je ook de oude versie.</li>
        </ul>
    </div>

    <div class="mb-3" style="display: grid; grid-template-columns: repeat(3, 1fr); column-gap: 3rem;">
        <div>
            <h3>Afgelopen blokken</h3>
            @foreach ($uitvoeren_verleden as $uitvoer)
                <div class="card hover-show mb-3">
                    @include('opleidingen.card_contents', ['uitvoer' => $uitvoer])
                </div>
            @endforeach
        </div>

        <div>
            <h3>Actuele blokken</h3>
            @foreach ($uitvoeren_actueel as $uitvoer)
                <div class="card hover-show border-secondary bg-light mb-3">
                    @include('opleidingen.card_contents', ['uitvoer' => $uitvoer])
                </div>
            @endforeach
        </div>

        <div>
            <h3>Aankomende blokken</h3>
            @foreach ($uitvoeren_toekomst as $uitvoer)
                <div class="card hover-show mb-3">
                    @include('opleidingen.card_contents', ['uitvoer' => $uitvoer])
                </div>
            @endforeach
        </div>
    </div>

@endsection
