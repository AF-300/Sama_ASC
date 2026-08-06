@php $m = $match ?? null; @endphp

<div>
    <label class="block text-sm font-medium text-gray-700">Adversaire</label>
    <input type="text" name="adversaire" value="{{ old('adversaire', $m->adversaire ?? '') }}"
           class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm">
    @error('adversaire') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
</div>

<div class="grid grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium text-gray-700">Date du match</label>
        <input type="date" name="date_match" value="{{ old('date_match', $m?->date_match?->format('Y-m-d')) }}"
               class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm">
        @error('date_match') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Heure</label>
        <input type="time" name="heure" value="{{ old('heure', $m->heure ?? '') }}"
               class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm">
        @error('heure') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>
</div>

<div>
    <label class="block text-sm font-medium text-gray-700">Lieu</label>
    <input type="text" name="lieu" value="{{ old('lieu', $m->lieu ?? '') }}"
           class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm">
    @error('lieu') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
</div>

@if ($m)
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Score ASC</label>
            <input type="number" name="score_asc" value="{{ old('score_asc', $m->score_asc) }}"
                   class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Score adversaire</label>
            <input type="number" name="score_adversaire" value="{{ old('score_adversaire', $m->score_adversaire) }}"
                   class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm">
        </div>
    </div>
@endif

<div>
    <label class="block text-sm font-medium text-gray-700">Statut</label>
    <select name="statut" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm">
        @foreach (['a_venir' => 'À venir', 'joue' => 'Joué', 'annule' => 'Annulé'] as $value => $label)
            <option value="{{ $value }}" @selected(old('statut', $m->statut ?? 'a_venir') === $value)>
                {{ $label }}
            </option>
        @endforeach
    </select>
    @error('statut') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
</div>