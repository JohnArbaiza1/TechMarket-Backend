@extends('administration.dashboard')

@section('title', 'Editar Perfil')

@section('content')
    <link rel="stylesheet" href="{{ asset('CSS/administrationStyle/formularios.css') }}">
    <div class="w-96">
        <form action="{{ route('admin.profile.update', $profile->id) }}" method="POST" class="form-container">
            @csrf
            @method('PUT')
            <h2 class="text-xl font-semibold text-gray-700 text-center">Editar Perfil</h2>

            <label for="id_user">Usuario:</label>
            <select name="id_user" required>
                <option value="">Selecciona un usuario</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ $profile->id_user == $user->id ? 'selected' : '' }}>
                        {{ $user->user_name }}
                    </option>
                @endforeach
            </select><br>

            <div class="form-row">
                <div class="form-group">
                    <input type="text" name="first_name" placeholder="First name" value="{{ old('first_name', $profile->first_name) }}" required>
                </div>
                <div class="form-group">
                    <input type="text" name="last_name" placeholder="Last name" value="{{ old('last_name', $profile->last_name) }}">
                </div>
            </div>

            <div class="item">
                <input type="text" name="phone_number" placeholder="Phone number" value="{{ old('phone_number', $profile->phone_number) }}">
            </div>

            <div class="item">
                <input type="text" name="address" placeholder="Address" value="{{ old('address', $profile->address) }}">
            </div>

            <div class="item">
                <textarea name="description" placeholder="Description">{{ old('description', $profile->description) }}</textarea>
            </div>

            <div class="item">
                <input type="text" name="image_url" placeholder="Image URL" value="{{ old('image_url', $profile->image_url) }}">
            </div>

            <div class="item">
                <input type="text" name="education" placeholder="Education" value="{{ old('education', $profile->education) }}">
            </div>

            <div class="item">
                <input type="text" name="work_experience" placeholder="Work experience" value="{{ old('work_experience', $profile->work_experience) }}">
            </div>

            <div class="item">
                <input type="text" name="skills" placeholder="Skills" value="{{ old('skills', $profile->skills) }}">
            </div>

            <div class="item">
                <input type="text" name="social_media_links" placeholder="Links to social networks" value="{{ old('social_media_links', $profile->social_media_links) }}">
            </div>

            <button type="submit">Actualizar Perfil</button>

        </form>
    </div>
@endsection
