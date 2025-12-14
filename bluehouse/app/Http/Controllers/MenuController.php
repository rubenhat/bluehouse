<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $category = $request->get('category');

        $menusQuery = Menu::query();

        // Hanya tampilkan menu yang tersedia
        $menusQuery->where('is_available', true);

        // Filter by search
        if ($search) {
            $menusQuery->where(function($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                      ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        // Filter by category
        if ($category && $category !== 'all') {
            $menusQuery->where('category', $category);
        }

        // Order by category then name
        $menusQuery->orderBy('category')->orderBy('name');

        // Get menus with pagination
        $menus = $menusQuery->paginate(12)->withQueryString();

        // Get available categories for filter
        $categories = Menu::select('category')
                         ->where('is_available', true)
                         ->distinct()
                         ->pluck('category');

        return view('menu.index', compact('menus', 'categories', 'search', 'category'));
    }
}
