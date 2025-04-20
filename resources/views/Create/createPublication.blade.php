@extends('administration.dashboard')

@section('title', 'Crear Publicación')

@section('content')
    <link rel="stylesheet" href="{{ asset('CSS/administrationStyle/formularios.css') }}">
    <div class="w-96">
        <form action="{{ route('admin.publication.store') }}" method="POST" class="form-container">
            @csrf
            <h2 class="text-xl font-semibold text-gray-700 text-center">Crear una nueva Publicación</h2>

            <label for="id_user">Usuario:</label>
            <select name="id_user" required>
                <option value="">Selecciona un usuario</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->user_name }}</option>
                @endforeach
            </select><br>

            <div class="item">
                <input type="text" name="title" placeholder="Título" required>
            </div>

            <div class="item">
                <textarea name="publication_description" placeholder="Descripción de la publicación"></textarea>
            </div>

            <div class="item">
                <input type="text" name="publication_image" placeholder="URL de la imagen">
            </div>

            <div class="item">
                <input type="number" name="quota" placeholder="Cupo" min="1" value="1"  required>
            </div>

            <div class="item">
                <input type="text" name="publication_status" placeholder="Estado" required>
            </div>

            <div class="item">
                <input type="text" name="tags" placeholder="Etiquetas (separadas por comas)">
            </div>

            <button type="submit">Crear Publicación</button>
        </form>
    </div>

@endsection