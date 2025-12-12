<?php $__env->startSection('title', 'Manajemen Menu'); ?>

<?php $__env->startSection('content'); ?>
<!-- Header -->
<div class="mb-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Manajemen Menu</h1>
            <p class="text-gray-600">Kelola item menu cafe</p>
        </div>
        <button onclick="showAddModal()" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2">
            <i class="fa-solid fa-plus"></i>
            <span>Tambah Menu</span>
        </button>
    </div>
</div>

<!-- Filter and Search -->
<div class="bg-white rounded-xl shadow-sm p-4 mb-6">
    <form method="GET" class="flex gap-4">
        <!-- Search -->
        <div class="flex-1">
            <input type="text"
                   name="search"
                   value="<?php echo e($search); ?>"
                   placeholder="Cari menu..."
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        </div>

        <!-- Category Filter -->
        <div class="w-48">
            <select name="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="all">Semua Kategori</option>
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($cat->id); ?>" <?php echo e($category == $cat->id ? 'selected' : ''); ?>>
                        <?php echo e($cat->name); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <!-- Filter Button -->
        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">
            <i class="fa-solid fa-filter mr-2"></i>Filter
        </button>
    </form>
</div>

<!-- Menu Grid -->
<?php if($menus->count() > 0): ?>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
    <?php $__currentLoopData = $menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-lg transition-all duration-300 overflow-hidden">
        <!-- Menu Image -->
        <div class="relative h-48 bg-gray-100 overflow-hidden">
            <?php if($menu->image): ?>
                <img src="<?php echo e(asset($menu->image)); ?>"
                     alt="<?php echo e($menu->name); ?>"
                     class="w-full h-full object-cover">
            <?php else: ?>
                <div class="w-full h-full flex items-center justify-center bg-gray-100">
                    <i class="fa-solid fa-image text-4xl text-gray-400"></i>
                </div>
            <?php endif; ?>

            <!-- Status Badge -->
            <div class="absolute top-3 left-3">
                <?php if($menu->is_available): ?>
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-500 text-white">
                        Tersedia
                    </span>
                <?php else: ?>
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-500 text-white">
                        Habis
                    </span>
                <?php endif; ?>
            </div>

            <!-- Category Badge -->
            <div class="absolute top-3 right-3">
                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-500 text-white">
                    <?php echo e($menu->category->name ?? 'Tanpa Kategori'); ?>

                </span>
            </div>
        </div>

        <!-- Menu Content -->
        <div class="p-4">
            <!-- Menu Name -->
            <h3 class="font-bold text-gray-900 text-lg mb-1"><?php echo e($menu->name); ?></h3>

            <!-- Description -->
            <p class="text-sm text-gray-600 mb-3 line-clamp-2">
                <?php echo e($menu->description ?: 'Tidak ada deskripsi tersedia untuk item menu ini.'); ?>

            </p>

            <!-- Category -->
            <p class="text-xs text-gray-500 mb-2">
                Kategori: <?php echo e($menu->category->name ?? 'Tanpa Kategori'); ?>

            </p>

            <!-- Price -->
            <div class="mb-4">
                <span class="text-xl font-bold text-gray-900">Rp <?php echo e(number_format($menu->price, 0, ',', '.')); ?></span>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-2">
                <!-- Edit Button -->
                <button onclick="showEditModal(<?php echo e($menu->id); ?>)"
                        class="flex-1 bg-blue-50 text-blue-600 py-2 px-3 rounded-lg hover:bg-blue-100 transition-colors flex items-center justify-center">
                    <i class="fa-solid fa-edit mr-1"></i>
                    <span class="text-sm font-medium">Edit</span>
                </button>

                <!-- Delete Button -->
                <button onclick="deleteMenu(<?php echo e($menu->id); ?>)"
                        class="w-10 h-10 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-colors flex items-center justify-center">
                    <i class="fa-solid fa-trash text-sm"></i>
                </button>
            </div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<!-- Pagination -->
<div class="mt-8">
    <?php echo e($menus->withQueryString()->links()); ?>

</div>

<?php else: ?>
<!-- Empty State -->
<div class="bg-white rounded-xl shadow-sm p-12 text-center">
    <i class="fa-solid fa-utensils text-4xl text-gray-300 mb-4"></i>
    <h3 class="text-lg font-semibold text-gray-900 mb-2">
        <?php if($search || ($category && $category !== 'all')): ?>
            Tidak ada menu yang sesuai
        <?php else: ?>
            Belum ada menu
        <?php endif; ?>
    </h3>
    <p class="text-gray-500 mb-6">
        <?php if($search || ($category && $category !== 'all')): ?>
            Coba ubah kata kunci atau filter yang digunakan.
        <?php else: ?>
            Tambahkan menu pertama Anda untuk mulai mengelola menu.
        <?php endif; ?>
    </p>
    <?php if(!$search && (!$category || $category === 'all')): ?>
        <button onclick="showAddModal()" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">
            <i class="fa-solid fa-plus mr-2"></i>Tambah Menu Pertama
        </button>
    <?php endif; ?>
</div>
<?php endif; ?>

<!-- Add/Edit Modal -->
<div id="menuModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-xl shadow-xl max-w-lg w-full mx-4 max-h-screen overflow-y-auto">
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 id="modalTitle" class="text-xl font-semibold text-gray-900">Tambah Menu</h3>
                <button onclick="hideModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fa-solid fa-times text-xl"></i>
                </button>
            </div>

            <form id="menuForm" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <input type="hidden" id="menuId" name="menu_id">
                <input type="hidden" id="formMethod" name="_method" value="">

                <!-- Image Upload -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-3">Gambar Menu</label>
                    <div class="relative">
                        <input type="file" id="imageInput" name="image" accept="image/*" class="hidden" onchange="previewImage(event)">
                        <div id="imagePreview" class="w-full h-40 bg-gray-100 border-2 border-dashed border-gray-300 rounded-lg flex items-center justify-center cursor-pointer hover:bg-gray-50 transition-colors" onclick="document.getElementById('imageInput').click()">
                            <div id="imagePlaceholder" class="text-center">
                                <i class="fa-solid fa-camera text-3xl text-gray-400 mb-2"></i>
                                <p class="text-sm text-gray-500">Klik untuk upload gambar</p>
                                <p class="text-xs text-gray-400 mt-1">JPG, PNG, max 2MB</p>
                            </div>
                            <img id="previewImg" class="w-full h-full object-cover rounded-lg hidden" alt="Preview">
                        </div>
                    </div>
                </div>

                <!-- Name -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Menu *</label>
                    <input type="text" id="menuName" name="name" required
                           placeholder="Contoh: Blue House Signature Coffee"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Category -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kategori *</label>
                    <select id="menuCategory" name="category_id" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Pilih Kategori</option>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($cat->id); ?>"><?php echo e($cat->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <!-- Price -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Harga *</label>
                    <div class="relative">
                        <span class="absolute left-4 top-3 text-gray-500">Rp</span>
                        <input type="number" id="menuPrice" name="price" required min="0" step="1000"
                               placeholder="35000"
                               class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                    <textarea id="menuDescription" name="description" rows="4"
                              placeholder="Deskripsi detail tentang menu ini..."
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none"></textarea>
                </div>

                <!-- Availability -->
                <div class="mb-6">
                    <label class="flex items-center">
                        <input type="checkbox" id="menuAvailable" name="is_available" value="1" checked
                               class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <span class="ml-3 text-sm font-medium text-gray-700">Menu tersedia untuk dijual</span>
                    </label>
                </div>

                <!-- Buttons -->
                <div class="flex gap-3">
                    <button type="button" onclick="hideModal()"
                            class="flex-1 px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium">
                        Batal
                    </button>
                    <button type="submit"
                            class="flex-1 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                        <span id="submitText">Simpan Menu</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Loading Overlay -->
<div id="loadingOverlay" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg p-6 text-center min-w-[200px]">
        <i class="fa-solid fa-spinner fa-spin text-2xl text-blue-600 mb-3"></i>
        <p class="text-gray-700 font-medium">Memproses...</p>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
let isEdit = false;

function showAddModal() {
    isEdit = false;
    document.getElementById('modalTitle').textContent = 'Tambah Menu';
    document.getElementById('submitText').textContent = 'Simpan Menu';
    document.getElementById('formMethod').value = '';
    document.getElementById('menuForm').reset();
    document.getElementById('menuAvailable').checked = true;
    resetImagePreview();
    document.getElementById('menuModal').classList.remove('hidden');
}

function showEditModal(menuId) {
    isEdit = true;
    document.getElementById('modalTitle').textContent = 'Edit Menu';
    document.getElementById('submitText').textContent = 'Update Menu';
    document.getElementById('formMethod').value = 'PUT';

    showLoading();

    fetch(`/admin/menu/${menuId}/edit`)
        .then(response => response.json())
        .then(data => {
            hideLoading();
            document.getElementById('menuId').value = data.id;
            document.getElementById('menuName').value = data.name;
            document.getElementById('menuCategory').value = data.category_id;
            document.getElementById('menuPrice').value = data.price;
            document.getElementById('menuDescription').value = data.description || '';
            document.getElementById('menuAvailable').checked = data.is_available;

            if (data.image) {
                showImagePreview(data.image_url);
            } else {
                resetImagePreview();
            }

            document.getElementById('menuModal').classList.remove('hidden');
        })
        .catch(error => {
            hideLoading();
            console.error('Error:', error);
            alert('Terjadi kesalahan saat mengambil data menu');
        });
}

function hideModal() {
    document.getElementById('menuModal').classList.add('hidden');
    document.getElementById('menuForm').reset();
    resetImagePreview();
}

function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
        // Validate file size (max 2MB)
        if (file.size > 2 * 1024 * 1024) {
            alert('Ukuran file terlalu besar. Maksimal 2MB.');
            event.target.value = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            showImagePreview(e.target.result);
        };
        reader.readAsDataURL(file);
    }
}

function showImagePreview(src) {
    document.getElementById('imagePlaceholder').classList.add('hidden');
    const img = document.getElementById('previewImg');
    img.src = src;
    img.classList.remove('hidden');
}

function resetImagePreview() {
    document.getElementById('imagePlaceholder').classList.remove('hidden');
    document.getElementById('previewImg').classList.add('hidden');
}

function deleteMenu(menuId) {
    if (!confirm('Apakah Anda yakin ingin menghapus menu ini? Tindakan ini tidak dapat dibatalkan.')) {
        return;
    }

    showLoading();

    fetch(`/admin/menu/${menuId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        hideLoading();
        if (data.success) {
            // Show success message
            showSuccessToast('Menu berhasil dihapus');
            // Reload after short delay
            setTimeout(() => {
                location.reload();
            }, 1000);
        } else {
            alert('Terjadi kesalahan: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        hideLoading();
        console.error('Error:', error);
        alert('Terjadi kesalahan saat menghapus menu');
    });
}

function showSuccessToast(message) {
    // Create toast element
    const toast = document.createElement('div');
    toast.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 transform translate-x-full transition-transform duration-300';
    toast.innerHTML = `
        <div class="flex items-center">
            <i class="fa-solid fa-check-circle mr-2"></i>
            <span>${message}</span>
        </div>
    `;

    document.body.appendChild(toast);

    // Show toast
    setTimeout(() => {
        toast.classList.remove('translate-x-full');
    }, 100);

    // Hide toast after 3 seconds
    setTimeout(() => {
        toast.classList.add('translate-x-full');
        setTimeout(() => {
            document.body.removeChild(toast);
        }, 300);
    }, 3000);
}

function showLoading() {
    document.getElementById('loadingOverlay').classList.remove('hidden');
}

function hideLoading() {
    document.getElementById('loadingOverlay').classList.add('hidden');
}

// Handle form submission
document.getElementById('menuForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const menuId = document.getElementById('menuId').value;

    let url, method;
    if (isEdit) {
        url = `/admin/menu/${menuId}`;
        method = 'POST';
        formData.append('_method', 'PUT');
    } else {
        url = '/admin/menu';
        method = 'POST';
    }

    showLoading();

    fetch(url, {
        method: method,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        hideLoading();
        if (data.success) {
            hideModal();
            showSuccessToast(isEdit ? 'Menu berhasil diupdate' : 'Menu berhasil ditambahkan');
            setTimeout(() => {
                location.reload();
            }, 1000);
        } else {
            alert('Terjadi kesalahan: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        hideLoading();
        console.error('Error:', error);
        alert('Terjadi kesalahan saat menyimpan menu');
    });
});

// Close modal when clicking outside
document.getElementById('menuModal').addEventListener('click', function(e) {
    if (e.target === this) {
        hideModal();
    }
});

// Format price input
document.getElementById('menuPrice').addEventListener('input', function(e) {
    let value = e.target.value.replace(/[^\d]/g, '');
    e.target.value = value;
});
</script>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.transition-all {
    transition-property: all;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 150ms;
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.Admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Muhammad Kahfi\Downloads\Joki Doy\joyko\jokidoy\resources\views/admin/menu.blade.php ENDPATH**/ ?>