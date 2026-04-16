@extends('layouts.app')
@section('title', 'Menu')

@section('content')
<div x-data="kioskMenu()" class="min-h-screen bg-gray-100 flex flex-col">

    {{-- Header --}}
    <div class="bg-orange-500 text-white px-6 py-4 flex items-center justify-between sticky top-0 z-10 shadow-lg">
        <a href="{{ route('kiosk') }}" class="text-2xl">← Kembali</a>
        <h1 class="text-2xl font-bold">Menu</h1>
        <button @click="showCart = true" class="relative text-2xl">
            🛒
            <span x-show="totalItems > 0"
                  x-text="totalItems"
                  class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold">
            </span>
        </button>
    </div>

    {{-- Category Tabs --}}
    <div class="bg-white shadow flex overflow-x-auto sticky top-16 z-10">
        @foreach($categories as $category)
        <button @click="activeCategory = {{ $category->id }}"
                :class="activeCategory === {{ $category->id }} ? 'border-b-4 border-orange-500 text-orange-500 font-bold' : 'text-gray-500'"
                class="px-6 py-4 text-lg whitespace-nowrap flex-shrink-0 transition-colors">
            {{ $category->type === 'food' ? '🍛' : '🥤' }} {{ $category->name }}
        </button>
        @endforeach
    </div>

    {{-- Menu Grid --}}
    <div class="flex-1 p-4 overflow-y-auto pb-32">
        @foreach($categories as $category)
        <div x-show="activeCategory === {{ $category->id }}">
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                @foreach($category->menus as $menu)
                <div class="bg-white rounded-2xl shadow-md overflow-hidden active:scale-95 transition-transform touch-manipulation"
                     @click="addToCart({{ $menu->id }}, '{{ addslashes($menu->name) }}', {{ $menu->price }})">
                    <div class="bg-orange-100 h-32 flex items-center justify-center text-5xl">
                        {{ $category->type === 'food' ? '🍛' : '🥤' }}
                    </div>
                    <div class="p-3">
                        <h3 class="font-bold text-gray-800 text-sm leading-tight">{{ $menu->name }}</h3>
                        <p class="text-orange-500 font-bold mt-1">Rp {{ number_format($menu->price, 0, ',', '.') }}</p>
                        <button class="mt-2 w-full bg-orange-500 text-white rounded-xl py-2 text-sm font-bold">
                            + Tambah
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>

    {{-- Bottom Bar --}}
    <div x-show="totalItems > 0"
         class="fixed bottom-0 left-0 right-0 bg-orange-500 text-white p-4 shadow-2xl">
        <button @click="showCart = true"
                class="w-full flex items-center justify-between text-xl font-bold py-2">
            <span class="bg-orange-600 rounded-full px-3 py-1 text-sm" x-text="totalItems + ' item'"></span>
            <span>Lihat Keranjang</span>
            <span x-text="'Rp ' + formatRupiah(totalPrice)"></span>
        </button>
    </div>

    {{-- Cart Modal --}}
    <div x-show="showCart"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-end"
         @click.self="showCart = false">

        <div class="bg-white w-full rounded-t-3xl max-h-[85vh] flex flex-col">
            <div class="p-5 border-b flex items-center justify-between">
                <h2 class="text-2xl font-bold">Keranjang</h2>
                <button @click="showCart = false" class="text-3xl text-gray-400">×</button>
            </div>

            <div class="overflow-y-auto flex-1 p-4">
                <template x-for="item in cart" :key="item.id">
                    <div class="flex items-center justify-between py-3 border-b">
                        <div class="flex-1">
                            <p class="font-semibold text-gray-800" x-text="item.name"></p>
                            <p class="text-orange-500 font-bold" x-text="'Rp ' + formatRupiah(item.price)"></p>
                        </div>
                        <div class="flex items-center gap-3">
                            <button @click="decreaseQty(item.id)"
                                    class="w-9 h-9 bg-gray-200 rounded-full text-xl font-bold flex items-center justify-center">−</button>
                            <span class="text-xl font-bold w-6 text-center" x-text="item.qty"></span>
                            <button @click="increaseQty(item.id)"
                                    class="w-9 h-9 bg-orange-500 text-white rounded-full text-xl font-bold flex items-center justify-center">+</button>
                        </div>
                    </div>
                </template>
            </div>

            <div class="p-5 border-t bg-gray-50">
                <div class="flex justify-between text-xl font-bold mb-4">
                    <span>Total</span>
                    <span class="text-orange-500" x-text="'Rp ' + formatRupiah(totalPrice)"></span>
                </div>
                <form method="POST" action="{{ route('order.store') }}" @submit="prepareOrder">
                    @csrf
                    <div id="cart-inputs"></div>
                    <button type="submit"
                            class="w-full bg-orange-500 text-white font-bold text-xl py-4 rounded-2xl active:scale-95 transition-transform">
                        Lanjut ke Pembayaran →
                    </button>
                </form>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>
function kioskMenu() {
    return {
        activeCategory: {{ $categories->first()->id ?? 0 }},
        showCart: false,
        cart: [],

        get totalItems() {
            return this.cart.reduce((sum, i) => sum + i.qty, 0);
        },
        get totalPrice() {
            return this.cart.reduce((sum, i) => sum + (i.price * i.qty), 0);
        },

        addToCart(id, name, price) {
            const existing = this.cart.find(i => i.id === id);
            if (existing) {
                existing.qty++;
            } else {
                this.cart.push({ id, name, price, qty: 1 });
            }
        },
        increaseQty(id) {
            const item = this.cart.find(i => i.id === id);
            if (item) item.qty++;
        },
        decreaseQty(id) {
            const item = this.cart.find(i => i.id === id);
            if (item) {
                item.qty--;
                if (item.qty <= 0) this.cart = this.cart.filter(i => i.id !== id);
            }
        },
        formatRupiah(val) {
            return val.toLocaleString('id-ID');
        },
        prepareOrder(e) {
            const container = document.getElementById('cart-inputs');
            container.innerHTML = '';
            this.cart.forEach((item, index) => {
                container.innerHTML += `<input type="hidden" name="items[${index}][menu_id]" value="${item.id}">`;
                container.innerHTML += `<input type="hidden" name="items[${index}][quantity]" value="${item.qty}">`;
            });
        }
    }
}
</script>
@endpush
@endsection
