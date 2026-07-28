<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-display font-semibold text-xl text-nuit-dakar leading-tight">Contributeurs</h2>
            <a href="{{ route('contributeurs.create') }}"
               class="bg-vert-teranga hover:opacity-90 text-white px-4 py-2 rounded-lg text-sm font-medium">
                + Ajouter un contributeur
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-600 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

           <div class="bg-white shadow-sm rounded-xl overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nom</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Quartier</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($contributeurs as $contributeur)
                            <tr>
                                <td class="px-6 py-3 font-medium text-gray-900">
                                    {{ $contributeur->prenom }} {{ $contributeur->nom }}
                                </td>
                                <td class="px-6 py-3 text-gray-600">{{ $contributeur->quartier }}</td>
                                <td class="px-6 py-3 text-right">
    <div class="flex justify-end gap-2">
        <a href="{{ route('contributeurs.edit', $contributeur) }}"
           class="px-3 py-1.5 rounded-lg bg-or-sable/10 text-or-sable text-sm font-medium hover:bg-or-sable/20">
            Modifier
        </a>
        <form action="{{ route('contributeurs.destroy', $contributeur) }}" method="POST"
              onsubmit="return confirm('Supprimer ce contributeur ?');">
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
                                <td colspan="3" class="px-6 py-6 text-center text-gray-500">Aucun contributeur enregistre.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">{{ $contributeurs->links() }}</div>
        </div>
    </div>
</x-app-layout>