@extends('layouts.app')
@section('title', 'Admin')

@section('content')
<div class="min-h-screen bg-gray-100" x-data="{ showAdd: false, editMenu: null }">

    <div class="bg-gray-800 text-white px-6 py-4 flex items-center justify-between">
        <h1 class="text-2xl font-bold">⚙️ Admin Panel</h1>
        <div class="flex gap-3 text-sm">
            <a href="{{ route('kasir.index') }}" class="bg-gray-600 px-4 py-2 rounded-lg">Kasir</a>
            <a href="{{ route('kitchen.index') }}" class="bg-green-600 px-4 py-2 rounded-lg">Kitchen</a>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 m-4 rounded-xl">
        {{ session('success') }}
    </div>
    @endif

    {{-- Stats --}}
    <div class="grid grid-cols-3 gap-4 p-4">
        <div class="bg-white rounded-2xl shadow p-4 text-center">
            <p class="text-3xl font-bold text-orange-500">{{ $totalOrders }}</p>
            <p class="text-gray-500 text-sm">Total Order</p>
        </div>
        <div class="bg-white rounded-2xl shadow p-4 text-center">
            <p class="text-2xl font-bold text-green-500">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
            <p class="text-gray-500 text-sm">Total Pendapatan</p>
        </div>
        <div class="bg-white rounded-2xl shadow p-4 text-center">
            <p class="text-3xl font-bold text-blue-500">{{ $pendingOrders }}</p>
            <p class="text-gray-500 text-sm">Order Pending</p>
        </div>
    </div>

    {{-- Menu Management --}}
    <div class="p-4">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold text-gray-800">Manajemen Menu</h2>
            <button @click="showAdd = true"
                    class="bg-orange-500 text-white px-4 py-2 rounded-xl font-bold active:scale-95 transition-transform">
                + Tambah Menu
            </button>
        </div>

        <div class="bg-white rounded-2xl shadow overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-gray-600">
                    <tr>
                        <th class="text-left px-4 py-3">Nama</th>
                        <th class="text-left px-4 py-3">Kategori</th>
                        <th class="text-left px-4 py-3">Harga</th>
                        <th class="text-left px-4 py-3">Status</th>
                        <th class="text-left px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($menus as $menu)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-4 py-3 font-semibold">{{ $menu->name }}</td>
                        <td class="px-4 py-3 text-gray-500">{{ $menu->category->name }}</td>
                        <td class="px-4 py-3 text-orange-500 font-semibold">Rp {{ number_format($menu->price, 0, ',', '.') }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold
                                {{ $menu->is_available ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $menu->is_available ? 'Tersedia' : 'Habis' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 flex gap-2">
                            <button @click="editMenu = {{ $menu->toJson() }}"
                                    class="bg-blue-100 text-blue-600 px-3 py-1 rounded-lg text-xs font-semibold">Edit</button>
                            <form method="POST" action="{{ route('admin.menus.destroy', $menu) }}"
                                  onsubmit="return confirm('Hapus menu ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="bg-red-100 text-red-600 px-3 py-1 rounded-lg text-xs font-semibold">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal Tambah --}}
    <div x-show="showAdd" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4"
         @click.self="showAdd = false">
        <div class="bg-white rounded-2xl p-6 w-full max-w-md">
            <h3 class="text-xl font-bold mb-4">Tambah Menu</h3>
            <form method="POST" action="{{ route('admin.menus.store') }}">
                @csrf
                @include('admin._form')
                <div class="flex gap-3 mt-4">
                    <button type="button" @click="showAdd = false"
                            class="flex-1 bg-gray-200 text-gray-700 py-3 rounded-xl font-semibold">Batal</button>
                    <button type="submit"
                            class="flex-1 bg-orange-500 text-white py-3 rounded-xl font-bold">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Edit --}}
    <div x-show="editMenu !== null" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4"
         @click.self="editMenu = null">
        <div class="bg-white rounded-2xl p-6 w-full max-w-md" x-show="editMenu !== null">
            <h3 class="text-xl font-bold mb-4">Edit Menu</h3>
            <template x-if="editMenu">
                <form method="POST" :action="`/admin/menus/${editMenu.id}`">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Kategori</label>
                        <select name="category_id" class="w-full border rounded-xl px-3 py-2" required>
                            @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" :selected="editMenu.category_id === {{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Menu</label>
                        <input type="text" name="name" :value="editMenu.name" class="w-full border rounded-xl px-3 py-2" required>
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi</label>
                        <textarea name="description" class="w-full border rounded-xl px-3 py-2" rows="2" x-text="editMenu.description"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Harga</label>
                        <input type="number" name="price" :value="editMenu.price" class="w-full border rounded-xl px-3 py-2" required>
                    </div>
                    <div class="mb-3 flex items-center gap-2">
                        <input type="checkbox" name="is_available" value="1" id="edit_available"
                               :checked="editMenu.is_available">
                        <label for="edit_available" class="text-sm font-semibold text-gray-700">Tersedia</label>
                    </div>
                    <div class="flex gap-3 mt-4">
                        <button type="button" @click="editMenu = null"
                                class="flex-1 bg-gray-200 text-gray-700 py-3 rounded-xl font-semibold">Batal</button>
                        <button type="submit"
                                class="flex-1 bg-orange-500 text-white py-3 rounded-xl font-bold">Update</button>
                    </div>
                </form>
            </template>
        </div>
    </div>

</div>
@endsection
