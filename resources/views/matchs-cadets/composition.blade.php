<x-app-layout>
    <x-slot name="header">
        <h2 class="font-display font-semibold text-xl text-nuit-dakar leading-tight">Composition Cadets - vs {{ $match->adversaire }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-xl p-6">
                <form action="{{ route('matchs-cadets.composition.store', $match) }}" method="POST">
                    @csrf

                    <p class="text-sm text-gray-500 mb-4">
                        Coche les joueurs convoques, puis indique lesquels sont titulaires.
                    </p>

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Convoque</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Joueur</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Titulaire</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($joueurs as $joueur)
                                <tr>
                                    <td class="px-4 py-2">
                                        <input type="checkbox" name="joueurs[]" value="{{ $joueur->id }}"
                                               @checked($selectionnes->has($joueur->id))>
                                    </td>
                                    <td class="px-4 py-2">{{ $joueur->prenom }} {{ $joueur->nom }}</td>
                                    <td class="px-4 py-2">
                                        <input type="checkbox" name="titulaires[]" value="{{ $joueur->id }}"
                                               @checked($selectionnes->get($joueur->id))>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="flex justify-end gap-3 pt-6">
                        <a href="{{ route('matchs-cadets.show', $match) }}" class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700">Annuler</a>
                        <button type="submit" class="bg-vert-teranga hover:opacity-90 text-white px-4 py-2 rounded-lg">
                            Enregistrer la composition
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>