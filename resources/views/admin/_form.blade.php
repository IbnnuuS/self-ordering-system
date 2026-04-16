<div class="mb-3">
    <label class="block text-sm font-semibold text-gray-700 mb-1">Kategori</label>
    <select name="category_id" class="w-full border rounded-xl px-3 py-2" required>
        <option value="">-- Pilih Kategori --</option>
        @foreach($categories as $cat)
        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
        @endforeach
    </select>
</div>
<div class="mb-3">
    <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Menu</label>
    <input type="text" name="name" class="w-full border rounded-xl px-3 py-2" placeholder="Nama menu" required>
</div>
<div class="mb-3">
    <label class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi</label>
    <textarea name="description" class="w-full border rounded-xl px-3 py-2" rows="2" placeholder="Deskripsi singkat"></textarea>
</div>
<div class="mb-3">
    <label class="block text-sm font-semibold text-gray-700 mb-1">Harga (Rp)</label>
    <input type="number" name="price" class="w-full border rounded-xl px-3 py-2" placeholder="25000" required>
</div>
<div class="mb-3 flex items-center gap-2">
    <input type="checkbox" name="is_available" value="1" id="is_available" checked>
    <label for="is_available" class="text-sm font-semibold text-gray-700">Tersedia</label>
</div>
