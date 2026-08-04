<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-display font-semibold text-xl text-nuit-dakar leading-tight">Matchs</h2>
            @role('admin_asc|coach')
                <a href="{{ route('matchs.create') }}"
                   class="bg-vert-teranga hover:opacity-90 text-white px-4 py-2 rounded-lg text-sm font-medium">
                    + Nouveau match
                </a>
            @endrole
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-600 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <form method="GET" class="mb-4">
    <div class="relative max-w-sm">
        <input type="text" name="recherche" value="{{ request('recherche') }}"
               placeholder="Rechercher par adversaire..."
               class="w-full rounded-lg border-gray-300 shadow-sm pl-10 pr-4 py-2 text-sm">
        <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
    </div>
</form>

            <div class="bg-white shadow-sm rounded-xl overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Adversaire</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Lieu</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Score</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($matchs as $match)
                            <tr>
                                <td class="px-6 py-3 font-mono tabular-nums">{{ $match->date_match->format('d/m/Y') }} @if($match->heure) - {{ $match->heure }} @endif</td>
                                <td class="px-6 py-3 font-medium text-gray-900">{{ $match->adversaire }}</td>
                                <td class="px-6 py-3 text-gray-600">{{ $match->lieu ?? '-' }}</td>
                                <td class="px-6 py-3 text-gray-600 font-mono tabular-nums font-semibold">
                                    @if (!is_null($match->score_asc))
                                        {{ $match->score_asc }} - {{ $match->score_adversaire }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-6 py-3">
                                    @php
                                        $badges = [
                                            'a_venir' => 'bg-or-sable/15 text-or-sable',
                                            'joue' => 'bg-vert-teranga/15 text-vert-teranga',
                                            'annule' => 'bg-rouge-laterite/15 text-rouge-laterite',
                                        ];
                                        $labels = [
                                            'a_venir' => 'À venir',
                                            'joue' => 'Joué',
                                            'annule' => 'Annulé',
                                        ];
                                    @endphp
                                    <span class="px-2 py-1 rounded-full text-xs font-medium {{ $badges[$match->statut] }}">
                                        {{ $labels[$match->statut] }}
                                    </span>
                                </td>
                                <td class="px-6 py-3 text-right">
                                    @role('admin_asc|coach')
                                        <div class="flex justify-end flex-wrap gap-2">
                                            <a href="{{ route('matchs.composition', $match) }}"
                                               class="px-3 py-1.5 rounded-lg bg-vert-teranga/10 text-vert-teranga text-sm font-medium hover:bg-vert-teranga/20">
                                                Composition
                                            </a>
                                            <a href="{{ route('matchs.show', $match) }}"
                                               class="px-3 py-1.5 rounded-lg bg-blue-50 text-blue-700 text-sm font-medium hover:bg-blue-100">
                                                Voir
                                            </a>
                                            <a href="{{ route('matchs.edit', $match) }}"
                                               class="px-3 py-1.5 rounded-lg bg-or-sable/10 text-or-sable text-sm font-medium hover:bg-or-sable/20">
                                                Modifier
                                            </a>
                                            <form action="{{ route('matchs.destroy', $match) }}" method="POST"
                                                  onsubmit="return confirm('Supprimer ce match ?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="px-3 py-1.5 rounded-lg bg-red-50 text-red-700 text-sm font-medium hover:bg-red-100">
                                                    Supprimer
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <a href="{{ route('matchs.show', $match) }}"
                                           class="px-3 py-1.5 rounded-lg bg-blue-50 text-blue-700 text-sm font-medium hover:bg-blue-100">
                                            Voir
                                        </a>
                                    @endrole
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-6 text-center text-gray-500">Aucun match pour le moment.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $matchs->links() }}
            </div>
        </div>
    </div>
</x-app-layout>