@extends('administration.dashboard')

@section('title', 'Crear Perfil')

@section('content')
    <link rel="stylesheet" href="{{ asset('CSS/administrationStyle/formularios.css') }}">
    <div class="w-96">
        <form action="{{ route('admin.profile.store') }}"  method="POST" class="form-container">
            @csrf
            <h2 class="text-xl font-semibold text-gray-700 text-center">Crear un nuevo Perfil</h2>

            <label for="id_user">Usuario:</label>
            <select name="id_user" required>
                <option value="">Selecciona un usuario</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->user_name }}</option>
                @endforeach
            </select><br>

            <div class="form-row">
                <div class="form-group">
                    <input type="text" name="first_name" placeholder="First name" required>
                </div>
                <div class="form-group">
                    <input type="text" name="last_name" placeholder="Last name">
                </div>
            </div>


            <div class="item">
                <input type="text" name="phone_number" placeholder="Phone number">
            </div>

            <div class="item">
                <input type="text" name="address" placeholder="Address">
            </div>

            <div class="item">
                <textarea name="description" placeholder="Description"></textarea>
            </div>

            <div class="item">
                <input type="text" name="image_url" placeholder="Image URL">
            </div>

            <div class="item">
                <input type="text" name="education" placeholder="Education">
            </div>

            <div class="item">
                <input type="text" name="work_experience" placeholder="work experience">
            </div>

            <div class="item">
                <input type="text" name="skills" placeholder="skills">
            </div>
            
            <div class="item">
                <input type="text" name="social_media_links" placeholder="links to social networks">
            </div>

            <button type="submit">Crear Perfil</button>

        </form>
    </div>

@endsection