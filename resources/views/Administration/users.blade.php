@extends('administration.dashboard')

@section('title', 'Usuarios')

@section('content')
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-300 rounded shadow-md">
            <thead class="bg-gray-200 text-gray-700 uppercase text-sm">
                <tr>
                    <th class="py-3 px-4 border-b">ID</th>
                    <th class="py-3 px-4 border-b">Nombre</th>
                    <th class="py-3 px-4 border-b">Email</th>
                    <th class="py-3 px-4 border-b">ID Plan</th>
                    <th class="py-3 px-4 border-b">Opciones</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @foreach($users as $user)
                    <tr class="hover:bg-gray-100">
                        <td class="py-3 px-4 border-b">{{ $user->id }}</td>
                        <td class="py-3 px-4 border-b">{{ $user->user_name }}</td>
                        <td class="py-3 px-4 border-b">{{ $user->email }}</td>
                        <td class="py-3 px-4 border-b">{{ $user->id_membership }}</td>
                        <td class="py-3 px-4 border-b flex space-x-2">
                            <!-- Botón Editar -->
                            <a href="" class="bg-[#5E308C] text-white px-4 py-2 rounded hover:bg-[#4a1f6a]">Editar</a>

                            <!-- Botón Eliminar -->
                            <form action="" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este usuario?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                class="bg-[#BC522B] text-white px-4 py-2 rounded hover:bg-[#9e3d1c]">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
