<x-app-layout>
    <x-slot name="header">
        <h2 class="font-display font-semibold text-xl text-nuit-dakar leading-tight">Ajouter un joueur</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-xl p-6">
                <form action="{{ route('joueurs.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @include('joueurs._form')

                    <div class="flex justify-end gap-3 pt-4">
                        <a href="{{ route('joueurs.index') }}" class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700">Annuler</a>
                        <button type="submit" class="bg-vert-teranga hover:opacity-90 text-white px-4 py-2 rounded-lg">
                            Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>