<x-app-layout>
    <x-slot name="header">
        <h2 class="font-display font-semibold text-xl text-nuit-dakar leading-tight">Tableau de bord</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Cartes stats principales --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white shadow-sm rounded-xl p-6 border-l-4 border-vert-teranga">
                    <p class="text-sm text-gray-500">Joueurs</p>
                    <p class="font-mono text-3xl font-semibold text-vert-teranga mt-1 tabular-nums">{{ $nombreJoueurs }}</p>
                </div>

                @if (isset($nombreMatchsJoues))
                    <div class="bg-white shadow-sm rounded-xl p-6 border-l-4 border-or-sable">
                        <p class="text-sm text-gray-500">Matchs joues</p>
                        <p class="font-mono text-3xl font-semibold text-or-sable mt-1 tabular-nums">{{ $nombreMatchsJoues }}</p>
                    </div>

                    <div class="bg-white shadow-sm rounded-xl p-6 border-l-4 border-rouge-laterite">
                        <p class="text-sm text-gray-500">Victoires</p>
                        <p class="font-mono text-3xl font-semibold text-rouge-laterite mt-1 tabular-nums">{{ $victoires }}</p>
                    </div>
                @endif
            </div>

            {{-- Bloc financier (admin uniquement) --}}
            @if (isset($solde))
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-white shadow-sm rounded-xl p-6 border-l-4 border-vert-teranga">
                        <p class="text-sm text-gray-500">Total cotisations</p>
                        <p class="font-mono text-xl font-semibold text-vert-teranga mt-1 tabular-nums">{{ number_format($totalCotisations, 0, ',', ' ') }} FCFA</p>
                    </div>
                    <div class="bg-white shadow-sm rounded-xl p-6 border-l-4 border-rouge-laterite">
                        <p class="text-sm text-gray-500">Total depenses</p>
                        <p class="font-mono text-xl font-semibold text-rouge-laterite mt-1 tabular-nums">{{ number_format($totalDepenses, 0, ',', ' ') }} FCFA</p>
                    </div>
                    <div class="bg-white shadow-sm rounded-xl p-6 border-l-4 {{ $solde >= 0 ? 'border-or-sable' : 'border-rouge-laterite' }}">
                        <p class="text-sm text-gray-500">Solde</p>
                        <p class="font-mono text-xl font-semibold {{ $solde >= 0 ? 'text-or-sable' : 'text-rouge-laterite' }} mt-1 tabular-nums">
                            {{ number_format($solde, 0, ',', ' ') }} FCFA
                        </p>
                    </div>
                </div>

                @if ($cotisationsEnRetard > 0)
                    <div class="p-4 bg-rouge-laterite/10 border-l-4 border-rouge-laterite text-rouge-laterite rounded-lg text-sm">
                        {{ $cotisationsEnRetard }} cotisation(s) en retard. <a href="{{ route('cotisations.index') }}" class="underline font-medium">Voir</a>
                    </div>
                @endif
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            @if (isset($cotisationsParMois))
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white shadow-sm rounded-xl p-6">
            <h3 class="font-display font-semibold text-nuit-dakar mb-4">Cotisations (6 derniers mois)</h3>
            <canvas id="graphiqueCotisations" height="200"></canvas>
        </div>

        <div class="bg-white shadow-sm rounded-xl p-6">
            <h3 class="font-display font-semibold text-nuit-dakar mb-4">Depenses par categorie</h3>
            <canvas id="graphiqueDepenses" height="200"></canvas>
        </div>
    </div>
@endif

                {{-- Prochains matchs --}}
                <div class="bg-white shadow-sm rounded-xl p-6">
                    <h3 class="font-display font-semibold text-nuit-dakar mb-4">Prochains matchs</h3>
                    @forelse ($prochainsMatchs as $match)
                        <div class="flex justify-between py-2 border-b border-gray-100 last:border-0 text-sm">
                            <span>vs {{ $match->adversaire }}</span>
                            <span class="text-gray-500 font-mono tabular-nums">{{ $match->date_match->format('d/m/Y') }}</span>
                        </div>
                    @empty
                        <p class="text-gray-500 text-sm">Aucun match a venir.</p>
                    @endforelse
                    <a href="{{ route('matchs.index') }}" class="inline-block mt-4 text-sm text-vert-teranga hover:underline font-medium">Voir tous les matchs &rarr;</a>
                </div>

                {{-- Dernieres annonces --}}
                <div class="bg-white shadow-sm rounded-xl p-6">
                    <h3 class="font-display font-semibold text-nuit-dakar mb-4">Dernieres annonces</h3>
                    @forelse ($dernieresAnnonces as $annonce)
                        <div class="py-2 border-b border-gray-100 last:border-0 text-sm">
                            <a href="{{ route('annonces.show', $annonce) }}" class="font-medium hover:underline">{{ $annonce->titre }}</a>
                            <p class="text-gray-500 text-xs font-mono">{{ $annonce->date_publication->format('d/m/Y') }}</p>
                        </div>
                    @empty
                        <p class="text-gray-500 text-sm">Aucune annonce.</p>
                    @endforelse
                    <a href="{{ route('annonces.index') }}" class="inline-block mt-4 text-sm text-vert-teranga hover:underline font-medium">Voir toutes les annonces &rarr;</a>
                </div>
            </div>
        </div>
    </div>
    @if (isset($cotisationsParMois))
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
    <script>
        const ctxCotisations = document.getElementById('graphiqueCotisations');
        new Chart(ctxCotisations, {
            type: 'bar',
            data: {
                labels: {!! json_encode($cotisationsParMois->keys()) !!},
                datasets: [{
                    label: 'Cotisations (FCFA)',
                    data: {!! json_encode($cotisationsParMois->values()) !!},
                    backgroundColor: '#1B5E3C',
                    borderRadius: 6,
                }]
            },
            options: {
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true } }
            }
        });

        const ctxDepenses = document.getElementById('graphiqueDepenses');
        new Chart(ctxDepenses, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($depensesParCategorie->keys()) !!},
                datasets: [{
                    data: {!! json_encode($depensesParCategorie->values()) !!},
                    backgroundColor: ['#1B5E3C', '#E3A83B', '#C1432B', '#6B7280'],
                }]
            },
            options: {
                plugins: { legend: { position: 'bottom' } }
            }
        });
    </script>
@endif
</x-app-layout>