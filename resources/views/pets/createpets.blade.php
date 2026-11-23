@extends('layouts.fo')

@section('content')
    <h1>Publicar anuncio:</h1>

    <form method="POST" action="{{ route('pets.store') }}" enctype="multipart/form-data".>
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nome do Animal: *</label>
            <input type="text" name="name" class="form-control" id="name">
            @error('name')
                <p class="error-message">Nome inválido</p>
            @enderror
        </div>
        <div class="mb-3">
            <label for="species" class="form-label">Espécie: *</label>
            <input type="text" name="species" class="form-control" id="species" placeholder="cão, gato, coelho...">
            @error('email')
                <p class="error-message">Espécie inválida</p>
            @enderror
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Descrição:</label>
            <input type="text" name="description" class="form-control" id="description">
            @error('password')
                <p class="error-message">Descrição inválida</p>
            @enderror
        </div>

        <div class="mb-3">
            <label for="city" class="form-label">Cidade: *</label>
            <select name="city" id="city" required>
                <option value="">Escolhe uma cidade</option>
                <option value="Lisboa">Lisboa</option>
                <option value="Porto">Porto</option>
                <option value="Coimbra">Coimbra</option>
                <option value="Faro">Faro</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="photo" class="form-label">Fotografía do animal:</label>
            <input type="file" name="photo" id="" accept="image/">
        </div>

        <button type="submit" class="btn-solid theme-primary">Submeter</button>
    </form>
@endsection
