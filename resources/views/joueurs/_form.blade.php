@php $j = $joueur ?? null; @endphp

<div>
    <label class="block text-sm font-medium text-gray-700">Compte utilisateur associe (optionnel)</label>
    <select name="user_id" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm">
        <option value="">-- Aucun --</option>
        @foreach ($utilisateursDisponibles as $utilisateur)
            <option value="{{ $utilisateur->id }}" @selected(old('user_id', $j->user_id ?? '') == $utilisateur->id)>
                {{ $utilisateur->name }} ({{ $utilisateur->email }})
            </option>
        @endforeach
    </select>
    <p class="text-xs text-gray-400 mt-1">Permet au joueur de voir ses convocations depuis son compte.</p>
    @error('user_id') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
</div>

<div>
    <label class="block text-sm font-medium text-gray-700">Nom</label>
    <input type="text" name="nom" value="{{ old('nom', $j->nom ?? '') }}"
           class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm">
    @error('nom') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
</div>

<div>
    <label class="block text-sm font-medium text-gray-700">Prenom</label>
    <input type="text" name="prenom" value="{{ old('prenom', $j->prenom ?? '') }}"
           class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm">
    @error('prenom') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
</div>

<div class="grid grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium text-gray-700">Age</label>
        <input type="number" name="age" value="{{ old('age', $j->age ?? '') }}"
               class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm">
        @error('age') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Numéro maillot</label>
        <input type="number" name="numero_maillot" value="{{ old('numero_maillot', $j->numero_maillot ?? '') }}"
               class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm">
        @error('numero_maillot') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>
</div>

<div>
    <label class="block text-sm font-medium text-gray-700">Poste</label>
    <select name="poste" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm">
        <option value="">-- Selectionner --</option>
        @foreach (['gardien', 'defenseur', 'milieu', 'attaquant'] as $poste)
            <option value="{{ $poste }}" @selected(old('poste', $j->poste ?? '') === $poste)>
                {{ ucfirst($poste) }}
            </option>
        @endforeach
    </select>
    @error('poste') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
</div>

<div>
    <label class="block text-sm font-medium text-gray-700">Quartier</label>
    <input type="text" name="quartier" value="{{ old('quartier', $j->quartier ?? '') }}"
           class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm">
    @error('quartier') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
</div>

<div>
    <label class="block text-sm font-medium text-gray-700">Photo</label>
    <input type="file" name="photo" accept="image/*"
           class="mt-1 block w-full text-sm text-gray-700">
    @error('photo') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    @if ($j && $j->photo)
        <img src="{{ $j->photo }}" class="mt-2 w-16 h-16 rounded-full object-cover">
    @endif
</div>