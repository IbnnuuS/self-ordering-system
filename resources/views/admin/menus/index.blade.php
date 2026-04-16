@extends('layouts.admin')
@section('title', 'Manajemen Menu')
@section('page-title', 'Manajemen Menu')
@section('page-subtitle', 'Home / Manajemen Menu')

@section('content')
<div x-data="{ showModal: false, editData: null, deleteId: null }">

    {{-- Header Action --}}
    <div class="flex items-center justify-between mb-5">
        <div>
            <p class="text-sm text-gray-500">Total {{ $menus->count() }} menu terdaftar</p>
        </div>
        <button @click="showModal = true; editData = null"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2.5 rounded-xl text-sm font-semibold flex items-center gap-2 transition-colors">
            <i class="fa-solid fa-plus"></i> Tambah Menu
        </button>
    </div>

    {{-- Filter by Category --}}
    <div class="flex gap-2 mb-4 flex-wrap">
        <a href="{{ route('admin.menus.index') }}"
           class="px-4 py-2 rounded-xl text-sm font-semibold transition-colors
                  {{ !request('category') ? 'bg-indigo-600 text-white' : 'bg-white text-gray-600 border border-gray-200' }}">
            Semua
        </a>
        @foreach($categories as $cat)
        <a href="{{ route('admin.menus.index', ['category' => $cat->id]) }}"
           class="px-4 py-2 rounded-xl text-sm font-semibold transition-colors
                  {{ request('category') == $cat->id ? 'bg-indigo-600 text-white' : 'bg-white text-gray-600 border border-gray-200' }}">
            {{ $cat->name }}
        </a>
        @endforeach
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wide">#</th>
                    <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wide">Nama Menu</th>
                    <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wide">Kategori</th>
                    <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wide">Harga</th>
                    <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wide">Status</th>
                    <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wide">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($menus as $i => $menu)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-5 py-3.5 text-gray-400">{{ $i + 1 }}</td>
                    <td class="px-5 py-3.5">
                        <p class="font-semibold text-gray-800">{{ $menu->name }}</p>
                        <p class="text-xs text-gray-400 truncate max-w-xs">{{ $menu->description }}</p>
                    </td>
                    <td class="px-5 py-3.5">
                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold
                            {{ $menu->category->type === 'food' ? 'bg-orange-100 text-orange-700' : 'bg-blue-100 text-blue-700' }}">
                            {{ $menu->category->name }}
                        </span>
                    </td>
                    <td class="px-5 py-3.5 font-semibold text-gray-800">
                        Rp {{ number_format($menu->price, 0, ',', '.') }}
                    </td>
                    <td class="px-5 py-3.5">
                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold
                            {{ $menu->is_available ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $menu->is_available ? 'Tersedia' : 'Habis' }}
                        </span>
                    </td>
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-2">
                            <button @click="editData = {{ $menu->toJson() }}; showModal = true"
                                    class="w-8 h-8 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center transition-colors">
                                <i class="fa-solid fa-pen text-xs"></i>
                            </button>
                            <form method="POST" action="{{ route('admin.menus.destroy', $menu) }}"
                                  onsubmit="return confirm('Hapus menu {{ $menu->name }}?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="w-8 h-8 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg flex items-center justify-center transition-colors">
                                    <i class="fa-solid fa-trash text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        @if($menus->isEmpty())
        <div class="text-center py-16 text-gray-400">
            <i class="fa-solid fa-bowl-food text-4xl mb-3"></i>
            <p>Belum ada menu</p>
        </div>
        @endif
    </div>

    {{-- Modal Tambah/Edit --}}
    <div x-show="showModal" x-cloak
         class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4"
         @click.self="showModal = false; editData = null">
        <div class="bg-white rounded-2xl w-full max-w-md shadow-2xl">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <h3 class="font-bold text-gray-800" x-text="editData ? 'Edit Menu' : 'Tambah Menu'"></h3>
                <button @click="showModal = false; editData = null" class="text-gray-400 hover:text-gray-600">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <form method="POST"
                  :action="editData ? `/admin/menus/${editData.id}` : '{{ route('admin.menus.store') }}'">
                @csrf
                <span x-show="editData" x-html="'<input type=\'hidden\' name=\'_method\' value=\'PUT\'>'"></span>

                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Kategori</label>
                        <select name="category_id" class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" :selected="editData && editData.category_id == {{ $cat->id }}">
                                {{ $cat->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Menu</label>
                        <input type="text" name="name" :value="editData ? editData.name : ''"
                               class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400"
                               placeholder="Nama menu" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Deskripsi</label>
                        <textarea name="description" rows="2"
                                  class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400"
                                  placeholder="Deskripsi singkat"
                                  x-effect="$el.value = editData ? (editData.description || '') : ''"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Harga (Rp)</label>
                        <input type="number" name="price" :value="editData ? editData.price : ''"
                               class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400"
                               placeholder="25000" required>
                    </div>
                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="is_available" value="1" id="modal_available"
                               :checked="editData ? editData.is_available : true"
                               class="w-4 h-4 text-indigo-600 rounded">
                        <label for="modal_available" class="text-sm font-semibold text-gray-700">Menu tersedia</label>
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
