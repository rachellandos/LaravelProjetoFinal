@php

@endphp

@extends('layouts.fo')

@section('content')
    <h1>📊 Dashboards 📈</h1>
    <div class="py-2">
        @auth
            <h2>Olá, {{ Auth::user()->name }}</h2>
        @endauth
    </div>
    @if (session('message'))
        <div class="py-2">
            <div class="alert theme-success py-2">{{ session('message') }}</div>
        </div>
    @endif

    <h2>Pedidos pendentes de aprovação: </h2>
    @if (Auth::user() && Auth::user()->user_type == \App\Models\User::TYPE_ADMIN)
        <table class="table theme-accent">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    @auth
                        <th>Foto</th>
                    @endauth
                    <th scope="col">Nome</th>
                    <th scope="col">Especie</th>
                    <th scope="col">Cidade</th>
                    <th scope="col">Data do pedido:</th>
                    <th scope="col">Estado do Pedido</th>
                    @auth
                        <th></th>
                    @endauth
                    @if (Auth::user() && Auth::user()->user_type == \App\Models\User::TYPE_ADMIN)
                        <th></th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($petsPending as $pet)
                    <tr>
                        <th scope="row"> {{ $pet->id }} </th>
                        @auth
                            <td><img class="photo-table" src="{{ asset('storage/' . $pet->photo) }}" alt=""> </td>
                        @endauth
                        <td>{{ $pet->name }}</td>
                        <td>{{ $pet->species }}</td>
                        <td>{{ $pet->city }}</td>
                        <td>{{ $pet->created_at }}</td>
                        @php
                            $colorValue =
                                $pet->approval_status == 'pending'
                                    ? 'warning'
                                    : ($pet->approval_status == 'approved'
                                        ? 'success'
                                        : 'danger');
                        @endphp
                        <td class = "bg-solid theme-{{ $colorValue }}">{{ $pet->approval_status }}</td>
                        @auth
                            <td><a href="{{ route('dashboard.showPet', $pet->id) }}" class="btn-solid theme-info">Ver</a></td>
                        @endauth
                        @if (Auth::user() && Auth::user()->user_type == \App\Models\User::TYPE_ADMIN)
                            <td><a href="{{ route('dashboard.delete', $pet->id) }}" class="btn-solid theme-danger">Apagar</a>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <h2>Todas as publicações: </h2>
    @if (Auth::user() && Auth::user()->user_type == \App\Models\User::TYPE_ADMIN)
        <table class="table theme-accent">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    @auth
                        <th>Foto</th>
                    @endauth
                    <th scope="col">Nome</th>
                    <th scope="col">Especie</th>
                    <th scope="col">Cidade</th>
                    <th scope="col">Data do pedido:</th>
                    <th scope="col">Estado do Pedido</th>
                    @auth
                        <th></th>
                    @endauth
                    @if (Auth::user() && Auth::user()->email == 'admin@gmail.com')
                        <th></th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($pets as $pet)
                    <tr>
                        <th scope="row"> {{ $pet->id }} </th>
                        @auth
                            <td><img class="photo-table" src="{{ asset('storage/' . $pet->photo) }}" alt=""> </td>
                        @endauth
                        <td>{{ $pet->name }}</td>
                        <td>{{ $pet->species }}</td>
                        <td>{{ $pet->city }}</td>
                        <td>{{ $pet->created_at }}</td>
                        @php
                            $colorValue =
                                $pet->approval_status == 'pending'
                                    ? 'warning'
                                    : ($pet->approval_status == 'approved'
                                        ? 'success'
                                        : 'danger');
                        @endphp
                        <td class = "bg-solid theme-{{ $colorValue }}">{{ $pet->approval_status }}</td>
                        @auth
                            <td><a href="{{ route('dashboard.edit', $pet->id) }}" class="btn-solid theme-info">Ver</a></td>
                        @endauth
                        @if (Auth::user() && Auth::user()->email == 'admin@gmail.com')
                            <td><a href="{{ route('dashboard.delete', $pet->id) }}" class="btn-solid theme-danger">Apagar</a>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
