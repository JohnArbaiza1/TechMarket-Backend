<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- Fuentes y Iconos  --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&family=Tektur:wght@400..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    {{-- Estilos --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('CSS/administrationStyle/dashboard.css')}}">
    <title>TechMarket-Dashboard</title>
</head>
<body>
    <section class="flex h-screen">
        <!--sidebar-->
        <div class="w-64 bg-white shadow-xl dark:bg-[#242424]">
            <ul class="p-4 space-y-6">
                <li>
                    <div class="logo-container border-b border-white-200 ">
                        <span class="logo-title">TechMarket</span>
                    </div>
                </li>
                <li>
                    <a href="#" class="flex items-center space-x-2 py-2 px-4 transition delay-150 duration-300 ease-in-out hover:-translate-y-1 hover:scale-110 hover:bg-morado-claro rounded-md"
                        onclick="messageDashboard('inicio')">
                        <i class="fa-solid fa-house icon"></i>
                        <span class="opciones">Home</span>
                    </a>
                </li>
                <li class="mb-1">
                    <a href="{{route("usuarios")}}" class="flex items-center space-x-2 py-2 px-4 transition delay-150 duration-300 ease-in-out hover:-translate-y-1 hover:scale-110 hover:bg-morado-claro rounded-md"
                        onclick="messageDashboard('usuarios')">
                        <i class="fa-solid fa-users icon"></i>
                        <span class="opciones">Usuarios</span>
                    </a>
                </li>
                <li class="mb-1">
                    <a href="#" class="flex items-center space-x-2 py-2 px-4 transition delay-150 duration-300 ease-in-out hover:-translate-y-1 hover:scale-110 hover:bg-morado-claro rounded-md"
                        onclick="messageDashboard('perfiles')">
                        <i class="fa-solid fa-id-badge icon"></i>
                        <span class="opciones">Perfiles</span>
                    </a>
                </li>
                <li class="mb-1">
                    <a href="#" class="flex items-center space-x-2 py-2 px-4 transition delay-150 duration-300 ease-in-out hover:-translate-y-1 hover:scale-110 hover:bg-morado-claro rounded-md"
                        onclick="messageDashboard('publicaciones')">
                        <i class="fa-solid fa-share icon"></i>
                        <span class="opciones">Publicaciones</span>
                    </a>
                </li>
                <li class="mb-1">
                    <a href="#" class="flex items-center space-x-2 py-2 px-4 transition delay-150 duration-300 ease-in-out hover:-translate-y-1 hover:scale-110 hover:bg-morado-claro rounded-md"
                        onclick="messageDashboard('planes')">
                        <i class="fa-solid fa-money-check-dollar icon"></i>
                        <span class="opciones">Planes</span>
                    </a>
                </li>

                <li class="mb-1">
                    <a href="#" class="flex items-center space-x-2 py-2 px-4 transition delay-150 duration-300 ease-in-out hover:-translate-y-1 hover:scale-110 hover:bg-morado-claro rounded-md"
                        onclick="messageDashboard('cerrar sesion')">
                        <i class="fa-solid fa-sign-out-alt icon"></i>
                        <span class="opciones">Cerrar sesión</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Fin del sidebar -->

        <!-- Contenedor principal con Flex para Navbar y Contenido -->
        <div class="flex-1 flex flex-col">
            <!-- Navbar -->
            <div class="bg-white shadow-md px-6 py-4 flex justify-between items-center">
                <div class="ml-auto relative">
                    <button onclick="toggleDropdown()" class="flex items-center space-x-2 hover:text-blue-600 focus:outline-none">
                        <i class="fa-solid fa-user"></i>
                        <span>Admin</span>
                        <i class="fa-solid fa-chevron-down text-sm"></i>
                    </button>
            
                    <!-- Dropdown -->
                    <div id="dropdownMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg border z-50 transition-all duration-150 ease-in-out">
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Perfil</a>
                        <div class="border-t my-1"></div>
                        <a href="#" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-100">Cerrar sesión</a>
                    </div>
                </div>
            </div>
            <!-- Fin del Navbar -->

            <!-- Contenido Principal (mensaje de bienvenida) -->
            <div class="flex-1 p-6 overflow-auto">
                <hr class="mb-6">
                <div id="content">
                    <div class="datos flex justify-center items-center h-full text-center">
                        <!-- Definimos una variable para el mensaje a mostrar -->
                        @php
                            $mensaje = '';
                        @endphp
                        <!-- Verificamos si la variable mensaje no está vacía -->
                        @if(!empty($mensaje))
                            <!-- Si mensaje tiene contenido, se mostramos un encabezado con dicho mensaje -->
                            <h1 id="mensaje">{{ $mensaje }}</h1>
                            <hr>
                        @else
                            <!-- Si mensaje está vacío mostramos un mensaje de bienvenida por defecto -->
                            <h1 id="mensaje" class="text-2xl font-semibold mb-4">Bienvenido</h1>
                            <hr>
                        @endif
                        <div id="content">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Fin del contenedor principal -->
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
    </script>
</body>
</html>