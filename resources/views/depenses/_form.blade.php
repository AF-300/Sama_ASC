@php $d = $depense ?? null; @endphp

<div>
    <label class="block text-sm font-medium text-gray-700">Libelle</label>
    <input type="text" name="libelle" value="{{ old('libelle', $d->libelle ?? '') }}"
           class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm">
    @error('libelle') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
</div>

<div class="grid grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium text-gray-700">Montant (FCFA)</label>
        <input type="number" name="montant" value="{{ old('montant', $d->montant ?? '') }}"
               class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm">
        @error('montant') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Date</label>
       <input type="date" name="date_depense" value="{{ old('date_depense', $d?->date_depense?->format('Y-m-d')) }}"
               class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm">
        @error('date_depense') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>
</div>

<div>
    <label class="block text-sm font-medium text-gray-700">Categorie</label>
    <select name="categorie" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm">
        @foreach (['materiel' => 'Materiel', 'coach' => 'Coach', 'transport' => 'Transport', 'autre' => 'Autre'] as $value => $label)
            <option value="{{ $value }}" @selected(old('categorie', $d->categorie ?? 'autre') === $value)>
                {{ $label }}
            </option>
        @endforeach
    </select>
    @error('categorie') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
</div>