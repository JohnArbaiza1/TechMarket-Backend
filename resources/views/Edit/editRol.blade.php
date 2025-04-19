@extends('administration.dashboard')

@section('title', 'Editar Rol')

@section('content')
    <link rel="stylesheet" href="{{ asset('CSS/administrationStyle/formularios.css') }}">
    <div class="w-96">
        <form method="POST" action="{{ route('roles.update', $roles->id) }}" class="form-container">
            @csrf
            @method('PUT')
            <h2 class="text-xl font-semibold text-gray-700 text-center">Editar Rol</h2>

            <!-- Campo para el nombre del rol -->
            <div class="item">
                <input type="text" name="name" value="{{ old('name', $roles->name) }}" placeholder="Nombre del Rol" required>
            </div>

            <!-- Campo para la descripción del rol -->
            <div class="item">
                <textarea placeholder="Descripción del Rol" name="description">{{ old('description', $roles->description) }}</textarea>
            </div>

            <!-- Campo para el estado del rol -->
            <div class="item">
                <label for="state">Estado</label>
                <select name="state" required>
                    <option value="1" {{ old('state', $roles->state) == 1 ? 'selected' : '' }}>Activo</option>
                    <option value="0" {{ old('state', $roles->state) == 0 ? 'selected' : '' }}>Inactivo</option>
                </select>
            </div>

            <!-- Campo para asignar usuarios -->
            <label for="users" class="block text-sm font-medium text-gray-700 mb-1">Asignar usuarios</label>
            <select name="users[]" id="users" multiple class="w-full border rounded px-3 py-2">
                @foreach($allUsers as $user)
                    <option value="{{ $user->id }}"
                        {{ in_array($user->id, old('users', $assignedUsers)) ? 'selected' : '' }}>
                        {{ $user->user_name }} ({{ $user->email }})
                    </option>
                @endforeach
            </select>

            <button type="submit">Actualizar Rol</button>
        </form>
    </div>
@endsection
