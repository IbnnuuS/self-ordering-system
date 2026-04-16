@extends('layouts.admin')
@section('title', 'Manajemen User')
@section('page-title', 'Manajemen User')
@section('page-subtitle', 'Home / Manajemen User')

@section('content')
<div x-data="{ showModal: false, editData: null }">

    <div class="flex items-center justify-between mb-5">
        <p class="text-sm text-gray-500">Total {{ $users->count() }} user terdaftar</p>
        <button @click="showModal = true; editData = null"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2.5 rounded-xl text-sm font-semibold flex items-center gap-2 transition-colors">
            <i class="fa-solid fa-plus"></i> Tambah User
        </button>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wide">#</th>
                    <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wide">Nama</th>
                    <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wide">Email</th>
                    <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wide">Dibuat</th>
                    <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wide">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($users as $i => $user)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-5 py-3.5 text-gray-400">{{ $i + 1 }}</td>
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <span class="text-indigo-600 font-bold text-xs">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                            </div>
                            <span class="font-semibold text-gray-800">{{ $user->name }}</span>
                            @if($user->id === auth()->id())
                            <span class="text-xs bg-indigo-100 text-indigo-600 px-2 py-0.5 rounded-full font-semibold">Anda</span>
                            @endif
                        </div>
                    </td>
                    <td class="px-5 py-3.5 text-gray-600">{{ $user->email }}</td>
                    <td class="px-5 py-3.5 text-gray-400 text-xs">{{ $user->created_at->format('d M Y') }}</td>
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-2">
                            <button @click="editData = { id: {{ $user->id }}, name: '{{ $user->name }}', email: '{{ $user->email }}' }; showModal = true"
                                    class="w-8 h-8 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center transition-colors">
                                <i class="fa-solid fa-pen text-xs"></i>
                            </button>
                            @if($user->id !== auth()->id())
                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                                  onsubmit="return confirm('Hapus user {{ $user->name }}?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="w-8 h-8 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg flex items-center justify-center transition-colors">
                                    <i class="fa-solid fa-trash text-xs"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Modal --}}
    <div x-show="showModal" x-cloak
         class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4"
         @click.self="showModal = false; editData = null">
        <div class="bg-white rounded-2xl w-full max-w-md shadow-2xl">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <h3 class="font-bold text-gray-800" x-text="editData ? 'Edit User' : 'Tambah User'"></h3>
                <button @click="showModal = false; editData = null" class="text-gray-400 hover:text-gray-600">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <form method="POST"
                  :action="editData ? `/admin/users/${editData.id}` : '{{ route('admin.users.store') }}'">
                @csrf
                <span x-show="editData" x-html="'<input type=\'hidden\' name=\'_method\' value=\'PUT\'>'"></span>

                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama</label>
                        <input type="text" name="name" :value="editData ? editData.name : ''"
                               class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400"
                               placeholder="Nama lengkap" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Email</label>
                        <input type="email" name="email" :value="editData ? editData.email : ''"
                               class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400"
                               placeholder="email@example.com" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Password <span x-show="editData" class="text-gray-400 font-normal">(kosongkan jika tidak diubah)</span>
                        </label>
                        <input type="password" name="password"
                               class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400"
                               placeholder="••••••••"
                               :required="!editData">
                    </div>
                </div>

                <div class="flex gap-3 px-6 pb-6">
                    <button type="button" @click="showModal = false; editData = null"
                            class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 py-2.5 rounded-xl font-semibold text-sm transition-colors">
                        Batal
                    </button>
                    <button type="submit"
                            class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white py-2.5 rounded-xl font-bold text-sm transition-colors">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
