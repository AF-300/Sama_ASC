<x-guest-layout>
    <div class="text-center">
        <p class="font-display font-bold text-6xl text-or-sable mb-2">404</p>
        <h2 class="font-display font-semibold text-2xl text-nuit-dakar mb-3">Page introuvable</h2>
        <p class="text-gray-500 mb-6">La page que tu cherches n'existe pas ou a ete deplacee.</p>
        <a href="{{ route('dashboard') }}" class="inline-block bg-vert-teranga hover:opacity-90 text-white font-medium px-6 py-2.5 rounded-lg transition">
            Retour au dashboard
        </a>
    </div>
</x-guest-layout>