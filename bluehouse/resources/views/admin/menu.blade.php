@extends('admin.layout')

@section('title', 'Manajemen Menu')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Manajemen Menu</h1>
        <p class="text-gray-600 mt-1">Kelola item menu cafe</p>
    </div>
    <button onclick="openAddModal()"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
        <i class="fas fa-plus"></i>
        <span>Tambah Menu</span>
    </button>
</div>

<!-- Category Filter untuk Admin -->
<div class="flex flex-wrap gap-3 mb-6">
    <a href="{{ route('admin.menu.index') }}"
       class="px-4 py-2 rounded-full transition-colors {{ !request('category') || request('category') == 'all' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
        Semua
    </a>
    <a href="{{ route('admin.menu.index', ['category' => 'makanan']) }}"
       class="px-4 py-2 rounded-full transition-colors {{ request('category') == 'makanan' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
        Makanan
    </a>
    <a href="{{ route('admin.menu.index', ['category' => 'minuman']) }}"
       class="px-4 py-2 rounded-full transition-colors {{ request('category') == 'minuman' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
        Minuman
    </a>
    <a href="{{ route('admin.menu.index', ['category' => 'kopi']) }}"
       class="px-4 py-2 rounded-full transition-colors {{ request('category') == 'kopi' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
        Kopi
    </a>
    <a href="{{ route('admin.menu.index', ['category' => 'dessert']) }}"
       class="px-4 py-2 rounded-full transition-colors {{ request('category') == 'dessert' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
        Dessert
    </a>
    <a href="{{ route('admin.menu.index', ['category' => 'snack']) }}"
       class="px-4 py-2 rounded-full transition-colors {{ request('category') == 'snack' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
        Snack
    </a>
</div>

<!-- Menu Grid dengan layout yang sesuai gambar -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($menus ?? [] as $menu)
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-all duration-300">
        <!-- Image Container -->
        <div class="relative">
            @if($menu->image)
            <img src="{{ asset('storage/' . $menu->image) }}"
                 alt="{{ $menu->name }}"
                 class="w-full h-48 object-cover">
            @else
            <div class="w-full h-48 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                <i class="fas fa-utensils text-4xl text-gray-400"></i>
            </div>
            @endif

            <!-- Status Badge -->
            
        </div>

        <!-- Content -->
        <div class="p-4">
            <!-- Menu Name -->
            <h3 class="font-bold text-lg text-gray-900 mb-2">{{ $menu->name }}</h3>

            <!-- Description -->
            <p class="text-gray-600 text-sm mb-3 line-clamp-2">
                {{ $menu->description ?? 'Deskripsi menu tidak tersedia' }}
            </p>

            <!-- Category -->
            <p class="text-sm text-gray-500 mb-3">
                Kategori: <span class="font-medium">{{ ucfirst($menu->category) }}</span>
            </p>

            <!-- Price -->
            <div class="flex items-center justify-between mb-4">
                <div>
                    <span class="text-xl font-bold text-gray-900">
                        Rp {{ number_format($menu->price, 0, ',', '.') }}
                    </span>
                    @if($menu->price > 20000)
                    <span class="text-sm text-gray-400 line-through ml-2">
                        Rp {{ number_format($menu->price * 1.15, 0, ',', '.') }}
                    </span>
                    @endif
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex space-x-2">
                <button onclick="openEditModal({{ $menu->id }})"
                        class="flex-1 bg-blue-50 hover:bg-blue-100 text-blue-700 font-medium py-2 px-3 rounded-lg text-sm transition-colors flex items-center justify-center space-x-1">
                    <i class="fas fa-edit text-xs"></i>
                    <span>Edit</span>
                </button>
                <button onclick="deleteMenu({{ $menu->id }})"
                        class="bg-red-50 hover:bg-red-100 text-red-700 font-medium py-2 px-3 rounded-lg text-sm transition-colors">
                    <i class="fas fa-trash text-xs"></i>
                </button>
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-full">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-utensils text-3xl text-gray-400"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-700 mb-3">Belum Ada Menu</h3>
            <p class="text-gray-500 mb-8 max-w-sm mx-auto">
                Mulai dengan menambahkan menu pertama untuk cafe Blue House Farm Anda
            </p>
            <button onclick="openAddModal()"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition-colors inline-flex items-center space-x-2">
                <i class="fas fa-plus"></i>
                <span>Tambah Menu Baru</span>
            </button>
        </div>
    </div>
    @endforelse
</div>

<!-- ADD/EDIT MODAL -->
<div id="menuModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full max-h-[90vh] overflow-y-auto">
        <form id="menuForm" action="{{ route('admin.menu.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="methodField" name="_method" value="POST">

            <!-- Modal Header -->
            <div class="px-6 py-4 border-b border-gray-100">
                <div class="flex justify-between items-center">
                    <h3 id="modalTitle" class="text-xl font-bold text-gray-900">Tambah Menu Baru</h3>
                    <button type="button" onclick="closeModal()"
                            class="text-gray-400 hover:text-gray-600 transition-colors">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>

            <!-- Modal Content -->
            <div class="p-6 space-y-5">
                <!-- Image Upload -->
                <div class="text-center">
                    <div id="imagePreview" class="hidden mb-4">
                        <img id="previewImg" class="w-32 h-32 object-cover rounded-xl mx-auto border-4 border-gray-100 shadow-sm">
                    </div>
                    <div id="uploadArea" class="border-2 border-dashed border-gray-200 rounded-xl p-8 hover:border-blue-300 transition-colors cursor-pointer"
                         onclick="document.getElementById('image').click()">
                        <i class="fas fa-camera text-4xl text-gray-300 mb-3"></i>
                        <p class="text-gray-500 font-medium mb-2">Klik untuk upload gambar</p>
                        <p class="text-gray-400 text-sm">PNG, JPG hingga 5MB</p>
                        <input type="file" id="image" name="image" accept="image/*" class="hidden">
                    </div>
                </div>

                <!-- Name -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Menu *</label>
                    <input type="text" id="name" name="name" required
                           placeholder="Contoh: Blue House Signature Coffee"
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors">
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi</label>
                    <textarea id="description" name="description" rows="3"
                              placeholder="Deskripsi singkat tentang menu..."
                              class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none transition-colors"></textarea>
                </div>

                <!-- Price -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Harga *</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500 font-medium">Rp</span>
                        <input type="number" id="price" name="price" min="0" step="1000" required
                               placeholder="35000"
                               class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors">
                    </div>
                </div>

                <!-- Category -->
                <div class="mb-4">
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                        Kategori *
                    </label>
                    <select id="category"
                            name="category"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Pilih Kategori</option>
                        <option value="makanan" {{ old('category') == 'makanan' ? 'selected' : '' }}>Makanan</option>
                        <option value="minuman" {{ old('category') == 'minuman' ? 'selected' : '' }}>Minuman</option>
                        <option value="kopi" {{ old('category') == 'kopi' ? 'selected' : '' }}>Kopi</option>
                        <option value="dessert" {{ old('category') == 'dessert' ? 'selected' : '' }}>Dessert</option>
                        <option value="snack" {{ old('category') == 'snack' ? 'selected' : '' }}>Snack</option>
                    </select>
                </div>

                <!-- Available Status -->
                <div class="bg-gray-50 rounded-xl p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="font-semibold text-gray-700">Status Ketersediaan</h4>
                            <p class="text-sm text-gray-500">Menu akan tampil untuk pelanggan</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="hidden" name="is_available" value="0">
                            <input type="checkbox" id="is_available" name="is_available" value="1" checked
                                   class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="px-6 py-4 border-t border-gray-100">
                <div class="flex space-x-3">
                    <button type="button" onclick="closeModal()"
                            class="flex-1 px-6 py-3 border border-gray-200 text-gray-700 rounded-xl hover:bg-gray-50 font-medium transition-colors">
                        Batal
                    </button>
                    <button type="submit"
                            class="flex-1 px-6 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 font-medium transition-colors">
                        <span id="submitText">Simpan Menu</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- DELETE MODAL -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-sm w-full">
        <div class="p-6 text-center">
            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-trash text-2xl text-red-600"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">Hapus Menu</h3>
            <p class="text-gray-600 mb-6">
                Apakah Anda yakin ingin menghapus menu ini? Tindakan ini tidak dapat dibatalkan.
            </p>

            <div class="flex space-x-3">
                <button onclick="closeDeleteModal()"
                        class="flex-1 px-4 py-2 border border-gray-200 text-gray-700 rounded-xl hover:bg-gray-50 font-medium transition-colors">
                    Batal
                </button>
                <form id="deleteForm" method="POST" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="w-full px-4 py-2 bg-red-600 text-white rounded-xl hover:bg-red-700 font-medium transition-colors">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
let isEditMode = false;
let currentMenuId = null;

function openAddModal() {
    isEditMode = false;
    document.getElementById('modalTitle').textContent = 'Tambah Menu Baru';
    document.getElementById('submitText').textContent = 'Simpan Menu';
    document.getElementById('menuForm').action = '{{ route("admin.menu.store") }}';
    document.getElementById('methodField').value = 'POST';
    document.getElementById('menuForm').reset();
    document.getElementById('is_available').checked = true;
    document.getElementById('imagePreview').classList.add('hidden');
    document.getElementById('uploadArea').classList.remove('hidden');
    document.getElementById('menuModal').classList.remove('hidden');
}

async function openEditModal(menuId) {
    isEditMode = true;
    currentMenuId = menuId;
    document.getElementById('modalTitle').textContent = 'Edit Menu';
    document.getElementById('submitText').textContent = 'Update Menu';
    document.getElementById('menuForm').action = `/admin/menu/${menuId}`;
    document.getElementById('methodField').value = 'PUT';

    try {
        // Gunakan route admin API yang benar
        const response = await fetch(`{{ route('admin.menu.show', ':id') }}`.replace(':id', menuId));
        const menu = await response.json();

        document.getElementById('name').value = menu.name || '';
        document.getElementById('description').value = menu.description || '';
        document.getElementById('price').value = menu.price || '';
        document.getElementById('category').value = menu.category || '';
        document.getElementById('is_available').checked = menu.is_available || false;

        if (menu.image) {
            document.getElementById('previewImg').src = `/storage/${menu.image}`;
            document.getElementById('imagePreview').classList.remove('hidden');
            document.getElementById('uploadArea').classList.add('hidden');
        } else {
            document.getElementById('imagePreview').classList.add('hidden');
            document.getElementById('uploadArea').classList.remove('hidden');
        }

        document.getElementById('menuModal').classList.remove('hidden');
    } catch (error) {
        console.error('Error:', error);
        alert('Gagal memuat data menu');
    }
}

function closeModal() {
    document.getElementById('menuModal').classList.add('hidden');
}

function deleteMenu(menuId) {
    document.getElementById('deleteForm').action = `/admin/menu/${menuId}`;
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}

// Image Preview
document.getElementById('image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('previewImg').src = e.target.result;
            document.getElementById('imagePreview').classList.remove('hidden');
            document.getElementById('uploadArea').classList.add('hidden');
        };
        reader.readAsDataURL(file);
    }
});

// Close modal when clicking outside
document.getElementById('menuModal').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});

document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) closeDeleteModal();
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeModal();
        closeDeleteModal();
    }
});
</script>

@endsection
