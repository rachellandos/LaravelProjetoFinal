@php

@endphp

@extends('layouts.fo')

@section('content')
    <h1>Todos os utilizadores 👤</h1>
    @if (session('message'))
        <div class="py-2">
            <div class="alert theme-success py-2">{{ session('message') }}</div>
        </div>
    @endif

    <form action="" method="get">
        <input type="text" name="search">
        <button class="btn-solid btn-secondary" type="submit">Procurar</button>
    </form>
    <div class="py-3">
        <h4>Utilizadores da base de dados</h4>
        <table class="table theme-accent">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    @auth
                        <th></th>
                    @endauth
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    @auth
                        <th></th>
                    @endauth
                    @if (Auth::user() && Auth::user()->user_type == \App\Models\User::TYPE_ADMIN)
                        <th></th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        {{-- {{ dd($user->photo) }} --}}
                        <th scope="row"> {{ $user->id }} </th>
                        @auth
                            <td><img class="photo-table"
                                    src="{{ $user->photo ? asset('storage/' . $user->photo) : asset('images/nouserphoto.png') }}"
                                    alt=""> </td>
                        @endauth
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        @auth
                            <td><a href="{{ route('users.edit', $user->id) }}" class="btn-solid theme-info">Ver</a></td>
                        @endauth
                        @if (Auth::user() && Auth::user()->user_type == \App\Models\User::TYPE_ADMIN)
                            <td><a href="{{ route('users.delete', $user->id) }}" class="btn-solid theme-danger">Apagar</a>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
