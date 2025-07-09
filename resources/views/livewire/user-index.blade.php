<div class="max-w-6xl mx-auto py-8 px-4">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Daftar User</h1>
        <p class="text-gray-600">Kelola data user dengan fitur search dan pagination</p>

        <!-- Debug Info (temporary) -->
        <div class="mt-2 p-2 bg-gray-100 rounded text-sm text-gray-700">
            Debug: Search = "{{ $search }}" |
            Users Count = {{ $users->count() }} |
            Total = {{ $users->total() }} |
            Current Page = {{ $users->currentPage() }} |
            Confirming Delete = "{{ $confirmingDelete }}"
        </div>

        <!-- Performance Info -->
        <div class="mt-2 p-2 bg-blue-50 border border-blue-200 rounded text-sm">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" />
                </svg>
                <span class="text-blue-800">
                    <strong>Query Speed:</strong> {{ $queryTime }}ms
                    @if($search)
                        | <strong>Search Mode:</strong> "{{ $search }}" found {{ $users->total() }} results
                    @else
                        | <strong>Browse Mode:</strong> Loading all users
                    @endif
                    | <strong>Performance:</strong>
                    @if($queryTime < 10)
                        <span class="text-green-600 font-semibold">⚡ EXCELLENT</span>
                    @elseif($queryTime < 50)
                        <span class="text-blue-600 font-semibold">🚀 VERY GOOD</span>
                    @elseif($queryTime < 100)
                        <span class="text-yellow-600 font-semibold">⚠️ GOOD</span>
                    @else
                        <span class="text-red-600 font-semibold">🐌 NEEDS OPTIMIZATION</span>
                    @endif
                </span>
            </div>
        </div>
    </div>

    <!-- Search & Add Button -->
    <div class="mb-6 flex flex-col sm:flex-row gap-4 justify-between items-center">
        <div class="w-full sm:w-auto flex gap-2">
            <input type="text" wire:model.defer="search" wire:keyup.enter="$refresh" placeholder="Cari nama user..."
                class="w-full sm:w-64 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
            <button wire:click="$refresh"
                class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-200">
                Cari
            </button>
            @if($search)
                <button wire:click="$set('search', '')"
                    class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition duration-200">
                    Reset
                </button>
            @endif
        </div>
        <div class="flex gap-2">
            <a href="{{ route('users.create') }}"
                class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-medium transition duration-200">
                + Tambah User
            </a>
        </div>
    </div>

    <!-- Flash Messages -->
    @if (session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg" x-data="{ show: true }"
            x-show="show" x-init="setTimeout(() => show = false, 5000)">
            <div class="flex items-center">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd"></path>
                </svg>
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg" x-data="{ show: true }"
            x-show="show" x-init="setTimeout(() => show = false, 5000)">
            <div class="flex items-center">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                        clip-rule="evenodd"></path>
                </svg>
                {{ session('error') }}
            </div>
        </div>
    @endif

    <!-- Users Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Alamat</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($users as $index => $user)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ ($users->currentPage() - 1) * $users->perPage() + $index + 1 }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">{{ $user->address }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-3">
                                    <a href="{{ route('users.edit', $user) }}"
                                        class="text-blue-600 hover:text-blue-900 transition duration-200">
                                        Edit
                                    </a>
                                    <button wire:click="confirmDelete('{{ $user->id }}')"
                                        wire:key="delete-btn-{{ $user->id }}"
                                        class="text-red-600 hover:text-red-900 transition duration-200">
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Confirmation Row (hanya tampil jika confirmingDelete === user.id) -->
                        @if ($confirmingDelete == $user->id)
                            <tr class="bg-yellow-50" wire:key="confirm-row-{{ $user->id }}">
                                <td colspan="4" class="px-6 py-4">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 text-yellow-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            <span class="text-sm text-gray-700">
                                                Yakin ingin menghapus user <strong>{{ $user->name }}</strong>?
                                                <span class="text-xs text-gray-500">(ID:
                                                    {{ substr($user->id, 0, 8) }}...)</span>
                                            </span>
                                        </div>
                                        <div class="flex items-center space-x-3">
                                            <button wire:click="delete('{{ $user->id }}')"
                                                wire:key="delete-confirm-{{ $user->id }}"
                                                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded text-sm font-medium transition duration-200">
                                                Ya, Hapus
                                            </button>
                                            <button wire:click="cancelDelete" wire:key="delete-cancel-{{ $user->id }}"
                                                class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded text-sm font-medium transition duration-200">
                                                Batal
                                            </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center">
                                <div class="text-gray-500">
                                    <svg class="w-12 h-12 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2M4 13h2m13-8l-8 8-4-4">
                                        </path>
                                    </svg>
                                    <p class="text-lg font-medium mb-1">Tidak ada data user</p>
                                    <p class="text-sm">Coba ubah kata kunci pencarian atau tambah user baru</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if ($users->hasPages())
        <div class="mt-6">
            {{ $users->links() }}
        </div>
    @endif
</div>