<x-app-layout>
    <x-slot name="header">
        <h2 class="font-display font-semibold text-xl text-nuit-dakar leading-tight">Tableau de caisse</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div class="bg-white shadow-sm rounded-xl p-6 border-l-4 border-vert-teranga">
        <p class="text-sm text-gray-500">Total cotisations (payees)</p>
        <p class="font-mono text-2xl font-semibold text-vert-teranga mt-1 tabular-nums">{{ number_format($totalCotisations, 0, ',', ' ') }} FCFA</p>
    </div>

    <div class="bg-white shadow-sm rounded-xl p-6 border-l-4 border-rouge-laterite">
        <p class="text-sm text-gray-500">Total depenses</p>
        <p class="font-mono text-2xl font-semibold text-rouge-laterite mt-1 tabular-nums">{{ number_format($totalDepenses, 0, ',', ' ') }} FCFA</p>
    </div>

    <div class="bg-white shadow-sm rounded-xl p-6 border-l-4 {{ $solde >= 0 ? 'border-or-sable' : 'border-rouge-laterite' }}">
        <p class="text-sm text-gray-500">Solde actuel</p>
        <p class="font-mono text-2xl font-semibold {{ $solde >= 0 ? 'text-or-sable' : 'text-rouge-laterite' }} mt-1 tabular-nums">
            {{ number_format($solde, 0, ',', ' ') }} FCFA
        </p>
    </div>
</div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="bg-white shadow-sm rounded-lg p-6">
        <h3 class="font-semibold text-gray-800 mb-4">Cotisations par quartier</h3>
        @forelse ($cotisationsParQuartier as $quartier => $total)
            <div class="flex justify-between py-2 border-b border-gray-100 last:border-0 text-sm">
                <span class="text-gray-600">{{ $quartier }}</span>
                <span class="font-medium">{{ number_format($total, 0, ',', ' ') }} FCFA</span>
            </div>
        @empty
            <p class="text-gray-500 text-sm">Aucune contribution enregistree.</p>
        @endforelse
    </div>

    <div class="bg-white shadow-sm rounded-lg p-6">
        <h3 class="font-semibold text-gray-800 mb-4">Depenses par categorie</h3>
                    @forelse ($depensesParCategorie as $categorie => $total)
                        <div class="flex justify-between py-2 border-b border-gray-100 last:border-0">
                            <span class="capitalize text-gray-600">{{ $categorie }}</span>
                            <span class="font-medium">{{ number_format($total, 0, ',', ' ') }} FCFA</span>
                        </div>
                    @empty
                        <p class="text-gray-500 text-sm">Aucune depense enregistree.</p>
                    @endforelse
                </div>

                <div class="bg-white shadow-sm rounded-lg p-6">
                    <h3 class="font-semibold text-gray-800 mb-4">Dernieres cotisations payees</h3>
                   @forelse ($dernieresCotisations as $cotisation)
    <div class="flex justify-between py-2 border-b border-gray-100 last:border-0 text-sm">
        <span>{{ $cotisation->contributeur->prenom }} {{ $cotisation->contributeur->nom }}</span>
        <span class="font-medium">{{ number_format($cotisation->montant, 0, ',', ' ') }} FCFA</span>
    </div>
@empty
                        <p class="text-gray-500 text-sm">Aucune cotisation payee.</p>
                    @endforelse
                </div>
            </div>

            <div class="bg-white shadow-sm rounded-lg p-6">
                <h3 class="font-semibold text-gray-800 mb-4">Dernieres depenses</h3>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Libelle</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Categorie</th>
                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Montant</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($dernieresDepenses as $depense)
                            <tr>
                                <td class="px-4 py-2 text-sm">{{ $depense->date_depense->format('d/m/Y') }}</td>
                                <td class="px-4 py-2 text-sm">{{ $depense->libelle }}</td>
                                <td class="px-4 py-2 text-sm capitalize">{{ $depense->categorie }}</td>
                                <td class="px-4 py-2 text-sm text-right">{{ number_format($depense->montant, 0, ',', ' ') }} FCFA</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-4 text-center text-gray-500 text-sm">Aucune depense.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

           <div class="flex justify-between items-center flex-wrap gap-3">
    <div class="flex gap-3">
        <a href="{{ route('cotisations.index') }}" class="text-sm text-vert-teranga hover:underline font-medium">Gerer les cotisations &rarr;</a>
        <a href="{{ route('depenses.index') }}" class="text-sm text-vert-teranga hover:underline font-medium">Gerer les depenses &rarr;</a>
        <a href="{{ route('contributeurs.index') }}" class="text-sm text-vert-teranga hover:underline font-medium">Gerer les contributeurs &rarr;</a>
    </div>
    <a href="{{ route('caisse.rapport-pdf') }}"
       class="bg-nuit-dakar hover:opacity-90 text-white px-4 py-2 rounded-lg text-sm font-medium">
        Telecharger le rapport PDF
    </a>
</div>
        </div>
    </div>
</x-app-layout>