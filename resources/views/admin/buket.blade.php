<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Kelola Buket') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Search + Tambah --}}
            <div class="flex items-center justify-between mb-6">
                <form method="GET" action="{{ route('admin.buket.index') }}" class="flex gap-2 w-full">
                    <input type="text" name="q" placeholder="Cari bouquet..." value="{{ request('q') }}"
                           class="w-full px-3 py-2 border rounded">
                </form>

                <button onclick="openCreateModal()" class="ml-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    + Tambah Bouquet
                </button>
            </div>

            {{-- List bouquet --}}
            @if($bouquets->count())
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach($bouquets as $bouquet)
                        <div class="relative bg-white dark:bg-gray-800 rounded-xl shadow hover:shadow-lg transition">
                            <img src="{{ $bouquet->image }}" alt="{{ $bouquet->name }}" class="w-full h-40 object-cover rounded-t-xl">
                            <div class="p-4 mb-12">
                                <h3 class="text-lg font-semibold">{{ $bouquet->name }}</h3>
                                <p class="text-sm mb-1">Rp {{ number_format($bouquet->price, 0, ',', '.') }}</p>
                                <span class="px-2 py-1 text-xs rounded-full bg-gray-100 dark:bg-gray-700">
                                    Kapasitas: {{ $bouquet->capacity }}
                                </span>
                            </div>

                            <div class="absolute bottom-0 left-0 right-0 flex justify-between items-center px-4 py-3 bg-white/80 dark:bg-gray-800/80 backdrop-blur rounded-b-xl">
                                <button onclick="openEditModal({{ $bouquet->id }}, '{{ $bouquet->name }}', '{{ $bouquet->price }}', '{{ $bouquet->capacity }}')"
                                        class="px-3 py-1 text-sm rounded bg-yellow-500 text-white hover:bg-yellow-600">
                                    Edit
                                </button>
                                <form action="{{ route('admin.buket.destroy', $bouquet) }}" method="POST" onsubmit="return confirm('Yakin hapus bouquet ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1 text-sm rounded bg-red-600 text-white hover:bg-red-700">Hapus</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-center text-gray-500">Belum ada data bouquet.</p>
            @endif
        </div>
    </div>

    {{-- Modal Create --}}
    <div id="createModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-xl max-w-md w-full">
            <h2 class="text-lg font-semibold mb-4">Tambah Bouquet</h2>
            <form method="POST" action="{{ route('admin.buket.store') }}" enctype="multipart/form-data" class="space-y-4">
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
                    <label>Kapasitas</label>
                    <input type="number" name="capacity" class="w-full border rounded px-3 py-2">
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
            <h2 class="text-lg font-semibold mb-4">Edit Bouquet</h2>
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
                    <label>Kapasitas</label>
                    <input type="number" id="editCapacity" name="capacity" class="w-full border rounded px-3 py-2">
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

        function openEditModal(id, name, price, capacity) {
            const form = document.getElementById('editForm');
            form.action = `/admin/buket/${id}`;
            document.getElementById('editName').value = name;
            document.getElementById('editPrice').value = price;
            document.getElementById('editCapacity').value = capacity;
            document.getElementById('editModal').classList.remove('hidden');
        }
        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }
    </script>
</x-app-layout>
