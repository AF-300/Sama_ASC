<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-display font-semibold text-xl text-nuit-dakar leading-tight">
    Gestion des joueurs
</h2>
<a href="{{ route('joueurs.create') }}"
   class="bg-vert-teranga hover:opacity-90 text-white px-4 py-2 rounded-lg text-sm font-medium">
    + Ajouter un joueur
</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
<form method="GET" class="mb-4">
    <div class="relative max-w-sm">
        <input type="text" name="recherche" value="{{ request('recherche') }}"
               placeholder="Rechercher par nom, prenom, quartier..."
               class="w-full rounded-lg border-gray-300 shadow-sm pl-10 pr-4 py-2 text-sm">
        <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
    </div>
</form>
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-600 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

           <div class="bg-white shadow-sm rounded-xl overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Photo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nom</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Poste</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">N°</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Quartier</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($joueurs as $joueur)
                            <tr>
                                <td class="px-6 py-3">
                                    @if ($joueur->photo)
                                        <img src="{{ $joueur->photo }}" class="w-10 h-10 rounded-full object-cover">
                                    @else
                                        <div class="w-10 h-10 rounded-full bg-or-sable flex items-center justify-center text-white font-display font-bold">
    {{ strtoupper(substr($joueur->prenom, 0, 1)) }}
</div>
                                    @endif
                                </td>
                                <td class="px-6 py-3 font-medium text-gray-900">
                                    {{ $joueur->prenom }} {{ $joueur->nom }}
                                </td>
                                <td class="px-6 py-3 text-gray-600 capitalize">{{ $joueur->poste ?? '-' }}</td>
                               <td class="px-6 py-3 text-gray-600 font-mono tabular-nums">{{ $joueur->numero_maillot ?? '-' }}</td>
                                <td class="px-6 py-3 text-gray-600">{{ $joueur->quartier ?? '-' }}</td>
                                <td class="px-6 py-3 text-right">
    <div class="flex justify-end gap-2">
        <a href="{{ route('joueurs.show', $joueur) }}"
           class="px-3 py-1.5 rounded-lg bg-blue-50 text-blue-700 text-sm font-medium hover:bg-blue-100">
            Voir
        </a>
        <a href="{{ route('joueurs.edit', $joueur) }}"
           class="px-3 py-1.5 rounded-lg bg-or-sable/10 text-or-sable text-sm font-medium hover:bg-or-sable/20">
            Modifier
        </a>
        <form action="{{ route('joueurs.destroy', $joueur) }}" method="POST"
              onsubmit="return confirm('Supprimer ce joueur ?');">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="px-3 py-1.5 rounded-lg bg-red-50 text-red-700 text-sm font-medium hover:bg-red-100">
                Supprimer
            </button>
        </form>
    </div>
</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-6 text-center text-gray-500">Aucun joueur pour le moment.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $joueurs->links() }}
            </div>
        </div>
    </div>
</x-app-layout>