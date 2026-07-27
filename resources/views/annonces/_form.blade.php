@php $a = $annonce ?? null; @endphp

<div>
    <label class="block text-sm font-medium text-gray-700">Titre</label>
    <input type="text" name="titre" value="{{ old('titre', $a->titre ?? '') }}"
           class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm">
    @error('titre') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
</div>

<div>
    <label class="block text-sm font-medium text-gray-700">Contenu</label>
    <textarea name="contenu" rows="6"
              class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm">{{ old('contenu', $a->contenu ?? '') }}</textarea>
    @error('contenu') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
</div>