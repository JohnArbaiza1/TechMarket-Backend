@extends('administration.dashboard')

@section('title', 'Editar Publicación')

@section('content')
<link rel="stylesheet" href="{{ asset('CSS/administrationStyle/formularios.css') }}">
<div class="w-96">
    <form action="{{ route('admin.publication.update', $publication->id) }}" method="POST" class="form-container">
        @csrf
        @method('PUT')
        <h2 class="text-xl font-semibold text-gray-700 text-center">Editar Publicación</h2>

        <label for="id_user">Usuario:</label>
        <select disabled class="opacity-50 cursor-not-allowed">
            @foreach($users as $user)
                <option value="{{ $user->id }}" {{ $publication->id_user == $user->id ? 'selected' : '' }}>
                    {{ $user->user_name }}
                </option>
            @endforeach
        </select>
        
        <!-- Campo oculto para mantener el valor -->
        <input type="hidden" name="id_user" value="{{ $publication->id_user }}">

        <div class="item">
            <input type="text" name="title" value="{{ $publication->title }}" placeholder="Título" required>
        </div>

        <div class="item">
            <textarea name="publication_description" placeholder="Descripción de la publicación">{{ $publication->publication_description }}</textarea>
        </div>

        <div class="item">
            <input type="text" name="publication_image" value="{{ $publication->publication_image }}" placeholder="URL de la imagen">
        </div>

        <div class="item">
            <input type="number" name="quota" value="{{ $publication->quota }}" placeholder="Cupo" required>
        </div>

        <div class="item">
            <input type="text" name="publication_status" value="{{ $publication->publication_status }}" placeholder="Estado (activo, inactivo...)" required>
        </div>

        <div class="item">
            <input type="number" name="publication_rating" step="0.1" value="{{ $publication->publication_rating }}" placeholder="Rating (opcional)">
        </div>

        <div class="item">
            <input type="text" name="tags" value="{{ $publication->tags }}" placeholder="Etiquetas (separadas por comas)">
        </div>

        <button type="submit">Actualizar Publicación</button>
    </form>
</div>
@endsection
