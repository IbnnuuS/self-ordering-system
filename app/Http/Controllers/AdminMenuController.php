<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Menu;
use Illuminate\Http\Request;

class AdminMenuController extends Controller
{
    public function index()
    {
        $menus      = Menu::with('category')
            ->when(request('category'), fn($q) => $q->where('category_id', request('category')))
            ->get();
        $categories = Category::all();

        return view('admin.menus.index', compact('menus', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id'  => 'required|exists:categories,id',
            'name'         => 'required|string|max:100',
            'description'  => 'nullable|string',
            'price'        => 'required|numeric|min:0',
        ]);

        Menu::create([
            'category_id'  => $request->category_id,
            'name'         => $request->name,
            'description'  => $request->description,
            'price'        => $request->price,
            'is_available' => $request->boolean('is_available', true),
        ]);

        return back()->with('success', 'Menu berhasil ditambahkan.');
    }

    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'category_id'  => 'required|exists:categories,id',
            'name'         => 'required|string|max:100',
            'description'  => 'nullable|string',
            'price'        => 'required|numeric|min:0',
        ]);

        $menu->update([
            'category_id'  => $request->category_id,
            'name'         => $request->name,
            'description'  => $request->description,
            'price'        => $request->price,
            'is_available' => $request->boolean('is_available'),
        ]);

        return back()->with('success', 'Menu berhasil diupdate.');
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();
        return back()->with('success', 'Menu berhasil dihapus.');
    }
}
