<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->get('category', 'all');
        $search = $request->get('search');

        $menusQuery = Menu::orderBy('created_at', 'desc');

        // Filter by category
        if ($category !== 'all') {
            $menusQuery->where('category', $category);
        }

        // Search
        if ($search) {
            $menusQuery->where(function($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                      ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        $menus = $menusQuery->paginate(12);

        // Categories for filter - gunakan kategori yang sudah didefinisikan
        $categories = collect(['makanan', 'minuman', 'kopi', 'dessert', 'snack']);

        return view('admin.menu', compact('menus', 'categories', 'category', 'search'));
    }

    public function show($id)
    {
        $menu = Menu::findOrFail($id);
        return response()->json($menu);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string|in:makanan,minuman,kopi,dessert,snack',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_available' => 'nullable'
        ];

        $request->validate($rules);

        $data = $request->all();
        $data['is_available'] = $request->has('is_available') ? 1 : 0;

        // Set default category jika tidak ada
        if (!isset($data['category'])) {
            $data['category'] = 'makanan';
        }

        // Upload image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug($request->name) . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('menu-images', $imageName, 'public');
            $data['image'] = $imagePath;
        }

        Menu::create($data);

        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        $rules = [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string|in:makanan,minuman,kopi,dessert,snack', // Perbaikan di sini
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_available' => 'nullable'
        ];

        $request->validate($rules);

        $data = $request->all();
        $data['is_available'] = $request->has('is_available') ? 1 : 0;

        // Upload new image
        if ($request->hasFile('image')) {
            // Delete old image
            if ($menu->image && Storage::disk('public')->exists($menu->image)) {
                Storage::disk('public')->delete($menu->image);
            }

            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug($request->name) . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('menu-images', $imageName, 'public');
            $data['image'] = $imagePath;
        }

        $menu->update($data);

        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil diperbarui');
    }

    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);

        // Delete image
        if ($menu->image && Storage::disk('public')->exists($menu->image)) {
            Storage::disk('public')->delete($menu->image);
        }

        $menu->delete();

        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil dihapus');
    }

    public function toggleStatus($id)
    {
        $menu = Menu::findOrFail($id);

        // Handle jika kolom is_available belum ada
        if (Schema::hasColumn('menus', 'is_available')) {
            $menu->update([
                'is_available' => !$menu->is_available
            ]);
        }

        return redirect()->back()->with('success', 'Status menu berhasil diubah');
    }
}
