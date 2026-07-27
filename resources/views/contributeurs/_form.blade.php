@php $c = $contributeur ?? null; @endphp

<div>
    <label class="block text-sm font-medium text-gray-700">Nom</label>
    <input type="text" name="nom" value="{{ old('nom', $c->nom ?? '') }}"
           class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm">
    @error('nom') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
</div>

<div>
    <label class="block text-sm font-medium text-gray-700">Prenom</label>
    <input type="text" name="prenom" value="{{ old('prenom', $c->prenom ?? '') }}"
           class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm">
    @error('prenom') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
</div>

<div>
    <label class="block text-sm font-medium text-gray-700">Quartier</label>
    <input type="text" name="quartier" value="{{ old('quartier', $c->quartier ?? '') }}"
           class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm">
    @error('quartier') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
</div>