<x-app-layout>
    <x-slot name="header">
        <h2 class="font-display font-semibold text-xl text-nuit-dakar leading-tight">{{ $annonce->titre }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-xl p-6">
                <p class="text-xs text-gray-400 mb-4 font-mono">
                    Publie par {{ $annonce->auteur->name }} le {{ $annonce->date_publication->format('d/m/Y a H:i') }}
                </p>
                <div class="text-gray-700 whitespace-pre-line">{{ $annonce->contenu }}</div>

                <div class="flex justify-between items-center mt-6 pt-4 border-t border-gray-100">
                    <a href="{{ route('annonces.index') }}" class="text-vert-teranga hover:underline text-sm">&larr; Retour aux annonces</a>
@role('admin_asc|coach')
    <div class="flex gap-2">
        <a href="{{ route('annonces.edit', $annonce) }}"
           class="px-3 py-1.5 rounded-lg bg-or-sable/10 text-or-sable text-sm font-medium hover:bg-or-sable/20">
            Modifier
        </a>
        <form action="{{ route('annonces.destroy', $annonce) }}" method="POST"
              onsubmit="return confirm('Supprimer cette annonce ?');">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="px-3 py-1.5 rounded-lg bg-red-50 text-red-700 text-sm font-medium hover:bg-red-100">
                Supprimer
            </button>
        </form>
    </div>
@endrole
                </div>
            </div>
        </div>
    </div>
</x-app-layout>