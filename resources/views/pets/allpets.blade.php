@php

@endphp

@extends('layouts.fo')

@section('content')
    <h1>Todos os animais desaparecidos: </h1>
    <div class="py-2">
        @if (session('message'))
            <div class="alert theme-success py-2">{{ session('message') }}</div>
        @endif
    </div>
    <form action="" method="get">
        <input type="text" name="search">
        <button class="btn-solid btn-secondary" type="submit">Procurar</button>
    </form>

    @foreach ($pets as $pet)
        <div class="card" style="width: 18rem;">
            @auth
                <img class="card-img-top"
                    src="{{ $pet->photo ? asset('storage/' . $pet->photo) : asset('images/nopetphoto.png') }}" alt="">
            @endauth
            <div class="card-body">
                <h4 class="card-title">{{ $pet->id }}: {{ $pet->name }}</h4>
                <p class="card-text">{{ $pet->description }}</p>
            </div>
            <ul class="list-group list-group-flush">

                <li class="list-group-item">{{ $pet->species }}</li>
                @auth
                    <li class="list-group-item">{{ $pet->city }}</li>
                @endauth

            </ul>
            <div class="card-body flex-row gap-4">
                @auth
                    <a href="{{ route('pets.edit', $pet->id) }}" class="btn-solid theme-info">Ver</a></li>
                @endauth
                @if (Auth::user() && Auth::user()->user_type == \App\Models\User::TYPE_ADMIN)
                    <a href="{{ route('pets.delete', $pet->id) }}" class="btn-solid theme-danger">Apagar</a>
                    </li>
                @endif
            </div>
        </div>
        <tr>
            {{-- {{ dd($pet->photo) }} --}}
            <th scope="row"> </th>

            <td></td>
            <td></td>
            <td></td>

        </tr>
    @endforeach
    </tbody>
    </table>
    </div>
@endsection
