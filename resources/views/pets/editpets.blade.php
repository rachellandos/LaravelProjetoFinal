@extends('layouts.fo')

@section('content')
    <h2>Detalhes do Anuncio {{ $pet->name }}</h2>
    <h1>{{ $pet->name }}</h1>

    <img class="pet-info-photo" src="{{ asset('storage/' . $pet->photo) }}" alt="">

    <p><strong>Espécie:</strong> {{ $pet->species }}</p>
    <p><strong>Cidade:</strong> {{ $pet->city }}</p>
    <p><strong>Descrição:</strong> {{ $pet->description }}</p>
    <p><strong>Data do anuncio:</strong> {{ $pet->created_at }}</p>
    <p><strong>Publicado por:</strong> {{ $pet->user_name }}</p>
    {{-- {{ dd($pet->status) }} --}}
    @if (Auth::user() && (Auth::id() == $pet->user_id || Auth::user()->user_type == \App\Models\User::TYPE_ADMIN))
        <button type="button" class="btn-solid theme-accent" data-bs-toggle="dialog" data-bs-target="#exampleDialog">
            Editar Dados
        </button>
        <dialog class="dialog" id="exampleDialog">
            <div class="dialog-header">
                <h1 class="dialog-title">Editar Dados do Anuncio</h1>
                <button type="button" class="btn-close" data-bs-dismiss="dialog" aria-label="Close"></button>
            </div>
            <div class="dialog-body">
                <form method="POST" enctype="multipart/form-data" action="{{ route('pets.update') }}">
                    @method('PUT')
                    @csrf
                    <input type="hidden" name="id" value="{{ $pet->id }}">
                    <div class="mb-3">

                        <div class="mb-3">
                            <label for="name" class="form-label">Nome do Animal: *</label>
                            <input type="text" name="name" class="form-control" id="name"
                                value="{{ $pet->name }}">
                            @error('name')
                                <p class="error-message">Nome inválido</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="species" class="form-label">Espécie: *</label>
                            <input type="text" name="species" class="form-control" id="species"
                                value="{{ $pet->species }}">
                            @error('email')
                                <p class="error-message">Espécie inválida</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Descrição:</label>
                            <input type="text" name="description" class="form-control" id="description"
                                value="{{ $pet->description }}">
                            @error('password')
                                <p class="error-message">Descrição inválida</p>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="city" class="form-label">Cidade: *</label>
                            <select name="city" id="city" required>
                                <option value="Lisboa" {{ $pet->city == 'Lisboa' ? 'selected' : '' }}>Lisboa</option>
                                <option value="Porto" {{ $pet->city == 'Porto' ? 'selected' : '' }}>Porto</option>
                                <option value="Coimbra" {{ $pet->city == 'Coimbra' ? 'selected' : '' }}>Coimbra</option>
                                <option value="Faro" {{ $pet->city == 'Faro' ? 'selected' : '' }}>Faro</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Estado: *</label>
                            
                            <select name="status" id="status" required>
                                <option value="perdido" {{ $pet->status == 'perdido' ? 'selected' : '' }}>perdido</option>
                                <option value="encontrado" {{ $pet->status == 'encontrado' ? 'selected' : '' }}>encontrado</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="photo" class="form-label">Fotografía do animal:</label>
                            <input type="file" name="photo" id="" accept="image/">
                        </div>

                        <button type="submit" class="btn-solid theme-accent">Submit</button>

                </form>
            </div>
        </dialog>
    @endif
@endsection
