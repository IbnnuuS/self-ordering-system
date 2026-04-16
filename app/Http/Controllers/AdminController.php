<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Menu;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // Stats hari ini
        $todayOrders   = Order::whereDate('created_at', today())->count();
        $todayRevenue  = Order::whereDate('created_at', today())->where('payment_status', 'paid')->sum('total_amount');
        $pendingOrders = Order::where('payment_status', 'pending')->count();
        $totalMenus    = Menu::where('is_available', true)->count();

        // Recent orders hari ini
        $recentOrders = Order::whereDate('created_at', today())->latest()->take(5)->get();

        // Chart 7 hari terakhir
        $chartLabels = [];
        $chartData   = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = today()->subDays($i);
            $chartLabels[] = $date->format('d M');
            $chartData[]   = Order::whereDate('created_at', $date)->count();
        }

        // Payment method split bulan ini
        $cashCount = Order::whereMonth('created_at', now()->month)
            ->where('payment_method', 'cash')
            ->where('payment_status', 'paid')
            ->count();
        $qrisCount = Order::whereMonth('created_at', now()->month)
            ->where('payment_method', 'qris')
            ->where('payment_status', 'paid')
            ->count();

        // Top menu
        $topMenus = DB::table('order_items')
            ->select('menu_name', DB::raw('SUM(quantity) as total_qty'))
            ->groupBy('menu_name')
            ->orderByDesc('total_qty')
            ->take(5)
            ->get();

        return view('admin.index', compact(
            'todayOrders', 'todayRevenue', 'pendingOrders', 'totalMenus',
            'recentOrders', 'chartLabels', 'chartData',
            'cashCount', 'qrisCount', 'topMenus'
        ));
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
