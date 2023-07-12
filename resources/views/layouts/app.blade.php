<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'CurrApp')</title>
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
        @livewireStyles
        <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.0/dist/trix.css">
  	    <script type="text/javascript" src="https://unpkg.com/trix@2.0.0/dist/trix.umd.min.js"></script>
    </head>
    <body>
        <nav class="navbar navbar-expand-md navbar-dark bg-dark d-print-none">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ route('home') }}">CurrApp</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}">Home</a>
                        </li>
                        @if(isset($opleiding))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('opleidingen.modules', $opleiding) }}">Modules</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('opleidingen.cohorten', $opleiding) }}">Cohorten</a>
                            </li>
                        @endif
                    </ul>
                    @if(isset($opleiding))
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ $opleiding->naam}} | {{ $opleiding->omschrijving }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><p class="dropdown-header">Basisdata:</p></li>
                                    <li><a class="dropdown-item" href="{{ route('opleidingen.blokken',     $opleiding) }}">Blokken</a></li>
                                    <li><a class="dropdown-item" href="{{ route('opleidingen.leerlijnen',  $opleiding) }}">Leerlijnen</a></li>
                                    <li><a class="dropdown-item" href="{{ route('opleidingen.vakken',      $opleiding) }}">Vakken</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><p class="dropdown-header">Wissel opleiding:</p></li>


                                    @foreach (Auth::user()->teams as $team)
                                        @foreach ($team->opleidingen as $opleiding)
                                            <li><a class="dropdown-item" href="{{ route('opleidingen.show', $opleiding) }}">
                                                {{ $opleiding->naam }} | {{ $opleiding->omschrijving }}
                                            </a></li>
                                        @endforeach
                                    @endforeach
                                </ul>
                            </li>
                            
                        </ul>
                    @endif
                </div>
            </div>
        </nav>
        
        @yield('subnav')

        <div class="@yield('container-class', 'container mt-4')">
            @yield('main')
        </div>
        @livewireScripts

        <script>
        window.livewire.on('confirm', () => 
        {
            var element = document.querySelectorAll('.modal.show')[0];
            var modal = bootstrap.Modal.getInstance(element);
            modal.hide();
        });

        document.addEventListener("trix-initialize", function(e) {
            if (document.querySelector(".trix-button-group--file-tools") !== null) {
                const file_tools = document.querySelector(".trix-button-group--file-tools");
                file_tools.remove();
            }
        })
        document.addEventListener("trix-file-accept", function(e) {
            e.preventDefault();
        })
        </script>
    </body>
</html>