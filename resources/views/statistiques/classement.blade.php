<x-app-layout>
    <x-slot name="header">
        <h2 class="font-display font-semibold text-xl text-nuit-dakar leading-tight">Composition de depart</h2>
    </x-slot>

    <div class="py-8" x-data="{ onglet: 'senior' }">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

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

            <div x-show="onglet === 'senior'">
                @include('statistiques._composition-match', ['match' => $prochainMatchSenior])
            </div>

            <div x-show="onglet === 'cadet'" x-cloak>
                @include('statistiques._composition-match', ['match' => $prochainMatchCadet])
            </div>
        </div>
    </div>
</x-app-layout>