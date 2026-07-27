<x-app-layout>
    <x-slot name="header">
        <h2 class="font-display font-semibold text-xl text-nuit-dakar leading-tight">Mes convocations</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if (! $aFicheJoueur)
                <div class="bg-white shadow-sm rounded-xl p-6 text-center text-gray-500">
                    Aucune fiche joueur associee a ton compte. Contacte l'administrateur de l'ASC.
                </div>
            @elseif ($convocations->isEmpty())
                <div class="bg-white shadow-sm rounded-xl p-6 text-center text-gray-500">
                    Aucun match a venir pour le moment.
                </div>
            @else
                @foreach ($convocations as $match)
                    @php
                        $badges = [
                            'titulaire' => ['bg-vert-teranga/15 text-vert-teranga', 'Titulaire'],
                            'remplacant' => ['bg-or-sable/15 text-or-sable', 'Remplaçant'],
                            'non_convoque' => ['bg-gray-100 text-gray-500', 'Non convoqué'],
                        ];
                        [$classe, $label] = $badges[$match->statutConvocation];
                    @endphp
                    <div class="bg-white shadow-sm rounded-xl p-6 flex items-center justify-between">
                        <div>
                            <p class="font-medium text-gray-900">vs {{ $match->adversaire }}</p>
                            <p class="text-sm text-gray-500 font-mono tabular-nums">
                                {{ $match->date_match->format('d/m/Y') }} @if($match->heure) à {{ $match->heure }} @endif
                                @if($match->lieu) — {{ $match->lieu }} @endif
                            </p>
                        </div>
                        <span class="px-3 py-1.5 rounded-full text-sm font-medium {{ $classe }}">
                            {{ $label }}
                        </span>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</x-app-layout>