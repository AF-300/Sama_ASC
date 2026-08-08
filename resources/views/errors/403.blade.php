<x-guest-layout>
    <div class="text-center">
        <p class="font-display font-bold text-6xl text-rouge-laterite mb-2">403</p>
        <h2 class="font-display font-semibold text-2xl text-nuit-dakar mb-3">Acces refuse</h2>
        <p class="text-gray-500 mb-6">Tu n'as pas les droits necessaires pour acceder a cette page.</p>
        <a href="{{ route('dashboard') }}" class="inline-block bg-vert-teranga hover:opacity-90 text-white font-medium px-6 py-2.5 rounded-lg transition">
            Retour au dashboard
        </a>
    </div>
</x-guest-layout>