<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('messages.index') }}" class="text-gray-400 hover:text-gray-700">&larr;</a>
            <h2 class="font-display font-semibold text-xl text-nuit-dakar leading-tight">{{ $user->name }}</h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-xl p-6 flex flex-col h-[500px]">

                <div class="flex-1 overflow-y-auto space-y-3 mb-4">
                    @forelse ($messages as $message)
                        @php $estMoi = $message->expediteur_id === auth()->id(); @endphp
                        <div class="flex {{ $estMoi ? 'justify-end' : 'justify-start' }}">
                            <div class="max-w-xs px-4 py-2 rounded-lg text-sm {{ $estMoi ? 'bg-vert-teranga text-white' : 'bg-gray-100 text-gray-800' }}">
                                {{ $message->contenu }}
                                <p class="text-xs mt-1 font-mono {{ $estMoi ? 'text-white/70' : 'text-gray-400' }}">
                                    {{ $message->created_at->format('d/m H:i') }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-400 text-sm">Aucun message pour l'instant. Dis bonjour !</p>
                    @endforelse
                </div>

                <form action="{{ route('messages.store', $user) }}" method="POST" class="flex gap-2 pt-4 border-t border-gray-100">
                    @csrf
                    <input type="text" name="contenu" placeholder="Ecrire un message..." required
                           class="flex-1 rounded-lg border-gray-300 shadow-sm">
                    <button type="submit" class="bg-vert-teranga hover:opacity-90 text-white px-4 py-2 rounded-lg text-sm">
                        Envoyer
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>