<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-display font-semibold text-xl text-nuit-dakar leading-tight">Depenses</h2>
            <a href="{{ route('depenses.create') }}"
               class="bg-vert-teranga hover:opacity-90 text-white px-4 py-2 rounded-lg text-sm font-medium">
                + Nouvelle depense
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
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Libelle</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Categorie</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Montant</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($depenses as $depense)
                            <tr>
                                <td class="px-6 py-3 font-mono tabular-nums">{{ $depense->date_depense->format('d/m/Y') }}</td>
                                <td class="px-6 py-3">{{ $depense->libelle }}</td>
                                <td class="px-6 py-3 capitalize">{{ $depense->categorie }}</td>
                                <td class="px-6 py-3 font-mono tabular-nums">{{ number_format($depense->montant, 0, ',', ' ') }} FCFA</td>
                                <td class="px-6 py-3 text-right">
    <div class="flex justify-end gap-2">
        <a href="{{ route('depenses.edit', $depense) }}"
           class="px-3 py-1.5 rounded-lg bg-or-sable/10 text-or-sable text-sm font-medium hover:bg-or-sable/20">
            Modifier
        </a>
        <form action="{{ route('depenses.destroy', $depense) }}" method="POST"
              onsubmit="return confirm('Supprimer cette depense ?');">
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
                                <td colspan="5" class="px-6 py-6 text-center text-gray-500">Aucune depense enregistree.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">{{ $depenses->links() }}</div>
        </div>
    </div>
</x-app-layout>