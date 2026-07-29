<x-app-layout>
    <x-slot name="header">
        <h2 class="font-display font-semibold text-xl text-nuit-dakar leading-tight">Utilisateurs</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-600 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-600 text-red-800 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white shadow-sm rounded-xl overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nom</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Role</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($utilisateurs as $utilisateur)
                            <tr>
                                <td class="px-6 py-3 font-medium text-gray-900">{{ $utilisateur->name }}</td>
                                <td class="px-6 py-3 text-gray-600">{{ $utilisateur->email }}</td>
                                <td class="px-6 py-3 text-gray-600">{{ $utilisateur->roles->pluck('name')->join(', ') ?: '-' }}</td>
                                <td class="px-6 py-3 text-right">
                                    <form action="{{ route('utilisateurs.destroy', $utilisateur) }}" method="POST"
                                          onsubmit="return confirm('Supprimer {{ $utilisateur->name }} ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="px-3 py-1.5 rounded-lg bg-red-50 text-red-700 text-sm font-medium hover:bg-red-100">
                                            Supprimer
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>