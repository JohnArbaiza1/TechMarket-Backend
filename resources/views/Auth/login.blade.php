<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TechMarket-API</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="dark:bg-black dark:text-white/50">
    <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
        <img id="background" class="absolute -left-20 top-0 max-w-[877px]" src="https://laravel.com/assets/img/welcome/background.svg" alt="Laravel background" />
        <div class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">

            <main class="mt-6 flex justify-center items-center w-full">
                <div class="flex flex-col justify-center items-center">
                    <h1 style="font-weight: 600;  font-family: Tektur, sans-serif; font-size: 30px; color: #d6d3d3; text-align:center;">TechMarket Conectando con Desarrolladores </h1>
                    <br>
                    <div class="w-full max-w-md p-8 rounded-lg shadow-lg" style="background-color: oklch(0.269 0 0);">
                        <form method="POST" action="{{ route('admin.login') }}" class="mt-6">
                            @csrf
                            <div class="mb-6">
                                <label class="block text-gray-300 mb-1">Usuario</label>
                                <input id="login" type="text" name="login" placeholder="Ingresa tu Email o Usuario" 
                                    class="w-full px-4 py-2 rounded-lg bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            </div>
                        
                            <div class="mb-6">
                                <label class="block text-gray-300 mb-1">Contraseña</label>
                                <input id="password" type="password" name="user_pass" placeholder="••••••••"
                                    class="w-full px-4 py-2 rounded-lg bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            </div>
                        
                            <button type="submit"
                            class="mt-6 w-full text-white font-semibold py-2 rounded-lg transition 
                            bg-[oklch(0.514_0.222_16.935)] hover:bg-[oklch(0.614_0.322_16.935)]">
                                Iniciar sesión
                            </button>
                        </form>
                        <br>
                    </div>
                </div>
            </main>
        </div>

    </div>
</body>
</html>