@extends('layouts.app')

@section('main')

    <div style="min-height: calc(100vh - 60px - 1.5rem); display: flex; justify-content: center; align-items: center;">
        <div class="card text-bg-warning">
            <div class="card-header">API Token</div>
            <div class="card-body">
                <pre class="card-text fs-5 my-3">{{ $token->plainTextToken }}</pre>
            </div>
            <div class="card-footer"><em>You'll never see this token again, so make sure to copy it now!</em></div>
        </div>
    </div>

@endsection