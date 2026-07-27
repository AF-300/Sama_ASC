<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-display font-semibold text-xl text-nuit-dakar leading-tight">Annonces</h2>
            @role('admin_asc|coach')
                <a href="{{ route('annonces.create') }}"
                   class="bg-vert-teranga hover:opacity-90 text-white px-4 py-2 rounded-lg text-sm font-medium">
                    + Publier une annonce
                </a>
            @endrole
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if (session('success'))
                <div class="p-4 bg-green-100 border-l-4 border-green-600 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @forelse ($annonces as $annonce)
                <div class="bg-white shadow-sm rounded-xl p-6">
                    <div class="flex justify-between items-start">
                        <h3 class="font-display font-semibold text-lg text-nuit-dakar">
                            <a href="{{ route('annonces.show', $annonce) }}" class="hover:underline">{{ $annonce->titre }}</a>
                        </h3>
                        <span class="text-xs text-gray-400 font-mono">{{ $annonce->date_publication->format('d/m/Y H:i') }}</span>
                    </div>
                    <p class="text-gray-600 mt-2 line-clamp-2">{{ $annonce->contenu }}</p>
                    <p class="text-xs text-gray-400 mt-3">Publie par {{ $annonce->auteur->name }}</p>
                </div>
            @empty
                <div class="bg-white shadow-sm rounded-xl p-6 text-center text-gray-500">
                    Aucune annonce pour le moment.
                </div>
            @endforelse

            <div>{{ $annonces->links() }}</div>
        </div>
    </div>
</x-app-layout>