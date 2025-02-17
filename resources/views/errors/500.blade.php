<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    {{-- <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script> --}}
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />

    @vite('resources/css/style.css')
    @vite('resources/css/app.css')
    <title>CMS</title>
    <!-- Styles -->
    @livewireStyles
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen font-inter">

    <div class="text-center">
        <h1 class="text-9xl font-bold text-gray-800">500</h1>
        <p class="text-2xl font-medium text-gray-600 mt-4">Oops! Terjadi Kesalahan.</p>
        <p class="text-gray-500 mt-2">Maaf, terjadi kesalahan pada server. Mohon coba lagi nanti.</p>
        <a href="/"
            class="mt-6 inline-block px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition duration-300">
            Kembali ke Beranda
        </a>
    </div>

    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>

    @stack('scripts')
    @yield('scripts')
    @livewireScripts


</body>

</html>
