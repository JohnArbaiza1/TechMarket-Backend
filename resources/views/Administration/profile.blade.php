@extends('administration.dashboard')

@section('title', 'Perfiles de Usuarios')

@section('content')
    <div class="mb-4">
        <form method="GET" class="flex items-center space-x-2">
            <input type="text" name="search" placeholder="Buscar Perfil de usuario..." value="{{ request('search') }}"
                class="border border-gray-300 rounded px-4 py-2 w-full max-w-sm focus:outline-none focus:ring-2 focus:ring-[#5E308C]">
            <button type="submit"
                    class="bg-morado-clarisimo text-white px-4 py-2 rounded hover:bg-[#4a1f6a]">
                Buscar
            </button>

            <a href="{{ route('Create.createProfile') }}"
                class="bg-morado-clarisimo text-white px-4 py-2 rounded hover:bg-[#4a1f6a]" onclick="messageDashboard('otras')">
                Agregar
            </a>
        </form>
    </div>
    <div class="hidden md:block overflow-x-auto">
        <table class="min-w-[1000px] bg-white border border-gray-300 rounded shadow-md">
            <thead class="bg-morado-oscuro text-white uppercase text-sm">
                <tr>
                    <th class="py-3 px-4 border-b">first name</th>
                    <th class="py-3 px-4 border-b">Last Name</th>
                    <th class="py-3 px-4 border-b">Phone number</th>
                    <th class="py-3 px-4 border-b">address</th>
                    <th class="py-3 px-4 border-b">education</th>
                    <th class="py-3 px-4 border-b">work experience</th>
                    <th class="py-3 px-4 border-b">skills</th>
                    <th class="py-3 px-4 border-b">image</th>
                    <th class="py-3 px-4 border-b">options</th>

                </tr>
            </thead>
            <tbody class="text-gray-700">
                @foreach($profile as $item)
                    @if(!(auth()->user()->hasRole('editor') && $item->user->hasRole('admin')))
                    <tr class="hover:bg-gray-100">
                        {{-- <td class="py-3 px-4 border-b">{{ $user->id }}</td> --}}
                        <td class="py-3 px-4 border-b">{{ $item->first_name }}</td>
                        <td class="py-3 px-4 border-b">{{ $item->last_name }}</td>
                        <td class="py-3 px-4 border-b">{{ $item->phone_number }}</td>
                        <td class="py-3 px-4 border-b">{{ $item->address }}</td>
                        <td class="py-3 px-4 border-b">{{ $item->education }}</td>
                        <td class="py-3 px-4 border-b">{{ $item->work_experience}}</td>
                        <td class="py-3 px-4 border-b">{{ $item->skills}}</td>
                        <td class="py-3 px-4 border-b">
                            <img src="{{ $item->image_url }}" alt="Imagen de perfil" class="w-16 h-16 object-cover rounded">
                        </td>
                        

                        <td class="py-3 px-4 border-b">
                            <div class="flex flex-col space-y-2">
                                <!-- Botón Editar -->
                                <a href="{{route('Edit.editProfile', $item->id)}}" class="bg-[#5E308C] text-white px-4 py-2 rounded hover:bg-[#4a1f6a]" onclick="messageDashboard('otras')">Editar</a>
                        
                                <!-- Botón Eliminar -->
                                <form action="{{route('admin.profile.delete', $item->id)}}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este usuario?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                    class="bg-[#BC522B] text-white px-4 py-2 rounded hover:bg-[#9e3d1c]">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endif
                @endforeach 
            </tbody>
        </table>
    </div>

        <!-- Versión móvil como tarjetas -->
    <div class="block md:hidden">
        @foreach($profile as $item)
            <div class="bg-white border border-gray-300 rounded shadow-md p-4 mb-4">
                <p><strong>First Name:</strong> {{ $item->first_name }}</p>
                <p><strong>Last Name:</strong> {{ $item->last_name }}</p>
                <p><strong>Phone:</strong> {{ $item->phone_number }}</p>
                <p><strong>Address:</strong> {{ $item->address }}</p>
                <p><strong>Education:</strong> {{ $item->education }}</p>
                <p><strong>Work Experience:</strong> {{ $item->work_experience }}</p>
                <p><strong>Skills:</strong> {{ $item->skills }}</p>
                <p><strong>Image URL:</strong> {{ $item->image_url }}</p>
                <div class="flex space-x-2 mt-2">
                    <a href="{{route('Edit.editProfile', $item->id)}}" class="bg-[#5E308C] text-white px-4 py-2 rounded hover:bg-[#4a1f6a]">Editar</a>
                    <form action="{{ route('admin.profile.delete', $item->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-[#BC522B] text-white px-4 py-2 rounded hover:bg-[#9e3d1c]">Eliminar</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
    <div class="mt-4">
        {{ $profile->withQueryString()->links() }}
    </div>
@endsection
