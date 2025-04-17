@extends('administration.dashboard')

@section('title', 'Planes')

@section('content')
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-300 rounded shadow-md">
            <thead class="bg-morado-oscuro text-white uppercase text-sm">
                <tr>
                    <th class="py-3 px-4 border-b">ID</th>
                    <th class="py-3 px-4 border-b">Name</th>
                    <th class="py-3 px-4 border-b">Price</th>
                    <th class="py-3 px-4 border-b">Description</th>
                    <th class="py-3 px-4 border-b">Opciones</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @foreach($planes as $item)
                <tr class="hover:bg-gray-100">
                    <td class="py-3 px-4 border-b">{{ $item->id }}</td>
                    <td class="py-3 px-4 border-b">{{ $item->membership_name }}</td>
                    <td class="py-3 px-4 border-b">${{ number_format($item->price, 2) }}</td>
                    <td class="py-3 px-4 border-b">{{ $item->membership_description }}</td>
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