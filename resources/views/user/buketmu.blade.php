<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Buketmu') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="bouquetPackage(@js($bouquets), @js($flowers), @js($packages))">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Tombol Tambah --}}
            <div class="mb-6 flex justify-end">
                <button @click="openCreate()"
                    class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 transition">
                    Tambah Bouquet
                </button>
            </div>

            {{-- Daftar Bouquet Package --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <template x-for="pkg in packages" :key="pkg.id">
                    <div class="bg-white dark:bg-gray-800 shadow rounded p-4 flex flex-col gap-2">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="font-semibold text-lg" x-text="pkg.name"></p>
                                <p class="text-sm">Bouquet: <span x-text="pkg.bouquet.name"></span></p>
                                <p class="text-sm">Harga: Rp. <span
                                        x-text="new Intl.NumberFormat('id-ID').format(pkg.price)"></span></p>
                                <p class="text-sm">Jumlah Bunga: <span x-text="pkg.flowers.length"></span></p>
                            </div>
                            <div class="flex gap-2">
                                <button @click="openEdit(pkg)"
                                    class="px-2 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 transition">Edit</button>
                                <button @click="confirmDelete(pkg.id)"
                                    class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition">Hapus</button>
                                <button @click="buyNow(pkg.id)"
                                    class="px-2 py-1 bg-green-500 text-white rounded hover:bg-green-600 transition">Beli
                                    Sekarang</button>
                            </div>
                        </div>
                        <div class="mt-2 grid grid-cols-2 gap-2">
                            <img :src="pkg.bouquet.image" class="h-24 w-full object-cover rounded" alt="Bouquet">
                            <template x-for="flower in pkg.flowers" :key="flower.id">
                                <img :src="flower.image" class="h-24 w-full object-cover rounded"
                                    :alt="flower.name">
                            </template>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        {{-- Modal --}}
        <div x-show="showModal" x-transition class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-full max-w-lg">
                <h3 class="text-lg font-semibold mb-4" x-text="modalTitle"></h3>
                <form @submit.prevent="submitForm" class="flex flex-col gap-4">

                    <div>
                        <label class="block mb-1">Nama Bouquet</label>
                        <input type="text" x-model="form.name" class="w-full border rounded px-3 py-2">
                    </div>

                    <div>
                        <label class="block mb-1">Pilih Bouquet</label>
                        <select x-model="form.bouquet_id" @change="updateCapacity()"
                            class="w-full border rounded px-3 py-2">
                            <option value="">-- Pilih Bouquet --</option>
                            <template x-for="b in bouquets" :key="b.id">
                                <option :value="b.id" x-text="b.name + ' (Max ' + b.capacity + ')'"></option>
                            </template>
                        </select>

                        <div class="mt-2" x-show="selectedBouquet">
                            <img :src="selectedBouquet.image" class="h-32 w-full object-cover rounded" alt="Bouquet">
                        </div>
                    </div>

                    <div>
                        <label class="block mb-1">Pilih Bunga</label>
                        <div class="grid grid-cols-3 gap-2 max-h-64 overflow-y-auto border rounded p-2">
                            <template x-for="flower in flowers" :key="flower.id">
                                <label
                                    class="flex flex-col items-center cursor-pointer border rounded p-1 hover:bg-gray-100">
                                    <img :src="flower.image" class="h-16 w-16 object-cover rounded"
                                        :alt="flower.name">
                                    <span class="text-sm mt-1"
                                        x-text="flower.name + ' (Rp. ' + flower.price + ')'"></span>
                                    <input type="checkbox" :value="flower.id" x-model="form.flowers"
                                        class="mt-1">
                                </label>
                            </template>
                        </div>
                        <p class="text-sm text-gray-500 mt-2">Jumlah bunga max: <span x-text="maxCapacity"></span></p>
                    </div>

                    <div class="flex justify-end gap-2">
                        <button type="button" @click="closeModal()"
                            class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 transition">Batal</button>
                        <button type="submit"
                            class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 transition"
                            x-text="modalButton"></button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Form tersembunyi untuk POST buyNow --}}
        <form id="buyForm" method="POST" style="display:none;">
            @csrf
        </form>

    </div>

    <script>
        function bouquetPackage(bouquets, flowers, packages) {
            return {
                showModal: false,
                modalTitle: '',
                modalButton: '',
                maxCapacity: 0,
                selectedBouquet: null,
                form: {
                    id: null,
                    name: '',
                    bouquet_id: '',
                    flowers: []
                },
                bouquets,
                flowers,
                packages,

                openCreate() {
                    this.modalTitle = 'Tambah Bouquet Package';
                    this.modalButton = 'Simpan';
                    this.form = {
                        id: null,
                        name: '',
                        bouquet_id: '',
                        flowers: []
                    };
                    this.maxCapacity = 0;
                    this.selectedBouquet = null;
                    this.showModal = true;
                },

                openEdit(pkg) {
                    this.modalTitle = 'Edit Bouquet Package';
                    this.modalButton = 'Update';
                    this.form = {
                        id: pkg.id,
                        name: pkg.name,
                        bouquet_id: pkg.bouquet_id,
                        flowers: pkg.flowers.map(f => f.id)
                    };
                    this.selectedBouquet = this.bouquets.find(b => b.id == pkg.bouquet_id);
                    this.maxCapacity = this.selectedBouquet.capacity;
                    this.showModal = true;
                },

                closeModal() {
                    this.showModal = false;
                },

                updateCapacity() {
                    this.selectedBouquet = this.bouquets.find(b => b.id == this.form.bouquet_id);
                    this.maxCapacity = this.selectedBouquet ? this.selectedBouquet.capacity : 0;
                    if (this.form.flowers.length > this.maxCapacity) this.form.flowers = this.form.flowers.slice(0, this
                        .maxCapacity);
                },

                submitForm() {
                    if (!this.form.name || !this.form.bouquet_id || this.form.flowers.length == 0) {
                        alert('Semua field harus diisi!');
                        return;
                    }

                    if (this.form.flowers.length > this.maxCapacity) {
                        alert('Jumlah bunga melebihi kapasitas bouquet!');
                        return;
                    }

                    let url = this.form.id ? `/user/bouquets/${this.form.id}` : `/user/bouquets`;
                    let method = this.form.id ? 'PUT' : 'POST';

                    fetch(url, {
                            method: method,
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify(this.form)
                        })
                        .then(res => res.json().then(data => ({
                            status: res.status,
                            body: data
                        })))
                        .then(res => {
                            if (res.status !== 200) {
                                alert(res.body.message || 'Terjadi kesalahan!');
                                return;
                            }
                            alert(res.body.message);
                            location.reload();
                        })
                        .catch(err => {
                            console.error(err);
                            alert('Terjadi kesalahan saat menghubungi server!');
                        });
                },

                confirmDelete(id) {
                    if (confirm('Yakin ingin menghapus bouquet package ini?')) {
                        fetch(`/user/bouquets/${id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        }).then(res => res.json()).then(res => {
                            alert(res.message);
                            location.reload();
                        });
                    }
                },

                buyNow(pkgId) {
                    const pkg = this.packages.find(p => p.id === pkgId);
                    if (!pkg) return alert('Bouquet tidak ditemukan!');

                    fetch(`/user/bouquets/add-session/${pkgId}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                quantity: 1
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                // redirect sesuai URL dari server
                                window.location.href = data.redirect;
                            } else {
                                alert(data.message || 'Gagal menambahkan ke transaksi.');
                            }
                        })
                        .catch(err => console.error(err));
                }



            }
        }
    </script>
</x-app-layout>
