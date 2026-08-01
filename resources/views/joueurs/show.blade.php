<x-app-layout>
    <x-slot name="header">
        <h2 class="font-display font-semibold text-xl text-nuit-dakar leading-tight">{{ $joueur->prenom }} {{ $joueur->nom }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-xl p-6 space-y-3" x-data="{ photoOuverte: false }">
    @if ($joueur->photo)
        <img src="{{ $joueur->photo }}"
             @click="photoOuverte = true"
             class="w-24 h-24 rounded-full object-cover mb-4 cursor-pointer hover:opacity-80 transition">

        <!-- Modal agrandi -->
        <div x-show="photoOuverte" x-cloak
             @click="photoOuverte = false"
             @keydown.escape.window="photoOuverte = false"
             class="fixed inset-0 bg-black/80 flex items-center justify-center z-50 p-4"
             style="display: none;">
            <img src="{{ $joueur->photo }}"
                 @click.stop
                 class="max-w-full max-h-full rounded-lg shadow-2xl">
            <button @click="photoOuverte = false"
                    class="absolute top-4 right-4 text-white text-3xl leading-none hover:text-gray-300">
                &times;
            </button>
        </div>
    @else
                    <div class="w-24 h-24 rounded-full bg-or-sable flex items-center justify-center text-white font-display font-bold text-2xl mb-4">
                        {{ strtoupper(substr($joueur->prenom, 0, 1)) }}
                    </div>
                @endif
                <p><span class="font-medium">Age :</span> <span class="font-mono tabular-nums">{{ $joueur->age ?? '-' }}</span></p>
                <p><span class="font-medium">Poste :</span> {{ ucfirst($joueur->poste ?? '-') }}</p>
                <p><span class="font-medium">Numero maillot :</span> <span class="font-mono tabular-nums">{{ $joueur->numero_maillot ?? '-' }}</span></p>
                <p><span class="font-medium">Quartier :</span> {{ $joueur->quartier ?? '-' }}</p>

                <div class="pt-4">
                    <a href="{{ route('joueurs.index') }}" class="text-vert-teranga hover:underline">&larr; Retour a la liste</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>