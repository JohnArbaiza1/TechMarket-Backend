@extends('administration.dashboard')

@section('title', 'Crear Rol')

@section('content')
    <link rel="stylesheet" href="{{ asset('CSS/administrationStyle/formularios.css') }}">
    <div class="w-96">
        <form method="POST" action="{{ route('roles.store') }}" class="form-container">
            @csrf
            <h2 class="text-xl font-semibold text-gray-700 text-center">Crear nuevo Rol</h2>

            <div class="item">
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Nombre del Rol" required>
            </div>

            <div class="item">
                <textarea placeholder=" Descripción del Rol" name="description">{{ old('description') }}</textarea>
            </div>

            <div class="item">
                <label for="state">Estado</label>
                <select name="state" required>
                    <option value="1">Activo</option>
                    <option value="0">Inactivo</option>
                </select>
            </div>

            <label for="users" class="block text-sm font-medium text-gray-700 mb-1">Asignar usuarios</label>
            <select name="users[]" id="users" multiple class="w-full border rounded px-3 py-2">
                @foreach($allUsers as $user)
                    <option value="{{ $user->id }}"
                        {{ in_array($user->id, old('users', [])) ? 'selected' : '' }}>
                        {{ $user->user_name }} ({{ $user->email }})
                    </option>
                @endforeach
            </select>

            <button type="submit">Crear Rol</button>

        </form>
    </div>

@endsection