@extends('administration.dashboard')

@section('title', 'Publicaciones')

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
            <a href="#"
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
                    <th class="py-3 px-4 border-b">user id</th>
                    <th class="py-3 px-4 border-b">Title</th>
                    <th class="py-3 px-4 border-b">Description</th>
                    <th class="py-3 px-4 border-b">IMG</th>
                    <th class="py-3 px-4 border-b">Quota</th>
                    <th class="py-3 px-4 border-b">Publication Status</th>
                    <th class="py-3 px-4 border-b">Tags</th>
                    <th class="py-3 px-4 border-b">options</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @foreach($publication as $item)
                <tr class="hover:bg-gray-100">
                    <td class="py-3 px-4 border-b">{{ $item->id }}</td>
                    <td class="py-3 px-4 border-b">{{ $item->id_user }}</td>
                    <td class="py-3 px-4 border-b">{{ $item->title }}</td>
                    <td class="py-3 px-4 border-b">{{ $item->publication_description }}</td>
                    <td class="py-3 px-4 border-b">{{ $item->publication_image }}</td>
                    <td class="py-3 px-4 border-b">{{ $item->quota }}</td>
                    <td class="py-3 px-4 border-b">{{ $item->publication_status }}</td>
                    <td class="py-3 px-4 border-b">{{ $item->tags }}</td>
                    <td class="py-3 px-4 border-b">
                        <div class="flex flex-col space-y-2">
                            <!-- Botón Editar -->
                            <a href="" class="bg-[#5E308C] text-white px-4 py-2 rounded hover:bg-[#4a1f6a]">Editar</a>
                    
                            <!-- Botón Eliminar -->
                            <form action="" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este usuario?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                class="bg-[#BC522B] text-white px-4 py-2 rounded hover:bg-[#9e3d1c]">Eliminar</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach            
            </tbody>
        </table>
    </div>
@endsection
