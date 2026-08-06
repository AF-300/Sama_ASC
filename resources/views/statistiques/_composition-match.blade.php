@if (! $match)
    <div class="bg-white shadow-sm rounded-xl p-6 text-center text-gray-500">
        Aucun match a venir pour le moment.
    </div>
@else
    <div class="bg-white shadow-sm rounded-xl overflow-hidden mb-6">
        <div class="bg-nuit-dakar px-6 py-5 text-center">
            <p class="text-blanc-sable/60 text-xs uppercase tracking-wide mb-1">Prochain match</p>
            <h3 class="font-display font-bold text-xl text-blanc-sable">vs {{ $match->adversaire }}</h3>
            <p class="text-blanc-sable/70 text-sm font-mono tabular-nums mt-1">
                {{ $match->date_match->format('d/m/Y') }}
                @if($match->heure) a {{ $match->heure }} @endif
                @if($match->lieu) — {{ $match->lieu }} @endif
            </p>
        </div>
    </div>

    @if ($match->compositions->isEmpty())
        <div class="bg-white shadow-sm rounded-xl p-6 text-center text-gray-500">
            La composition n'a pas encore ete definie pour ce match.
        </div>
    @else
        <div class="bg-white shadow-sm rounded-xl p-6">
            <h4 class="font-display font-semibold text-nuit-dakar mb-4">Titulaires</h4>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-6">
                @foreach ($match->compositions->where('titulaire', true) as $comp)
                    <div class="flex items-center gap-3 p-3 bg-vert-teranga/5 rounded-lg">
                        @if ($comp->joueur->photo)
                            <img src="{{ $comp->joueur->photo }}" class="w-10 h-10 rounded-full object-cover">
                        @else
                            <div class="w-10 h-10 rounded-full bg-or-sable flex items-center justify-center text-white font-display font-bold text-sm">
                                {{ strtoupper(substr($comp->joueur->prenom, 0, 1)) }}
                            </div>
                        @endif
                        <div>
                            <p class="font-medium text-gray-900 text-sm">{{ $comp->joueur->prenom }} {{ $comp->joueur->nom }}</p>
                            <p class="text-xs text-gray-500">
                                @if($comp->joueur->numero_maillot) #{{ $comp->joueur->numero_maillot }} @endif
                                {{ ucfirst($comp->joueur->poste ?? '') }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>

            @if ($match->compositions->where('titulaire', false)->isNotEmpty())
                <h4 class="font-display font-semibold text-nuit-dakar mb-4">Remplacants</h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    @foreach ($match->compositions->where('titulaire', false) as $comp)
                        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                            @if ($comp->joueur->photo)
                                <img src="{{ $comp->joueur->photo }}" class="w-10 h-10 rounded-full object-cover">
                            @else
                                <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center text-white font-display font-bold text-sm">
                                    {{ strtoupper(substr($comp->joueur->prenom, 0, 1)) }}
                                </div>
                            @endif
                            <div>
                                <p class="font-medium text-gray-900 text-sm">{{ $comp->joueur->prenom }} {{ $comp->joueur->nom }}</p>
                                <p class="text-xs text-gray-500">{{ ucfirst($comp->joueur->poste ?? '') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    @endif
@endif