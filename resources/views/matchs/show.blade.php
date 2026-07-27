<x-app-layout>
    <x-slot name="header">
        <h2 class="font-display font-semibold text-xl text-nuit-dakar leading-tight">Match vs {{ $match->adversaire }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="p-4 bg-green-100 border-l-4 border-green-600 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

           <div class="bg-white shadow-sm rounded-xl overflow-hidden">
    {{-- Scoreboard --}}
    <div class="bg-nuit-dakar px-6 py-8">
        <div class="flex items-center justify-center gap-6 sm:gap-10">
            <div class="text-center flex-1">
                <div class="w-14 h-14 mx-auto rounded-full bg-vert-teranga flex items-center justify-center font-display font-bold text-blanc-sable text-lg">
                    ASC
                </div>
                <p class="mt-2 text-blanc-sable font-medium text-sm sm:text-base">Sama ASC</p>
            </div>

            <div class="text-center">
                @if (!is_null($match->score_asc))
                    <div class="font-mono text-4xl sm:text-5xl font-bold text-blanc-sable tabular-nums tracking-wider">
                        {{ $match->score_asc }} <span class="text-or-sable">-</span> {{ $match->score_adversaire }}
                    </div>
                @else
                    <div class="font-display text-lg sm:text-xl font-semibold text-or-sable">
                        VS
                    </div>
                @endif
                @php
                    $labels = ['a_venir' => 'À venir', 'joue' => 'Terminé', 'annule' => 'Annulé'];
                @endphp
                <p class="mt-2 text-xs text-blanc-sable/60 uppercase tracking-wide">{{ $labels[$match->statut] }}</p>
            </div>

            <div class="text-center flex-1">
                <div class="w-14 h-14 mx-auto rounded-full bg-rouge-laterite flex items-center justify-center font-display font-bold text-blanc-sable text-lg">
                    {{ strtoupper(substr($match->adversaire, 0, 3)) }}
                </div>
                <p class="mt-2 text-blanc-sable font-medium text-sm sm:text-base">{{ $match->adversaire }}</p>
            </div>
        </div>
    </div>

    {{-- Infos pratiques --}}
    <div class="p-6 space-y-2">
        <p><span class="font-medium">Date :</span> <span class="font-mono tabular-nums">{{ $match->date_match->format('d/m/Y') }} @if($match->heure) à {{ $match->heure }} @endif</span></p>
        <p><span class="font-medium">Lieu :</span> {{ $match->lieu ?? '-' }}</p>
        <a href="{{ route('matchs.index') }}" class="inline-block pt-4 text-vert-teranga hover:underline">&larr; Retour à la liste</a>
    </div>
</div>

            <div class="bg-white shadow-sm rounded-xl p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-display font-semibold text-lg text-nuit-dakar">Composition d'equipe</h3>
                    <div class="space-x-3">
                        <a href="{{ route('matchs.composition', $match) }}" class="text-sm text-vert-teranga hover:underline">
                            Modifier la composition
                        </a>
                        <a href="{{ route('statistiques.edit', $match) }}" class="text-sm text-vert-teranga hover:underline">
                            Saisir les statistiques
                        </a>
                    </div>
                </div>

                @if ($match->compositions->isEmpty())
                    <p class="text-gray-500 text-sm">Aucune composition definie pour ce match.</p>
                @else
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <h4 class="font-medium text-gray-700 mb-2">Titulaires</h4>
                            <ul class="space-y-1 text-sm">
                                @foreach ($match->compositions->where('titulaire', true) as $comp)
                                    <li>{{ $comp->joueur->prenom }} {{ $comp->joueur->nom }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-700 mb-2">Remplacants</h4>
                            <ul class="space-y-1 text-sm">
                                @foreach ($match->compositions->where('titulaire', false) as $comp)
                                    <li>{{ $comp->joueur->prenom }} {{ $comp->joueur->nom }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>