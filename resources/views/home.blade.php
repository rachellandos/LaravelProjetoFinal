@extends('layouts.fo')

@section('content')
    <div class="container-fluid text-center">
        <img src="{{ asset('images/gato.avif') }}" alt="" width="900px">
    </div>

    {{-- Cabeçalho --}}
    <div class="text-center py-5">
        <h1>Ajuda a reunir famílias com os seus animais</h1>
        <p class="lead">
            Perdeste o teu animal? Publica um anúncio e deixa a comunidade ajudar.
        </p>

        <div class="d-flex justify-content-center gap-3">
            <a href="{{ route('pets.all') }}" class="btn-solid theme-info">Ver anúncios</a>
            @auth
                <a href="{{ route('pets.add') }}" class="btn-solid theme-success">Publicar anúncio</a>
            @endauth
            @guest
                <a href="{{ route('login') }}" class="btn-solid theme-success">Entrar para publicar</a>
            @endguest
        </div>
    </div>
@endsection
