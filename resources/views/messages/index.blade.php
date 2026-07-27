<x-app-layout>
    <x-slot name="header">
        <h2 class="font-display font-semibold text-xl text-nuit-dakar leading-tight">Messagerie</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-xl overflow-hidden divide-y divide-gray-100">
                @forelse ($contacts as $contact)
                    @php $dernier = $derniersMessages->get($contact->id); @endphp
                    <a href="{{ route('messages.show', $contact) }}"
                       class="flex justify-between items-center px-6 py-4 hover:bg-gray-50">
                        <div>
                            <p class="font-medium text-gray-900">{{ $contact->name }}</p>
                            @if ($dernier)
                                <p class="text-sm text-gray-500 truncate max-w-md">{{ $dernier->contenu }}</p>
                            @else
                                <p class="text-sm text-gray-400 italic">Aucun message echange</p>
                            @endif
                        </div>
                        @if ($nonLus->get($contact->id))
                            <span class="bg-vert-teranga text-white text-xs font-mono font-medium px-2 py-1 rounded-full">
                                {{ $nonLus->get($contact->id) }}
                            </span>
                        @endif
                    </a>
                @empty
                    <p class="px-6 py-6 text-center text-gray-500">Aucun autre utilisateur pour le moment.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>