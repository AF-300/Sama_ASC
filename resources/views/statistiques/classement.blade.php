<x-app-layout>
    <x-slot name="header">
        <h2 class="font-display font-semibold text-xl text-nuit-dakar leading-tight">Composition de depart</h2>
    </x-slot>

    <div class="py-8" x-data="{ onglet: '{{ $prochainMatchSenior ? 'senior' : 'cadet' }}' }">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            @if ($prochainMatchSenior && $prochainMatchCadet)
                <div class="flex gap-2 mb-6">
                    <button @click="onglet = 'senior'"
                            :class="onglet === 'senior' ? 'bg-vert-teranga text-white' : 'bg-white text-gray-600'"
                            class="px-4 py-2 rounded-lg text-sm font-medium shadow-sm">
                        Seniors
                    </button>
                    <button @click="onglet = 'cadet'"
                            :class="onglet === 'cadet' ? 'bg-vert-teranga text-white' : 'bg-white text-gray-600'"
                            class="px-4 py-2 rounded-lg text-sm font-medium shadow-sm">
                        Cadets
                    </button>
                </div>
            @endif

            @if ($prochainMatchSenior)
                <div x-show="onglet === 'senior'" @if(!$prochainMatchCadet) x-cloak="false" @endif>
                    @include('statistiques._composition-match', ['match' => $prochainMatchSenior])
                </div>
            @endif

            @if ($prochainMatchCadet)
                <div x-show="onglet === 'cadet'" @if($prochainMatchSenior) x-cloak @endif>
                    @include('statistiques._composition-match', ['match' => $prochainMatchCadet])
                </div>
            @endif

            @if (! $prochainMatchSenior && ! $prochainMatchCadet)
                <div class="bg-white shadow-sm rounded-xl p-6 text-center text-gray-500">
                    Aucun match a venir pour le moment.
                </div>
            @endif
        </div>
    </div>
</x-app-layout>