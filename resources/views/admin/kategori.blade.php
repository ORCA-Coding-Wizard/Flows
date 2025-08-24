<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Kelola Kategori') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Tombol Tambah Kategori -->
            <button onclick="openModal('createModal')" class="bg-blue-600 text-white px-4 py-2 rounded-lg mb-4">
                + Tambah Kategori
            </button>

            <!-- Table Kategori -->
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <table class="w-full border">
                    <thead>
                        <tr class="bg-gray-200 dark:bg-gray-700">
                            <th class="p-2 border">No</th>
                            <th class="p-2 border">Nama Kategori</th>
                            <th class="p-2 border">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                        <tr>
                            <td class="p-2 border">{{ $loop->iteration }}</td>
                            <td class="p-2 border">{{ $category->name }}</td>
                            <td class="p-2 border space-x-2">
                                <button onclick="openModal('editModal-{{ $category->id }}')"
                                    class="bg-yellow-500 text-white px-2 py-1 rounded">Edit</button>
                                <button onclick="openDeleteModal('{{ $category->id }}', '{{ $category->name }}')"
                                    class="bg-red-600 text-white px-2 py-1 rounded">Hapus</button>
                            </td>
                        </tr>

                        <!-- Modal Edit -->
                        <div id="editModal-{{ $category->id }}"
                            class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center">
                            <div class="bg-white p-6 rounded-lg w-1/3">
                                <h3 class="text-xl font-bold mb-4">Edit Kategori</h3>
                                <form action="{{ route('admin.kategori.update', $category->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="text" name="name" value="{{ old('name', $category->name) }}"
                                        class="w-full border rounded p-2 mb-2" required>
                                    @error('name')
                                        <p class="text-red-600 mb-2">{{ $message }}</p>
                                    @enderror
                                    <div class="flex justify-end space-x-2">
                                        <button type="button" onclick="closeModal('editModal-{{ $category->id }}')"
                                            class="bg-gray-500 text-white px-4 py-2 rounded">Batal</button>
                                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Modal Delete -->
            <div id="deleteModal"
                class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center">
                <div class="bg-white p-6 rounded-lg w-1/3">
                    <h3 class="text-xl font-bold mb-4 text-red-600">Konfirmasi Hapus</h3>
                    <p id="deleteMessage" class="mb-4 text-gray-700"></p>
                    <form id="deleteForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="flex justify-end space-x-2">
                            <button type="button" onclick="closeModal('deleteModal')"
                                class="bg-gray-500 text-white px-4 py-2 rounded">Batal</button>
                            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded">Hapus</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Modal Create -->
            <div id="createModal"
                class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center">
                <div class="bg-white p-6 rounded-lg w-1/3">
                    <h3 class="text-xl font-bold mb-4">Tambah Kategori</h3>
                    <form action="{{ route('admin.kategori.store') }}" method="POST">
                        @csrf
                        <input type="text" name="name" placeholder="Nama Kategori" value="{{ old('name') }}"
                            class="w-full border rounded p-2 mb-2" required>
                        @error('name')
                            <p class="text-red-600 mb-2">{{ $message }}</p>
                        @enderror
                        <div class="flex justify-end space-x-2">
                            <button type="button" onclick="closeModal('createModal')"
                                class="bg-gray-500 text-white px-4 py-2 rounded">Batal</button>
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <!-- Script Modal -->
    <script>
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
        }

        function closeModal(id) {
            const modal = document.getElementById(id);
            modal.classList.add('hidden');

            // cek modal dibuka karena error validasi atau bukan
            const isErrorModal = modal.getAttribute('data-error') === 'true';

            // kalau modal bukan karena error -> reset form & error
            if (!isErrorModal) {
                const form = modal.querySelector('form');
                if (form) {
                    form.reset();

                    const errors = modal.querySelectorAll('.text-red-600');
                    errors.forEach(e => e.textContent = '');
                }
            }

            // bersihin flag error biar gak keikut buka selanjutnya
            modal.removeAttribute('data-error');
        }

        function openDeleteModal(id, name) {
            const deleteModal = document.getElementById('deleteModal');
            const deleteForm = document.getElementById('deleteForm');
            const deleteMessage = document.getElementById('deleteMessage');

            deleteForm.action = `/admin/kategori/${id}`;
            deleteMessage.textContent = `Apakah Anda yakin ingin menghapus kategori "${name}"?`;

            deleteModal.classList.remove('hidden');
        }

        document.addEventListener('DOMContentLoaded', function () {
            const openModalName = @json(session('openModal'));
            const editCategoryId = @json(session('editCategoryId'));

            if (openModalName === 'create') {
                const modal = document.getElementById('createModal');
                modal.setAttribute('data-error', 'true');
                openModal('createModal');
            } else if (openModalName === 'edit' && editCategoryId) {
                const modal = document.getElementById(`editModal-${editCategoryId}`);
                modal.setAttribute('data-error', 'true');
                openModal(`editModal-${editCategoryId}`);
            }
        });
    </script>
</x-app-layout>
