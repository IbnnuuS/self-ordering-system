<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Menu;

class KioskController extends Controller
{
    public function index()
    {
        return view('kiosk.index');
    }

    public function menu()
    {
        $categories = Category::with(['menus' => function ($q) {
            $q->where('is_available', true);
        }])->where('is_active', true)->get();

        return view('kiosk.menu', compact('categories'));
    }
}
