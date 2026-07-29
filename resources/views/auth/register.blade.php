<x-guest-layout>
    <h2 class="font-display font-semibold text-2xl text-nuit-dakar mb-1">Inscription</h2>
    <p class="text-sm text-gray-500 mb-6">Rejoins ton ASC sur Sama ASC</p>

    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="name" :value="__('Nom complet')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('Mot de passe')" />
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Role -->
        <div>
            <x-input-label for="role" :value="__('Je suis un(e)')" />
            <select id="role" name="role" required
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-vert-teranga focus:ring-vert-teranga">
                <option value="joueur" @selected(old('role') === 'joueur')>Joueur</option>
                <option value="supporter" @selected(old('role') === 'supporter')>Supporter</option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <!-- Photo (uniquement pour les joueurs) -->
        <div x-data="{ role: document.getElementById('role').value }"
             x-init="document.getElementById('role').addEventListener('change', e => role = e.target.value)"
             x-show="role === 'joueur'">
            <x-input-label for="photo" :value="__('Ta photo (optionnel)')" />
            <input id="photo" type="file" name="photo" accept="image/*"
                   class="mt-1 block w-full text-sm text-gray-700">
            <x-input-error :messages="$errors->get('photo')" class="mt-2" />
        </div>

        <button type="submit" class="w-full bg-vert-teranga hover:opacity-90 text-white font-medium py-2.5 rounded-lg transition">
            {{ __("S'inscrire") }}
        </button>

        <p class="text-center text-sm text-gray-500 pt-2">
            Deja un compte ?
            <a href="{{ route('login') }}" class="text-vert-teranga font-medium hover:underline">Connecte-toi</a>
        </p>
    </form>
</x-guest-layout>