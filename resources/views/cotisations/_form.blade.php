@php $c = $cotisation ?? null; @endphp

<div x-data="{ nouveauContributeur: false }">
    <div class="flex justify-between items-center">
        <label class="block text-sm font-medium text-gray-700">Contributeur</label>
        <button type="button" @click="nouveauContributeur = !nouveauContributeur"
                class="text-xs text-vert-teranga hover:underline">
            <span x-show="!nouveauContributeur">+ Nouveau contributeur</span>
            <span x-show="nouveauContributeur">&larr; Choisir dans la liste</span>
        </button>
    </div>

    <div x-show="!nouveauContributeur">
        <select name="statut" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm">
    @foreach (['paye' => 'Payé', 'en_attente' => 'En attente', 'en_retard' => 'En retard'] as $value => $label)
        <option value="{{ $value }}" @selected(old('statut', $c->statut ?? 'en_attente') === $value)>
            {{ $label }}
        </option>
    @endforeach
</select>
        @error('contributeur_id') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div x-show="nouveauContributeur" class="mt-1 space-y-2 p-3 bg-gray-50 rounded-lg">
        <div class="grid grid-cols-2 gap-2">
            <input type="text" name="nouveau_prenom" placeholder="Prenom"
                   value="{{ old('nouveau_prenom') }}"
                   class="rounded-lg border-gray-300 shadow-sm text-sm">
            <input type="text" name="nouveau_nom" placeholder="Nom"
                   value="{{ old('nouveau_nom') }}"
                   class="rounded-lg border-gray-300 shadow-sm text-sm">
        </div>
        <input type="text" name="nouveau_quartier" placeholder="Quartier"
               value="{{ old('nouveau_quartier') }}"
               class="w-full rounded-lg border-gray-300 shadow-sm text-sm">
        @error('nouveau_prenom') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        @error('nouveau_nom') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        @error('nouveau_quartier') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>
</div>

<div class="grid grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium text-gray-700">Montant (FCFA)</label>
        <input type="number" name="montant" value="{{ old('montant', $c->montant ?? '') }}"
               class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm">
        @error('montant') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Periode (ex: 2026-07)</label>
        <input type="text" name="periode" value="{{ old('periode', $c->periode ?? '') }}"
               class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm">
        @error('periode') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>
</div>

<div>
    <label class="block text-sm font-medium text-gray-700">Date de paiement</label>
    <input type="date" name="date_paiement" value="{{ old('date_paiement', $c?->date_paiement?->format('Y-m-d')) }}"
           class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm">
    @error('date_paiement') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
</div>

<div>
    <label class="block text-sm font-medium text-gray-700">Statut</label>
    <select name="statut" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm">
        @foreach (['paye' => 'Paye', 'en_attente' => 'En attente', 'en_retard' => 'En retard'] as $value => $label)
            <option value="{{ $value }}" @selected(old('statut', $c->statut ?? 'en_attente') === $value)>
                {{ $label }}
            </option>
        @endforeach
    </select>
    @error('statut') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
</div>