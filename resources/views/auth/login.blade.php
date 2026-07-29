<x-guest-layout>
    <h2 class="font-display font-semibold text-2xl text-nuit-dakar mb-1">Connexion</h2>
    <p class="text-sm text-gray-500 mb-6">Accede a l'espace de ton ASC</p>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('Mot de passe')" />
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-vert-teranga shadow-sm focus:ring-vert-teranga" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Se souvenir de moi') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-vert-teranga hover:underline" href="{{ route('password.request') }}">
                    {{ __('Mot de passe oublie ?') }}
                </a>
            @endif
        </div>

        <button type="submit" class="w-full bg-vert-teranga hover:opacity-90 text-white font-medium py-2.5 rounded-lg transition">
            {{ __('Se connecter') }}
        </button>

        <p class="text-center text-sm text-gray-500 pt-2">
            Pas encore de compte ?
            <a href="{{ route('register') }}" class="text-vert-teranga font-medium hover:underline">Inscris-toi</a>
        </p>
    </form>
</x-guest-layout>