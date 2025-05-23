@extends('administration.dashboard')

@section('title', 'Usuarios')

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
            <a href="{{ route('Create.createUser') }}"
                class="bg-morado-clarisimo text-white px-4 py-2 rounded hover:bg-[#4a1f6a]" onclick="messageDashboard('otras')">
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
                    <th class="py-3 px-4 border-b">Email</th>
                    <th class="py-3 px-4 border-b">ID Plan</th>
                    <th class="py-3 px-4 border-b">Membership Status</th>
                    <th class="py-3 px-4 border-b">options</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @foreach($users as $user)
                    <tr class="hover:bg-gray-100">
                        <td class="py-3 px-4 border-b">{{ $user->id }}</td>
                        <td class="py-3 px-4 border-b">{{ $user->user_name }}</td>
                        <td class="py-3 px-4 border-b">{{ $user->email }}</td>
                        <td class="py-3 px-4 border-b">{{ $user->id_membership }}</td>
                        <td class="py-3 px-4 border-b">{{ $user->membership_status }}</td>
                        <td class="py-3 px-4 border-b flex space-x-2">
                            <!-- Botón Editar -->
                            <a href="{{ route('Edit.editUser', ['id' => $user->id]) }}" class="bg-[#5E308C] text-white px-4 py-2 rounded hover:bg-[#4a1f6a]" onclick="messageDashboard('otras')">Editar</a>

                            <!-- Botón Eliminar -->
                            <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este usuario?');">
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
    <div class="mt-4">
        {{ $users->withQueryString()->links() }}
    </div>
@endsection
