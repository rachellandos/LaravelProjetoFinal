@extends('layouts.fo')

@section('content')
    <h1>{{ $pet->name }}</h1>

    <img class="photo-table" src="{{ asset('storage/' . $pet->photo) }}" alt="">

    <p><strong>Espécie:</strong> {{ $pet->species }}</p>
    <p><strong>Cidade:</strong> {{ $pet->city }}</p>
    <p><strong>Descrição:</strong> {{ $pet->description }}</p>
    <p><strong>Data do pedido:</strong> {{ $pet->created_at }}</p>
    <p><strong>Estado de aprovação:</strong> {{ $pet->approval_status }}</p>

    @if (Auth::user() && Auth::user()->user_type == \App\Models\User::TYPE_ADMIN)
        <div class="d-flex gap-2">
            <form action="{{ route('dashboard.approve', $pet->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn-solid theme-success">Aceitar</button>
            </form>

            <form action="{{ route('dashboard.reject', $pet->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn-solid theme-danger">Rejeitar</button>
            </form>
        </div>
    @endif
@endsection