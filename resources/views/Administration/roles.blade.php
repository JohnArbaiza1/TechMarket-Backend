@extends('administration.dashboard')

@section('title', 'Roles')

@section('content')
    <br>
    <div class="mb-4">
        <form method="GET" class="flex items-center space-x-2">
            <input type="text" name="search" placeholder="Buscar usuario..." value="{{ request('search') }}"
                class="border border-gray-300 rounded px-4 py-2 w-full max-w-sm focus:outline-none focus:ring-2 focus:ring-[#5E308C]">
            
            <button type="submit"
                    class="bg-morado-clarisimo text-white px-4 py-2 rounded hover:bg-[#4a1f6a]">
                Buscar
            </button>

            <!-- Botón Agregar -->
            <a href=""
                class="bg-morado-clarisimo text-white px-4 py-2 rounded hover:bg-[#4a1f6a]">
                Agregar
            </a>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-300 rounded shadow-md">
            <thead class="bg-morado-oscuro text-white uppercase text-sm">
                <tr>
                    <th class="py-3 px-4 border-b">ID</th>
                    <th class="py-3 px-4 border-b">Name</th>
                    <th class="py-3 px-4 border-b">Description</th>
                    <th class="py-3 px-4 border-b">State</th>
                    <th class="py-3 px-4 border-b">Assigned Users</th>
                    <th class="py-3 px-4 border-b">Options</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @foreach($roles as $rol)
                    <tr class="hover:bg-gray-100">
                        <td class="py-3 px-4 border-b">{{ $rol->id }}</td>
                        <td class="py-3 px-4 border-b">{{ $rol->name }}</td>
                        <td class="py-3 px-4 border-b">{{ $rol->description }}</td>
                        <td class="py-3 px-4 border-b">
                            <span class="{{ $rol->state ? 'text-green-600' : 'text-red-600' }}">
                                {{ $rol->state ? 'Activo' : 'Inactivo' }}
                            </span>
                        </td>
                        <td class="py-3 px-4 border-b">
                            @if($rol->users->count())
                                <ul class="list-disc list-inside text-sm mt-1">
                                    @foreach($rol->users as $user)
                                        <li>{{ $user->name }} ({{ $user->email }})</li>
                                    @endforeach
                                </ul>
                            @else
                                <span class="text-gray-500 text-sm">Sin usuarios</span>
                            @endif
                        </td>
                        <td class="py-3 px-4 border-b flex space-x-2">
                            <!-- Botón Editar -->
                            <a href="" class="bg-[#5E308C] text-white px-4 py-2 rounded hover:bg-[#4a1f6a]">
                                Editar
                            </a>

                            <!-- Botón Eliminar -->
                            <form action="" method="POST" 
                                onsubmit="return confirm('¿Estás seguro de que deseas eliminar este rol?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                    class="bg-[#BC522B] text-white px-4 py-2 rounded hover:bg-[#9e3d1c]">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
