@extends('layouts.admin')
@section('title', 'Kategori')
@section('page-title', 'Kategori')
@section('page-subtitle', 'Home / Kategori')

@section('content')
<div x-data="{ showModal: false, editData: null }">

    <div class="flex items-center justify-between mb-5">
        <p class="text-sm text-gray-500">Total {{ $categories->count() }} kategori</p>
        <button @click="showModal = true; editData = null"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2.5 rounded-xl text-sm font-semibold flex items-center gap-2 transition-colors">
            <i class="fa-solid fa-plus"></i> Tambah Kategori
        </button>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wide">#</th>
                    <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wide">Nama Kategori</th>
                    <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wide">Tipe</th>
                    <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wide">Jumlah Menu</th>
                    <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wide">Status</th>
                    <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wide">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($categories as $i => $category)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-5 py-3.5 text-gray-400">{{ $i + 1 }}</td>
                    <td class="px-5 py-3.5">
                        <span class="font-semibold text-gray-800">{{ $category->name }}</span>
                    </td>
                    <td class="px-5 py-3.5">
                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold
                            {{ $category->type === 'food' ? 'bg-orange-100 text-orange-700' : 'bg-blue-100 text-blue-700' }}">
                            {{ $category->type === 'food' ? '🍛 Makanan' : '🥤 Minuman' }}
                        </span>
                    </td>
                    <td class="px-5 py-3.5 text-gray-600">
                        {{ $category->menus_count }} menu
                    </td>
                    <td class="px-5 py-3.5">
                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold
                            {{ $category->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $category->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-2">
                            <button @click="editData = {{ $category->toJson() }}; showModal = true"
                                    class="w-8 h-8 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center transition-colors">
                                <i class="fa-solid fa-pen text-xs"></i>
                            </button>
                            <form method="POST" action="{{ route('admin.categories.destroy', $category) }}"
                                  onsubmit="return confirm('Hapus kategori {{ $category->name }}?')">
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
    </div>

    {{-- Modal --}}
    <div x-show="showModal" x-cloak
         class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4"
         @click.self="showModal = false; editData = null">
        <div class="bg-white rounded-2xl w-full max-w-md shadow-2xl">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <h3 class="font-bold text-gray-800" x-text="editData ? 'Edit Kategori' : 'Tambah Kategori'"></h3>
                <button @click="showModal = false; editData = null" class="text-gray-400 hover:text-gray-600">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <form method="POST"
                  :action="editData ? `/admin/categories/${editData.id}` : '{{ route('admin.categories.store') }}'">
                @csrf
                <span x-show="editData" x-html="'<input type=\'hidden\' name=\'_method\' value=\'PUT\'>'"></span>

                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Kategori</label>
                        <input type="text" name="name" :value="editData ? editData.name : ''"
                               class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400"
                               placeholder="Nama kategori" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tipe</label>
                        <select name="type" class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400" required>
                            <option value="food" :selected="editData && editData.type === 'food'">🍛 Makanan</option>
                            <option value="drink" :selected="editData && editData.type === 'drink'">🥤 Minuman</option>
                        </select>
                    </div>
                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="is_active" value="1" id="modal_active"
                               :checked="editData ? editData.is_active : true"
                               class="w-4 h-4 text-indigo-600 rounded">
                        <label for="modal_active" class="text-sm font-semibold text-gray-700">Kategori aktif</label>
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
