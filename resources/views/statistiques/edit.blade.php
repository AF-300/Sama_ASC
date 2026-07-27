<x-app-layout>
    <x-slot name="header">
        <h2 class="font-display font-semibold text-xl text-nuit-dakar leading-tight">Statistiques - vs {{ $match->adversaire }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
           <div class="bg-white shadow-sm rounded-xl p-6">
                @if ($match->compositions->isEmpty())
                    <p class="text-gray-500 text-sm">
                        Aucun joueur convoque pour ce match. <a href="{{ route('matchs.composition', $match) }}" class="text-green-700 hover:underline">Definis d'abord la composition</a>.
                    </p>
                @else
                    <form action="{{ route('statistiques.update', $match) }}" method="POST">
                        @csrf

                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Joueur</th>
                                    <th class="px-3 py-2 text-center text-xs font-medium text-gray-500 uppercase">Buts</th>
                                    <th class="px-3 py-2 text-center text-xs font-medium text-gray-500 uppercase">Passes D.</th>
                                    <th class="px-3 py-2 text-center text-xs font-medium text-gray-500 uppercase">CJ</th>
                                    <th class="px-3 py-2 text-center text-xs font-medium text-gray-500 uppercase">CR</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach ($match->compositions as $comp)
                                    @php $stat = $statsExistantes->get($comp->joueur_id); @endphp
                                    <tr>
                                        <td class="px-3 py-2 text-sm">{{ $comp->joueur->prenom }} {{ $comp->joueur->nom }}</td>
                                        <td class="px-3 py-2 text-center">
                                            <input type="number" min="0" name="stats[{{ $comp->joueur_id }}][buts]"
                                                   value="{{ $stat->buts ?? 0 }}"
                                                   class="w-16 text-center rounded-lg border-gray-300 shadow-sm">
                                        </td>
                                        <td class="px-3 py-2 text-center">
                                            <input type="number" min="0" name="stats[{{ $comp->joueur_id }}][passes_decisives]"
                                                   value="{{ $stat->passes_decisives ?? 0 }}"
                                                   class="w-16 text-center rounded-lg border-gray-300 shadow-sm">
                                        </td>
                                        <td class="px-3 py-2 text-center">
                                            <input type="number" min="0" name="stats[{{ $comp->joueur_id }}][cartons_jaunes]"
                                                   value="{{ $stat->cartons_jaunes ?? 0 }}"
                                                   class="w-14 text-center rounded-lg border-gray-300 shadow-sm">
                                        </td>
                                        <td class="px-3 py-2 text-center">
                                            <input type="number" min="0" name="stats[{{ $comp->joueur_id }}][cartons_rouges]"
                                                   value="{{ $stat->cartons_rouges ?? 0 }}"
                                                   class="w-14 text-center rounded-lg border-gray-300 shadow-sm">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="flex justify-end gap-3 pt-6">
                            <a href="{{ route('matchs.show', $match) }}" class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700">Annuler</a>
                            <button type="submit" class="bg-vert-teranga hover:opacity-90">
                                Enregistrer les statistiques
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>