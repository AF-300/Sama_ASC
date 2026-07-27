<x-app-layout>
    <x-slot name="header">
        <h2 class="font-display font-semibold text-xl text-nuit-dakar leading-tight">Classement des buteurs</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-xl overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Joueur</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Matchs</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Buts</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Passes D.</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($buteurs as $index => $joueur)
                            <tr>
                                <td class="px-6 py-3 font-mono tabular-nums font-medium text-gray-500">{{ $index + 1 }}</td>
                                <td class="px-6 py-3 font-medium text-gray-900">
                                    <a href="{{ route('joueurs.show', $joueur) }}" class="hover:underline">
                                        {{ $joueur->prenom }} {{ $joueur->nom }}
                                    </a>
                                </td>
                                <td class="px-6 py-3 text-center font-mono tabular-nums">{{ $joueur->matchs_joues_count }}</td>
                                <td class="px-6 py-3 text-center font-mono tabular-nums font-bold text-vert-teranga">{{ $joueur->total_buts }}</td>
                                <td class="px-6 py-3 text-center font-mono tabular-nums">{{ $joueur->total_passes }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-6 text-center text-gray-500">Aucun but marque pour le moment.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>