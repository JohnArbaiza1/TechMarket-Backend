@extends('administration.dashboard')

@section('title', 'Crear Usuario')

@section('content')
    <link rel="stylesheet" href="{{ asset('CSS/administrationStyle/formularios.css') }}">
    <div class="w-96">
        <form action="{{ route('admin.users.store') }}"  method="POST" class="form-container">
            @csrf
            <h2 class="text-xl font-semibold text-gray-700 text-center">Crear nuevo usuario</h2>

            <div class="item">
                <input type="text" name="user_name" id="user_name" placeholder="Nombre de usuario" required>
            </div>

            <div class="item">
                <input type="email" name="email" id="email" placeholder="Correo electrónico" required>
            </div>

            <div class="item">
                <input type="password" name="user_pass" id="user_pass" placeholder="Contraseña" required>
            </div>

            <div class="item">
                <label for="id_membership">Membresía</label>
                <select name="id_membership" id="id_membership" required>
                    <option value="1">Inicial</option>
                    <option value="2">Pro</option>
                    <option value="3">Inicial Enterprise</option>
                    <option value="4">Pro Enterprise</option>
                    <option value="5">Todo en Uno</option>
                </select>
            </div>
        
            <button type="submit">Crear usuario</button>

        </form>
    </div>

@endsection