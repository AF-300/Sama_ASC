<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@500;600&display=swap" rel="stylesheet">
    <head>
        <meta charset="utf-8">
        <link rel="icon" type="image/png" href="{{ asset('logo_ASC.jpg') }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="manifest" href="{{ asset('manifest.json') }}">
<meta name="theme-color" content="#14231C">

<script>
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', () => {
            navigator.serviceWorker.register('/sw.js');
        });
    }
</script>

<script>
    async function mettreAJourBadge() {
        if (!('setAppBadge' in navigator)) return;

        try {
            const response = await fetch('{{ route('badge.count') }}');
            const data = await response.json();

            if (data.count > 0) {
                navigator.setAppBadge(data.count);
            } else {
                navigator.clearAppBadge();
            }
        } catch (e) {
            // Echec silencieux, pas grave si le badge ne se met pas a jour
        }
    }

    // Verifie au chargement de la page
    mettreAJourBadge();

    // Puis toutes les 60 secondes tant que la page est ouverte
    setInterval(mettreAJourBadge, 60000);
</script>
    </head>
   <body class="font-sans antialiased bg-blanc-sable overflow-x-hidden">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
