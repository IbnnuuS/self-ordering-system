<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Menu;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $totalOrders   = Order::count();
        $totalRevenue  = Order::where('payment_status', 'paid')->sum('total_amount');
        $pendingOrders = Order::where('order_status', 'waiting')->count();
        $menus         = Menu::with('category')->get();
        $categories    = Category::all();

        return view('admin.index', compact('totalOrders', 'totalRevenue', 'pendingOrders', 'menus', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id'  => 'required|exists:categories,id',
            'name'         => 'required|string|max:100',
            'description'  => 'nullable|string',
            'price'        => 'required|numeric|min:0',
            'is_available' => 'boolean',
        ]);

        Menu::create($request->only(['category_id', 'name', 'description', 'price', 'is_available']));

        return back()->with('success', 'Menu berhasil ditambahkan.');
    }

    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'category_id'  => 'required|exists:categories,id',
            'name'         => 'required|string|max:100',
            'description'  => 'nullable|string',
            'price'        => 'required|numeric|min:0',
            'is_available' => 'boolean',
        ]);

        $menu->update($request->only(['category_id', 'name', 'description', 'price', 'is_available']));

        return back()->with('success', 'Menu berhasil diupdate.');
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();
        return back()->with('success', 'Menu berhasil dihapus.');
    }
}
