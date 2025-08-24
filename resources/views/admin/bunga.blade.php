<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Kelola Bunga') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Alert sukses --}}
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Filter + Tambah --}}
            <div class="flex items-center justify-between mb-6">
                <form method="GET" action="{{ route('admin.bunga.index') }}" class="flex gap-2">
                    <select name="category_id" onchange="this.form.submit()" class="px-3 py-2 border rounded">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                    <input type="text" name="q" placeholder="Cari bunga..." value="{{ request('q') }}"
                           class="px-3 py-2 border rounded">
                </form>

                <button onclick="openCreateModal()" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    + Tambah Bunga
                </button>
            </div>

            {{-- Daftar bunga --}}
            @if($bungas->count())
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach($bungas as $bunga)
                        <div class="relative bg-white dark:bg-gray-800 rounded-xl shadow hover:shadow-lg transition">
                            <img src="{{ $bunga->image }}" alt="{{ $bunga->name }}" class="w-full h-40 object-cover rounded-t-xl">
                            <div class="p-4 mb-12">
                                <h3 class="text-lg font-semibold">{{ $bunga->name }}</h3>
                                <p class="text-sm mb-1">Rp {{ number_format($bunga->price,0,',','.') }}</p>
                                <span class="px-2 py-1 text-xs rounded-full bg-gray-100 dark:bg-gray-700">{{ $bunga->category->name ?? '-' }}</span>
                            </div>

                            {{-- Aksi --}}
                            <div class="absolute bottom-0 left-0 right-0 flex justify-between items-center px-4 py-3 bg-white/80 dark:bg-gray-800/80 backdrop-blur rounded-b-xl">
                                <button onclick="openEditModal({{ $bunga->id }}, '{{ $bunga->name }}', '{{ $bunga->price }}', '{{ $bunga->category_id }}')"
                                        class="px-3 py-1 text-sm rounded bg-yellow-500 text-white hover:bg-yellow-600">Edit</button>
                                <form action="{{ route('admin.bunga.destroy', $bunga) }}" method="POST" onsubmit="return confirm('Yakin hapus bunga ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1 text-sm rounded bg-red-600 text-white hover:bg-red-700">Hapus</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-center text-gray-500">Belum ada data bunga.</p>
            @endif
        </div>
    </div>

    {{-- Modal Create --}}
    <div id="createModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-xl max-w-md w-full">
            <h2 class="text-lg font-semibold mb-4">Tambah Bunga</h2>
            <form method="POST" action="{{ route('admin.bunga.store') }}" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label>Nama</label>
                    <input type="text" name="name" class="w-full border rounded px-3 py-2">
                </div>
                <div>
                    <label>Harga</label>
                    <input type="number" name="price" class="w-full border rounded px-3 py-2">
                </div>
                <div>
                    <label>Kategori</label>
                    <select name="category_id" class="w-full border rounded px-3 py-2">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label>Gambar</label>
                    <input type="file" name="image" class="w-full border rounded px-3 py-2">
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeCreateModal()" class="px-4 py-2 bg-gray-300 rounded">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Edit --}}
    <div id="editModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-xl max-w-md w-full">
            <h2 class="text-lg font-semibold mb-4">Edit Bunga</h2>
            <form id="editForm" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label>Nama</label>
                    <input type="text" id="editName" name="name" class="w-full border rounded px-3 py-2">
                </div>
                <div>
                    <label>Harga</label>
                    <input type="number" id="editPrice" name="price" class="w-full border rounded px-3 py-2">
                </div>
                <div>
                    <label>Kategori</label>
                    <select id="editCategory" name="category_id" class="w-full border rounded px-3 py-2">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label>Ganti Gambar (opsional)</label>
                    <input type="file" name="image" class="w-full border rounded px-3 py-2">
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-gray-300 rounded">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-yellow-600 text-white rounded">Update</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openCreateModal() {
            document.getElementById('createModal').classList.remove('hidden');
        }
        function closeCreateModal() {
            document.getElementById('createModal').classList.add('hidden');
        }

        function openEditModal(id, name, price, category_id) {
            const form = document.getElementById('editForm');
            form.action = `/admin/bunga/${id}`;
            document.getElementById('editName').value = name;
            document.getElementById('editPrice').value = price;
            document.getElementById('editCategory').value = category_id;
            document.getElementById('editModal').classList.remove('hidden');
        }
        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }
    </script>
</x-app-layout>
