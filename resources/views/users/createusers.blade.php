@extends('layouts.fo')

@section('content')
    <h1>Criar conta:</h1>

    <form method="POST" action="{{ route('users.store') }}">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nome*</label>
            <input type="text" name="name" class="form-control" id="name" aria-describedby="nameHelp">
            @error('name')
                <p class="error-message">Nome inválido</p>
            @enderror
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email address*</label>
            <input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp">
            <div id="emailHelp" class="form-text">Nunca partilharemos o teu e-mail com ninguém.</div>
            @error('email')
                <p class="error-message">Email inválido</p>
            @enderror
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password*</label>
            <input type="password" name="password" class="form-control" id="password" aria-describedby="passwordHelp">
            <div id="emailHelp" class="form-text">A palavra-passe deve conter pelo menos 8 caracteres.</div>
            @error('password')
                <p class="error-message">Password inválida</p>
            @enderror
        </div>
        <div class="mb-3">
            <label for="photo" class="form-label">Fotografía de perfil:</label>
            <input type="file" name="photo" id="" accept="image/">
        </div>

        <button type="submit" class="btn-solid theme-primary">Submeter</button>
    </form>
@endsection
