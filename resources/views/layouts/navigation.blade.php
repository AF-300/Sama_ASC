<nav x-data="{ open: false }" class="bg-nuit-dakar border-b border-black/20">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                        <img src="{{ asset('logo_ASC.jpg') }}" alt="Sama ASC" class="w-8 h-8 object-contain">
                        <span class="font-display font-bold text-xl text-blanc-sable tracking-tight">
                            Sama <span class="text-or-sable">ASC</span>
                        </span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-6 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        <svg class="w-4 h-4 me-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    <x-nav-link :href="route('annonces.index')" :active="request()->routeIs('annonces.*')">
                        <svg class="w-4 h-4 me-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                        </svg>
                        {{ __('Annonces') }}
                    </x-nav-link>

                    <x-nav-link :href="route('statistiques.classement')" :active="request()->routeIs('statistiques.classement')">
                        <svg class="w-4 h-4 me-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        {{ __('Classement') }}
                    </x-nav-link>

                    @role('joueur')
    <x-nav-link :href="route('matchs.mes-convocations')" :active="request()->routeIs('matchs.mes-convocations')">
        <svg class="w-4 h-4 me-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        {{ __('Mes convocations') }}
    </x-nav-link>
@endrole
<x-nav-link :href="route('messages.index')" :active="request()->routeIs('messages.*')">
    <svg class="w-4 h-4 me-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
    </svg>
    {{ __('Messages') }}
    @php
        $messagesNonLus = \App\Models\Message::where('destinataire_id', auth()->id())->where('lu', false)->count();
    @endphp
    @if ($messagesNonLus > 0)
        <span class="ms-1.5 inline-flex items-center justify-center w-4 h-4 text-xs font-mono font-bold text-white bg-rouge-laterite rounded-full">
            {{ $messagesNonLus }}
        </span>
    @endif
</x-nav-link>

                    <x-nav-link :href="route('matchs.index')" :active="request()->routeIs('matchs.*')">
    <svg class="w-4 h-4 me-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
    </svg>
    {{ __('Matchs') }}
</x-nav-link>

@role('admin_asc|coach')
    <x-nav-link :href="route('joueurs.index')" :active="request()->routeIs('joueurs.*')">
        <svg class="w-4 h-4 me-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-3.13a4 4 0 10-4-4 4 4 0 004 4zm6 3a4 4 0 10-4-4" />
        </svg>
        {{ __('Joueurs') }}
    </x-nav-link>
@endrole

                    @role('admin_asc')
                        <x-nav-link :href="route('caisse.index')" :active="request()->routeIs('caisse.*', 'cotisations.*', 'depenses.*', 'contributeurs.*')">
                            <svg class="w-4 h-4 me-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            {{ __('Finances') }}
                        
                        </x-nav-link>
                        <x-nav-link :href="route('utilisateurs.index')" :active="request()->routeIs('utilisateurs.*')">
    {{ __('Utilisateurs') }}
</x-nav-link>
                    @endrole
                </div>
            </div>

            <!-- Notifications -->
            <div class="hidden sm:flex sm:items-center sm:ms-4">
                <x-dropdown align="right" width="80">
                    <x-slot name="trigger">
                        <button class="relative inline-flex items-center p-2 text-blanc-sable/70 hover:text-blanc-sable focus:outline-none">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            @if (Auth::user()->unreadNotifications->count() > 0)
                                <span class="absolute top-0 right-0 inline-flex items-center justify-center w-4 h-4 text-xs font-mono font-bold text-white bg-rouge-laterite rounded-full">
                                    {{ Auth::user()->unreadNotifications->count() }}
                                </span>
                            @endif
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="max-h-96 overflow-y-auto">
                            @forelse (Auth::user()->notifications()->latest()->limit(10)->get() as $notification)
                                <a href="{{ $notification->data['url'] ?? '#' }}"
                                   class="block px-4 py-3 text-sm border-b border-gray-100 last:border-0 hover:bg-gray-50 {{ $notification->read_at ? 'text-gray-500' : 'text-gray-900 font-medium bg-vert-teranga/5' }}">
                                    {{ $notification->data['message'] ?? 'Notification' }}
                                    <p class="text-xs text-gray-400 font-mono mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                </a>
                            @empty
                                <p class="px-4 py-6 text-center text-sm text-gray-500">Aucune notification.</p>
                            @endforelse
                        </div>
                        @if (Auth::user()->unreadNotifications->count() > 0)
                            <form method="POST" action="{{ route('notifications.marquer-lues') }}" class="border-t border-gray-100">
                                @csrf
                                <button type="submit" class="w-full text-center px-4 py-2 text-xs text-vert-teranga hover:underline">
                                    Tout marquer comme lu
                                </button>
                            </form>
                        @endif
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-4">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-blanc-sable/70 bg-transparent hover:text-blanc-sable focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Notifications mobile -->
            <div class="flex items-center sm:hidden">
                <a href="#" @click.prevent="open = false; $refs.mobileNotifs.classList.toggle('hidden')"
                   class="relative inline-flex items-center p-2 text-blanc-sable/70 hover:text-blanc-sable">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    @if (Auth::user()->unreadNotifications->count() > 0)
                        <span class="absolute top-0 right-0 inline-flex items-center justify-center w-4 h-4 text-xs font-mono font-bold text-white bg-rouge-laterite rounded-full">
                            {{ Auth::user()->unreadNotifications->count() }}
                        </span>
                    @endif
                </a>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-blanc-sable/60 hover:text-blanc-sable hover:bg-white/5 focus:outline-none focus:bg-white/5 focus:text-blanc-sable transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Bande signature -->
    <div class="h-1.5 flex">
        <div class="flex-1 bg-vert-teranga"></div>
        <div class="flex-1 bg-blanc-sable"></div>
    </div>

    <!-- Panneau notifications mobile -->
    <div x-ref="mobileNotifs" class="hidden border-b border-white/10">
        <div class="max-h-72 overflow-y-auto">
            @forelse (Auth::user()->notifications()->latest()->limit(10)->get() as $notification)
                <a href="{{ $notification->data['url'] ?? '#' }}"
                   class="block px-4 py-3 text-sm border-b border-white/5 last:border-0 {{ $notification->read_at ? 'text-blanc-sable/50' : 'text-blanc-sable font-medium bg-white/5' }}">
                    {{ $notification->data['message'] ?? 'Notification' }}
                    <p class="text-xs text-blanc-sable/40 font-mono mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                </a>
            @empty
                <p class="px-4 py-4 text-center text-sm text-blanc-sable/50">Aucune notification.</p>
            @endforelse
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <!-- Responsive Navigation Menu -->
<div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-nuit-dakar max-h-[calc(100vh-5rem)] overflow-y-auto">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('annonces.index')" :active="request()->routeIs('annonces.*')">
                {{ __('Annonces') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('statistiques.classement')" :active="request()->routeIs('statistiques.classement')">
                {{ __('Classement') }}
            </x-responsive-nav-link>

             @role('joueur')
    <x-nav-link :href="route('matchs.mes-convocations')" :active="request()->routeIs('matchs.mes-convocations')">
        <svg class="w-4 h-4 me-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        {{ __('Mes convocations') }}
    </x-nav-link>
@endrole

            <x-responsive-nav-link :href="route('matchs.index')" :active="request()->routeIs('matchs.*')">
    {{ __('Matchs') }}
</x-responsive-nav-link>

@role('admin_asc|coach')
    <x-responsive-nav-link :href="route('joueurs.index')" :active="request()->routeIs('joueurs.*')">
        {{ __('Joueurs') }}
    </x-responsive-nav-link>
@endrole
            <x-responsive-nav-link :href="route('messages.index')" :active="request()->routeIs('messages.*')">
    {{ __('Messages') }}
    @if ($messagesNonLus > 0)
        <span class="ms-1.5 inline-flex items-center justify-center w-4 h-4 text-xs font-mono font-bold text-white bg-rouge-laterite rounded-full">
            {{ $messagesNonLus }}
        </span>
    @endif
</x-responsive-nav-link>

            @role('admin_asc|coach')
                <x-responsive-nav-link :href="route('joueurs.index')" :active="request()->routeIs('joueurs.*')">
                    {{ __('Joueurs') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('matchs.index')" :active="request()->routeIs('matchs.*')">
                    {{ __('Matchs') }}
                </x-responsive-nav-link>
            @endrole

            @role('admin_asc')
                <x-responsive-nav-link :href="route('caisse.index')" :active="request()->routeIs('caisse.*', 'cotisations.*', 'depenses.*', 'contributeurs.*')">
                    {{ __('Finances') }}
                </x-responsive-nav-link>
                <x-nav-link :href="route('utilisateurs.index')" :active="request()->routeIs('utilisateurs.*')">
    {{ __('Utilisateurs') }}
</x-nav-link>
            @endrole
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-white/10">
            <div class="px-4">
                <div class="font-medium text-base text-blanc-sable">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-blanc-sable/50">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>