@extends('administration.dashboard')

@section('title', 'Editar Usuario')

@section('content')
    <link rel="stylesheet" href="{{ asset('CSS/administrationStyle/formularios.css') }}">
    <div class="w-96">
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="form-container">
            @csrf
            @method('PUT')
            <h2 class="text-xl font-semibold text-gray-700 text-center">Editar datos de usuario</h2>

            <div class="item">
                <input type="text" name="user_name" value="{{ $user->user_name }}" required>
            </div>

            <div class="item">
                <input type="email" name="email" value="{{ $user->email }}" required>
            </div>

            <div class="item">
                <input type="password" name="user_pass" placeholder="Nueva contraseña">
            </div>

            <div class="item">
                <label for="id_membership">Membresía</label>
                <select name="id_membership" id="id_membership" required>
                    <option value="1" {{ $user->id_membership == 1 ? 'selected' : '' }}>Inicial</option>
                    <option value="2" {{ $user->id_membership == 2 ? 'selected' : '' }}>Pro</option>
                    <option value="3" {{ $user->id_membership == 3 ? 'selected' : '' }}>Inicial Enterprise</option>
                    <option value="4" {{ $user->id_membership == 4 ? 'selected' : '' }}>Pro Enterprise</option>
                    <option value="5" {{ $user->id_membership == 5 ? 'selected' : '' }}>Todo en Uno</option>
                </select>
            </div>
        
            <button type="submit">Actualizar usuario</button>

        </form>
    </div>

@endsection