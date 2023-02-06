@extends('layouts.app')

@section('container-class', 'container-fluid')

@section('main')
    
    <div class="m-4" style="display: grid; grid-template-columns: auto repeat({{ $uitvoer->vakken->count() }}, 1fr) auto; grid-gap: 1rem;">
        @for ($i = 1; $i <= 16; $i++)
            <div style="grid-column: 1; grid-row: {{ $i+1 }}; text-align: center;"><em>{{ $i }}</em></div>
            <div style="grid-column: {{ $uitvoer->vakken->count()+2 }}; grid-row: {{ $i+1 }}; text-align: center;"><em>{{ $i }}</em></div>
        @endfor
        
        @foreach($uitvoer->vakken as $vak)
            <div style="grid-column: {{ $loop->iteration+1 }}; grid-row: 1; text-align: center;"><strong>{{ $vak->parent->naam }}</strong></div>
            @foreach ($vak->modules as $module)
                <div style="grid-column: {{ $loop->parent->iteration+1 }}; grid-row: {{ $module->pivot->week_start+1 }} / {{ $module->pivot->week_eind+2 }}; border: 1px solid black;">
                    {{ $module->id.$module->parent->naam }} {{ $module->naam }} {{ $vak->parent->naam }}
                </div>
            @endforeach
        @endforeach
    </div>

@endsection