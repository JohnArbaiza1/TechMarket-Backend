@extends('administration.dashboard')

@section('title', 'Editar Membresía')

@section('content')
    <link rel="stylesheet" href="{{ asset('CSS/administrationStyle/formularios.css') }}">
    <div class="w-96">
        <form action="{{ route('admin.planes.update', $membership->id) }}" method="POST" class="form-container">
            @csrf
            @method('PUT')
            <h2 class="text-xl font-semibold text-gray-700 text-center">Editar Membresía</h2>

            <div class="item">
                <input type="text" name="membership_name" placeholder="Nombre del plan" value="{{ $membership->membership_name }}" required>
            </div>

            <div class="item">
                <textarea name="membership_description" placeholder="Descripción">{{ $membership->membership_description }}</textarea>
            </div>

            <div class="item">
                <input type="number" step="0.01" name="price" placeholder="Precio" value="{{ $membership->price }}" required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    {{-- Si no se marca, se envía 0 --}}
                    <input type="hidden" name="unlimited_applications" value="0">
                    <label>
                        <input type="checkbox" name="unlimited_applications" value="1" {{ $membership->unlimited_applications ? 'checked' : '' }}>
                        Aplicaciones ilimitadas
                    </label><br>
                </div>
                <div class="form-group">
                    {{-- Si no se marca, se envía 0 --}}
                    <input type="hidden" name="unlimited_publications" value="0">
                    <label>
                        <input type="checkbox" name="unlimited_publications" value="1" {{ $membership->unlimited_publications ? 'checked' : '' }}>
                        Publicaciones ilimitadas
                    </label><br>
                </div>
            </div>

            <button type="submit">Actualizar Plan</button>
        </form>
    </div>
@endsection
