<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-display font-semibold text-xl text-nuit-dakar leading-tight">Cotisations</h2>
            <a href="{{ route('cotisations.create') }}"
               class="bg-vert-teranga hover:opacity-90 text-white px-4 py-2 rounded-lg text-sm font-medium">
                + Enregistrer une cotisation
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
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Contributeur</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Periode</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Montant</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($cotisations as $cotisation)
                            <tr>
                                <td class="px-6 py-3">
                                    {{ $cotisation->contributeur->prenom }} {{ $cotisation->contributeur->nom }}
                                    <span class="text-gray-400 text-xs">({{ $cotisation->contributeur->quartier }})</span>
                                </td>
                                <td class="px-6 py-3 font-mono tabular-nums">{{ $cotisation->periode }}</td>
                                <td class="px-6 py-3 font-mono tabular-nums">{{ number_format($cotisation->montant, 0, ',', ' ') }} FCFA</td>
                                <td class="px-6 py-3">
                                    @php
    $badges = [
        'paye' => 'bg-vert-teranga/15 text-vert-teranga',
        'en_attente' => 'bg-or-sable/15 text-or-sable',
        'en_retard' => 'bg-rouge-laterite/15 text-rouge-laterite',
    ];
    $labels = [
        'paye' => 'Payé',
        'en_attente' => 'En attente',
        'en_retard' => 'En retard',
    ];
@endphp
<span class="px-2 py-1 rounded-full text-xs font-medium {{ $badges[$cotisation->statut] }}">
    {{ $labels[$cotisation->statut] }}
</span>
                               <td class="px-6 py-3 text-right">
    <div class="flex justify-end gap-2">
        <a href="{{ route('cotisations.edit', $cotisation) }}"
           class="px-3 py-1.5 rounded-lg bg-or-sable/10 text-or-sable text-sm font-medium hover:bg-or-sable/20">
            Modifier
        </a>
        <form action="{{ route('cotisations.destroy', $cotisation) }}" method="POST"
              onsubmit="return confirm('Supprimer cette cotisation ?');">
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
                                <td colspan="5" class="px-6 py-6 text-center text-gray-500">Aucune cotisation enregistree.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">{{ $cotisations->links() }}</div>
        </div>
    </div>
</x-app-layout>