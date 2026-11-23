@extends('layouts.fo')

@section('content')
    <h2>Detalhes do Utilizador {{ $userInfo->name }}</h2>
    <img class="photo-profile"
        src="{{ $userInfo->photo ? asset('storage/' . $userInfo->photo) : asset('images/nouserphoto.png') }}" alt="">
    <p><b>Nome: </b>{{ $userInfo->name }}</p>
    <p><b>Email: </b>{{ $userInfo->email }}</p>

    @if (Auth::user() && (Auth::user()->id == $userInfo->id || Auth::user()->user_type == \App\Models\User::TYPE_ADMIN))
        <button type="button" class="btn-solid theme-accent" data-bs-toggle="dialog" data-bs-target="#exampleDialog">
            Editar Dados
        </button>
        <dialog class="dialog" id="exampleDialog">
            <div class="dialog-header">
                <h1 class="dialog-title">Editar Dados do Utilizador</h1>
                <button type="button" class="btn-close" data-bs-dismiss="dialog" aria-label="Close"></button>
            </div>
            <div class="dialog-body">
                <form method="POST" enctype="multipart/form-data" action="{{ route('users.update') }}">
                    @method('PUT')
                    @csrf
                    <input type="hidden" name="id" value="{{ $userInfo->id }}">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Nome</label>
                        <input value="{{ $userInfo->name }}" required type="text" name="name" class="form-control"
                            id="exampleInputEmail1" aria-describedby="emailHelp">
                    </div>
                    @error('name')
                        <p>Nome inválido</p>
                    @enderror

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email address</label>
                        <input value="{{ $userInfo->email }}" disabled type="email" name="email" class="form-control"
                            id="exampleInputEmail1" aria-describedby="emailHelp">
                        <div id="emailHelp" class="form-text">Nunca partilharemos o teu e-mail com ninguém.</div>
                    </div>
                    @error('email')
                        <p>email inválido</p>
                    @enderror

                    <div class="mb-3">
                        <label for="photo"><b>Fotografía: </b></label>

                        <input value="{{ $userInfo->photo }}" type="file" name="photo" id="photo" accept="image/">
                    </div>

                    <button type="submit" class="btn-solid theme-accent">Submit</button>

                </form>
            </div>
        </dialog>
    @endif
@endsection
