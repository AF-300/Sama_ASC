<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Sama ASC') }}</title>

    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@500;600&display=swap" rel="stylesheet">

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
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen flex">

        {{-- Panneau de marque (cache sur mobile) --}}
        <div class="hidden lg:flex lg:w-1/2 bg-nuit-dakar relative overflow-hidden flex-col justify-between p-12">
            {{-- Bande signature en fond, discrete --}}
            <div class="absolute top-0 left-0 right-0 h-2 flex">
                <div class="flex-1 bg-vert-teranga"></div>
                <div class="flex-1 bg-blanc-sable"></div>
            </div>

            <div class="flex items-center gap-3">
                <img src="{{ asset('logo_ASC.jpg') }}" alt="Sama ASC" class="w-12 h-12 object-contain">
                <span class="font-display font-bold text-2xl text-blanc-sable tracking-tight">
                    Sama <span class="text-or-sable">ASC</span>
                </span>
            </div>

            <div>
                <h1 class="font-display font-bold text-4xl text-blanc-sable leading-tight mb-4">
                    La gestion de votre ASC,<br>simplifiee.
                </h1>
                <p class="text-blanc-sable/70 text-lg max-w-md">
                    Joueurs, matchs, finances et communication reunis dans une seule plateforme, pensee pour les associations sportives et culturelles senegalaises.
                </p>
            </div>

            <p class="text-blanc-sable/40 text-sm font-mono">
                &copy; {{ date('Y') }} Sama ASC
            </p>
        </div>

        {{-- Panneau formulaire --}}
        <div class="w-full lg:w-1/2 flex flex-col justify-center items-center px-6 py-12 bg-blanc-sable">

            {{-- Logo visible uniquement sur mobile --}}
            <div class="lg:hidden flex items-center gap-2 mb-8">
                <img src="{{ asset('logo_ASC.jpg') }}" alt="Sama ASC" class="w-10 h-10 object-contain">
                <span class="font-display font-bold text-xl text-nuit-dakar tracking-tight">
                    Sama <span class="text-vert-teranga">ASC</span>
                </span>
            </div>

            <div class="w-full max-w-sm">
                <div class="bg-white shadow-sm rounded-xl p-8">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</body>
</html>