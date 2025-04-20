<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- Fuentes y Iconos --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@100..900&family=Tektur:wght@400..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    {{-- Estilos --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('CSS/administrationStyle/dashboard.css') }}">
    <title>TechMarket-Dashboard</title>
</head>
<body>
    <section class="flex h-screen">
        <!-- Sidebar -->
        <div id="sidebar" class="w-64 bg-white shadow-xl dark:bg-[#242424] transition-all duration-300">
            <ul class="p-4 space-y-6">
                <li>
                    <div class="logo-container border-b border-white-200">
                        <span class="logo-title opciones">TechMarket</span>
                    </div>
                </li>
                <li>
                    <a href="{{route('administration.dashboard')}}" class="flex items-center space-x-2 py-2 px-4 hover:bg-morado-claro rounded-md" onclick="messageDashboard('inicio')">
                        <i class="fa-solid fa-house icon"></i>
                        <span class="opciones">Home</span>
                    </a>
                </li>

                @if(auth()->user()->hasRole('admin'))
                    <li>
                        <a href="{{route('administration.users')}}" class="flex items-center space-x-2 py-2 px-4 hover:bg-morado-claro rounded-md" onclick="messageDashboard('usuarios')">
                            <i class="fa-solid fa-users icon"></i>
                            <span class="opciones">Usuarios</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{route('administration.roles')}}" class="flex items-center space-x-2 py-2 px-4 hover:bg-morado-claro rounded-md" onclick="messageDashboard('rol')">
                            <i class="fa-solid fa-sitemap icon"></i>
                            <span class="opciones">Roles</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{route('administration.planes')}}" class="flex items-center space-x-2 py-2 px-4 hover:bg-morado-claro rounded-md" onclick="messageDashboard('planes')">
                            <i class="fa-solid fa-money-check-dollar icon"></i>
                            <span class="opciones">Planes</span>
                        </a>
                    </li>
                @endif

                <li>
                    <a href="{{route('administration.profile')}}" class="flex items-center space-x-2 py-2 px-4 hover:bg-morado-claro rounded-md" onclick="messageDashboard('perfiles')">
                        <i class="fa-solid fa-id-badge icon"></i>
                        <span class="opciones">Perfiles</span>
                    </a>
                </li>

                <li>
                    <a href="{{route('administration.publication')}}" class="flex items-center space-x-2 py-2 px-4 hover:bg-morado-claro rounded-md" onclick="messageDashboard('publicaciones')">
                        <i class="fa-solid fa-share icon"></i>
                        <span class="opciones">Publicaciones</span>
                    </a>
                </li>

                <li>
                    <a href="http://localhost:5173/principal" class="flex items-center space-x-2 py-2 px-4 hover:bg-morado-claro rounded-md">
                        <i class="fa-solid fa-desktop icon"></i>
                        <span class="opciones">Plataforma</span>
                    </a>
                </li>

                <li>
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button onclick="messageDashboard('cerrar sesion')" type="submit" class="w-full text-left flex items-center space-x-2 py-2 px-4 hover:bg-morado-claro rounded-md text-red-500">
                            <i class="fa-solid fa-sign-out-alt icon"></i>
                            <span class="opciones">Cerrar sesión</span>
                        </button>
                    </form>
                </li>
            </ul>
        </div>

        <!-- Contenedor principal -->
        <div class="flex-1 flex flex-col">
            <!-- Navbar -->
            <div class="bg-white shadow-md px-6 py-4 flex justify-between items-center">
                <!-- Botón de colapsar -->
                <button onclick="toggleSidebar()" class="text-gray-600 hover:text-blue-600 focus:outline-none mr-4">
                    <i class="fa-solid fa-bars"></i>
                </button>

                <div class="ml-auto relative">
                    <button onclick="toggleDropdown()" class="flex items-center space-x-2 hover:text-blue-600 focus:outline-none">
                        <img 
                            src="{{ auth()->user()->profile->image_url ?? asset('images/default-profile.png') }}" 
                            alt="Perfil" 
                            class="w-8 h-8 rounded-full object-cover"
                        >
                            <span>{{ auth()->user()->user_name }}</span>
                        <i class="fa-solid fa-chevron-down text-sm"></i>
                    </button>

                    <!-- Dropdown -->
                    <div id="dropdownMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg border z-50 transition-all duration-150 ease-in-out">
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Ajustes</a>
                        <div class="border-t my-1"></div>
                        <form method="POST" action="{{ route('admin.logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-red-600 hover:bg-red-100">
                                Cerrar sesión
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Contenido principal -->
            <div class="flex-1 p-6 overflow-auto">
                <hr class="mb-6">
                <div id="content">
                    <div class="datos flex justify-center items-center h-full text-center">
                        @php $mensaje = ''; @endphp
                        @if(!empty($mensaje))
                            <h1 id="mensaje">{{ $mensaje }}</h1>
                        @else
                            <h1 id="mensaje" class="text-2xl font-semibold mb-4">Hola {{ auth()->user()->user_name }} ¡Qué bueno verte de nuevo!</h1>
                        @endif
                        <div id="content">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Parte de los Scripts --}}
    <script src="{{ asset('JS/dashboard.js') }}"></script>
    <script>
        function toggleDropdown() {
            const menu = document.getElementById('dropdownMenu');
            menu.classList.toggle('hidden');
        }

        window.addEventListener('click', function(e) {
            const dropdown = document.getElementById('dropdownMenu');
            const button = document.querySelector('button[onclick="toggleDropdown()"]');
            if (!dropdown.contains(e.target) && !button.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const opciones = document.querySelectorAll('.opciones');

            sidebar.classList.toggle('w-64');
            sidebar.classList.toggle('w-20');

            opciones.forEach(opcion => {
                opcion.classList.toggle('hidden');
            });
        }
    </script>
</body>
</html>