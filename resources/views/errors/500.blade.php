<x-guest-layout>
    <div class="text-center">
        <p class="font-display font-bold text-6xl text-nuit-dakar mb-2">500</p>
        <h2 class="font-display font-semibold text-2xl text-nuit-dakar mb-3">Une erreur est survenue</h2>
        <p class="text-gray-500 mb-6">Quelque chose s'est mal passe de notre cote. Reessaie dans un instant.</p>
        <a href="{{ route('dashboard') }}" class="inline-block bg-vert-teranga hover:opacity-90 text-white font-medium px-6 py-2.5 rounded-lg transition">
            Retour au dashboard
        </a>
    </div>
</x-guest-layout>