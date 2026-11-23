<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Homepage</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
    {{-- bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@6.0.0-alpha.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-B/GM4XqrwHnWXNOWMbloTmrYXZg10cakYGmpfsR/bbzQ6JAJI4ihuyADKLnBgrCe" crossorigin="anonymous">

    <script type="module" src="https://cdn.jsdelivr.net/npm/bootstrap@6.0.0-alpha.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-1a/pXj49ZQ1aHEmrJ+gMw1otqoVsYwlEnlD8mIfY2TV03r20Y0CN7uqx1tQogjPL" crossorigin="anonymous" defer>
    </script>

</head>

<body>
    <nav class="navbar md:navbar-expand bg-3">
        <div class="container-fluid">
            <button class="btn-icon navbar-toggler" type="button" data-bs-toggle="drawer"
                data-bs-target="#navbarDrawer" aria-controls="navbarDrawer" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon" aria-hidden="true"></span>
            </button>
            <dialog class="drawer drawer-end" tabindex="-1" id="navbarDrawer" aria-labelledby="navbarDrawerLabel">
                <div class="drawer-header">
                    <h5 class="drawer-title" id="navbarDrawerLabel">Menu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="drawer" aria-label="Close"></button>
                </div>
                <div class="drawer-body mb-2 md:mb-0">
                    <ul class="nav nav-pills navbar-nav me-auto bg-1">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="{{ route('home') }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('users.all') }}">Utilizadores</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('pets.all') }}">Ver Animais</a>
                        </li>
                        {{-- <li class="nav-item">
                            <a class="nav-link" href="{{ route('gifts.all') }}">Prendas</a>
                        </li> --}}
                    </ul>
    @auth
        <h2>Olá, {{ Auth::user()->name }}</h2>
    @endauth
                    @if (Route::has('login'))
                        <nav class="navbar-nav nav-pills d-flex flex-row justify-content-center gap-4">
                            @auth
                                @if (\App\Models\Pet::where('user_id', Auth::id())->exists())
                                    <a href="{{ route('pets.mine') }}"
                                        class="nav-link px-5 text-body border border-secondary rounded-pill leading-normal">
                                        Os meus anúncios
                                    </a>
                                @endif
                                <a href="{{ route('pets.add') }}"
                                    class="nav-link px-5 text-body border border-secondary rounded-pill leading-normal">
                                    Publicar anuncio
                                </a>
                                @if (Auth::user()?->user_type == \App\Models\User::TYPE_ADMIN)
                                    <a href="{{ route('dashboard') }}"
                                        class="nav-link px-5 text-body border border-secondary rounded-pill leading-normal">
                                        Dashboard
                                    </a>
                                @endif
                                <form action="{{ route('logout') }}" method="post">
                                    @csrf
                                    <button type="submit" class="btn-solid theme-warning rounded-pill">Logout</button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="btn-solid theme-accent px-5 rounded-pill">
                                    Log in
                                </a>

                                @if (Route::has('users.add'))
                                    <a href="{{ route('users.add') }}" class="btn-subtle theme-accent px-5 rounded-pill">
                                        Register
                                    </a>
                                @endif
                            @endauth
                        </nav>
                    @endif
                </div>
        </div>
        </dialog>
        </div>
    </nav>

    <div class="container-fluid">

        @yield('content')

    </div>


</body>

</html>
