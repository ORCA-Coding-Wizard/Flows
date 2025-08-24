<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Kelola Admin') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- tombol create -->
            <button onclick="openModal('createModal')" class="bg-blue-600 text-white px-4 py-2 rounded-lg mb-4">
                + Tambah Admin
            </button>

            <!-- table list -->
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <table class="w-full border">
                    <thead>
                        <tr class="bg-gray-200 dark:bg-gray-700">
                            <th class="p-2 border">No</th>
                            <th class="p-2 border">Nama</th>
                            <th class="p-2 border">Email</th>
                            <th class="p-2 border">Role</th>
                            <th class="p-2 border">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($admins as $admin)
                            <tr>
                                <td class="p-2 border">{{ $loop->iteration }}</td>
                                <td class="p-2 border">{{ $admin->name }}</td>
                                <td class="p-2 border">{{ $admin->email }}</td>
                                <td class="p-2 border">{{ $admin->role }}</td>
                                <td class="p-2 border">
                                    <!-- tombol delete -->
                                    <button onclick="openDeleteModal('{{ $admin->id }}', '{{ $admin->name }}')"
                                        class="bg-red-600 text-white px-2 py-1 rounded">Hapus</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Modal Konfirmasi Delete -->
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
                    <h3 class="text-xl font-bold mb-4">Tambah Admin</h3>

                    <form action="{{ route('admin.kelola-admin.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="form_type" value="create">

                        <div class="mb-2">
                            <label class="block text-gray-700">Nama</label>
                            <input type="text" name="name" placeholder="Nama" class="w-full border rounded p-2"
                                value="{{ old('name') }}" required>
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-2">
                            <label class="block text-gray-700">Email</label>
                            <input type="email" name="email" placeholder="Email" class="w-full border rounded p-2"
                                value="{{ old('email') }}" required>
                            @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-2">
                            <label class="block text-gray-700">Password</label>
                            <input type="password" name="password" class="w-full border rounded p-2"
                                autocomplete="new-password" required>
                            @error('password')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-2">
                            <label class="block text-gray-700">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="w-full border rounded p-2"
                                required>
                        </div>

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

    <!-- SCRIPT MODAL -->
    <script>
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
        }

        function closeModal(id) {
            const modal = document.getElementById(id);
            modal.classList.add('hidden');

            const form = modal.querySelector('form');
            if (!form) return;

            if (id === 'createModal') {
                form.reset();
                const inputs = form.querySelectorAll('input');
                inputs.forEach(input => {
                    if (input.type !== 'hidden' && input.type !== 'submit') {
                        input.value = '';
                    }
                });
            }

            const errors = modal.querySelectorAll('.text-red-500');
            errors.forEach(err => err.textContent = '');
        }

        function openDeleteModal(id, name) {
            const deleteModal = document.getElementById('deleteModal');
            const deleteForm = document.getElementById('deleteForm');
            const deleteMessage = document.getElementById('deleteMessage');

            deleteForm.action = `/admin/kelola-admin/${id}`;
            deleteMessage.textContent = `Apakah Anda yakin ingin menghapus admin "${name}"?`;

            deleteModal.classList.remove('hidden');
        }

        @if ($errors->any())
            @if (old('form_type') === 'create')
                openModal('createModal');
            @endif
        @endif
    </script>
</x-app-layout>
