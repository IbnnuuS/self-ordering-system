<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function sales(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate   = $request->input('end_date', now()->format('Y-m-d'));

        $orders = Order::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->where('payment_status', 'paid')
            ->get();

        $totalRevenue    = $orders->sum('total_amount');
        $totalOrders     = $orders->count();
        $averageOrder    = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

        // Daily breakdown
        $dailySales = Order::selectRaw('DATE(created_at) as date, COUNT(*) as total_orders, SUM(total_amount) as revenue')
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->where('payment_status', 'paid')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('admin.reports.sales', compact('startDate', 'endDate', 'totalRevenue', 'totalOrders', 'averageOrder', 'dailySales'));
    }

    public function menu(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate   = $request->input('end_date', now()->format('Y-m-d'));

        $topMenus = OrderItem::select('menu_name', DB::raw('SUM(quantity) as total_qty'), DB::raw('SUM(subtotal) as total_revenue'))
            ->whereHas('order', function($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                  ->where('payment_status', 'paid');
            })
            ->groupBy('menu_name')
            ->orderByDesc('total_qty')
            ->get();

        return view('admin.reports.menu', compact('startDate', 'endDate', 'topMenus'));
    }

    public function payment(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate   = $request->input('end_date', now()->format('Y-m-d'));

        $cashOrders = Order::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->where('payment_method', 'cash')
            ->where('payment_status', 'paid')
            ->count();

        $qrisOrders = Order::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->where('payment_method', 'qris')
            ->where('payment_status', 'paid')
            ->count();

        $cashRevenue = Order::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->where('payment_method', 'cash')
            ->where('payment_status', 'paid')
            ->sum('total_amount');

        $qrisRevenue = Order::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->where('payment_method', 'qris')
            ->where('payment_status', 'paid')
            ->sum('total_amount');

        $pendingOrders = Order::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->where('payment_status', 'pending')
            ->with('items')
            ->get();

        return view('admin.reports.payment', compact('startDate', 'endDate', 'cashOrders', 'qrisOrders', 'cashRevenue', 'qrisRevenue', 'pendingOrders'));
    }
}
