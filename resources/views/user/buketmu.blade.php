<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-200 flex items-center gap-2">
                🌸 {{ __('Buketmu') }}
            </h2>
        </div>
        <p class="text-gray-500 mt-1">Kelola, ubah, dan beli bouquet kesukaanmu dengan mudah 💐</p>
    </x-slot>

    <div class="py-12" x-data="bouquetPackage(@js($bouquets), @js($flowers), @js($packages))">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Tombol -->
            <div class="flex justify-end">
                <button @click="$dispatch('open-create')"
                    class="px-5 py-2 bg-gradient-to-r from-pink-500 to-rose-500 text-white rounded-xl shadow hover:scale-105 transition mb-6 mt">
                    + Tambah Bouquet
                </button>
            </div>

            {{-- Daftar Bouquet Package --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <template x-for="pkg in packages" :key="pkg.id">
                    <div @click.prevent="openDetail(pkg)"
                        class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl overflow-hidden flex flex-col hover:shadow-xl transition group cursor-pointer">
                        <!-- Gambar utama -->
                        <div class="relative">
                            <img :src="pkg.bouquet.image"
                                class="w-full h-48 object-contain bg-gray-50 group-hover:scale-105 transition"
                                alt="Bouquet">
                            <div
                                class="absolute top-2 right-2 bg-pink-500 text-white text-xs px-3 py-1 rounded-full shadow">
                                <span x-text="pkg.bouquet.name"></span>
                            </div>
                        </div>

                        <!-- Info -->
                        <div class="p-4 flex flex-col flex-1">
                            <h3 class="font-semibold text-xl text-gray-800 dark:text-white mb-2" x-text="pkg.name"></h3>
                            <div class="flex flex-wrap gap-2 text-sm text-gray-600 dark:text-gray-300 mb-3">
                                <span class="bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded-lg flex items-center gap-1">
                                    💲 Rp. <span x-text="new Intl.NumberFormat('id-ID').format(pkg.price)"></span>
                                </span>
                                <span class="bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded-lg flex items-center gap-1">
                                    🌼 <span x-text="pkg.flowers.length"></span> bunga
                                </span>
                            </div>

                            <!-- Gambar bunga kecil -->
                            <div class="flex gap-2 overflow-x-auto pb-2">
                                <template x-for="flower in pkg.flowers" :key="flower.id">
                                    <img :src="flower.image"
                                        class="h-12 w-12 object-cover rounded-full border-2 border-pink-300 shadow-sm">
                                </template>
                            </div>

                            <!-- Tombol aksi -->
                            <div class="mt-auto flex justify-between items-center pt-3 gap-2">
                                <button @click.stop="openEdit(pkg)"
                                    class="flex-1 px-3 py-2 bg-blue-500 text-white text-sm rounded-lg hover:bg-blue-600 transition">✏️
                                    Edit</button>
                                <button @click.stop="confirmDelete(pkg.id)"
                                    class="flex-1 px-3 py-2 bg-red-500 text-white text-sm rounded-lg hover:bg-red-600 transition">🗑️
                                    Hapus</button>
                                <button @click.stop="buyNow(pkg.id)"
                                    class="flex-1 px-3 py-2 bg-green-500 text-white text-sm rounded-lg hover:bg-green-600 transition">🛒
                                    Beli</button>
                            </div>

                        </div>
                    </div>
                </template>
            </div>

            <!-- Modal Create/Edit -->
            <template x-if="showModal">
                <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50" @click.self="closeModal">
                    <div class="bg-white rounded-2xl shadow-lg w-full max-w-2xl p-8 relative animate-scaleIn">

                        <h2 class="text-2xl font-bold mb-6 text-gray-800" x-text="modalTitle"></h2>

                        <!-- Nama Paket -->
                        <div class="mb-4">
                            <label class="block text-gray-700 mb-1">Nama Paket</label>
                            <input type="text" x-model="form.name"
                                class="w-full border rounded-lg px-4 py-2 focus:ring-pink-500 focus:border-pink-500">
                        </div>

                        <!-- Pilih Bouquet -->
                        <div class="mb-4">
                            <label class="block text-gray-700 mb-1">Pilih Bouquet</label>
                            <select x-model="form.bouquet_id" @change="updateCapacity"
                                class="w-full border rounded-lg px-4 py-2 focus:ring-pink-500 focus:border-pink-500">
                                <option value="">-- Pilih Bouquet --</option>
                                <template x-for="b in bouquets" :key="b.id">
                                    <option :value="b.id" x-text="b.name"></option>
                                </template>
                            </select>
                        </div>

                        <!-- Pilih Bunga -->
                        <div class="mb-4">
                            <label class="block text-gray-700 mb-1">Pilih Bunga (maks: <span
                                    x-text="maxCapacity"></span>)</label>
                            <div class="grid grid-cols-3 gap-3 max-h-56 overflow-y-auto border rounded-lg p-3">
                                <template x-for="f in flowers" :key="f.id">
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="checkbox" :value="f.id" x-model="form.flowers"
                                            :disabled="form.flowers.length >= maxCapacity && !form.flowers.includes(f.id)"
                                            class="rounded text-pink-500 focus:ring-pink-500">
                                        <img :src="f.image" class="h-10 w-10 rounded-full object-cover border">
                                        <span class="text-gray-700" x-text="f.name"></span>
                                    </label>
                                </template>
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="flex justify-end gap-3 mt-6">
                            <button @click="closeModal"
                                class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300">Batal</button>
                            <button @click="submitForm"
                                class="px-5 py-2 bg-pink-500 text-white rounded-lg hover:bg-pink-600"
                                x-text="modalButton"></button>
                        </div>

                        <!-- Tombol close -->
                        <button @click="closeModal"
                            class="absolute top-4 right-4 bg-black/50 hover:bg-black/70 text-white rounded-full p-2">
                            ✕
                        </button>
                    </div>
                </div>
            </template>


            <!-- Modal Detail -->
            <template x-if="showDetail && selectedPackage">
                <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50" @click.self="closeDetail">
                    <div class="bg-white rounded-2xl shadow-lg w-full max-w-5xl h-[90vh] flex overflow-hidden relative">

                        <!-- Gambar besar kiri -->
                        <div class="w-1/2 bg-gray-50 flex items-center justify-center p-8">
                            <img :src="selectedPackage.bouquet.image" alt="Bouquet"
                                class="max-h-full max-w-full object-contain rounded-xl shadow">

                        </div>

                        <!-- Detail kanan -->
                        <div class="w-1/2 p-8 flex flex-col overflow-y-auto">
                            <h2 class="text-3xl font-bold mb-4 text-gray-800" x-text="selectedPackage.name"></h2>
                            <p class="text-gray-600 mb-6 leading-relaxed" x-text="selectedPackage.description"></p>

                            <!-- Daftar bunga -->
                            <div class="mb-6">
                                <h4 class="font-semibold text-lg mb-2">🌼 Isi Bunga:</h4>
                                <div class="flex flex-wrap gap-2">
                                    <template x-for="flower in selectedPackage.flowers" :key="flower.id">
                                        <div class="flex items-center gap-2 bg-gray-100 px-3 py-1 rounded-full">
                                            <img :src="flower.image" class="h-6 w-6 object-cover rounded-full">
                                            <span class="text-sm" x-text="flower.name"></span>
                                        </div>
                                    </template>
                                </div>
                            </div>

                            <!-- Harga & aksi -->
                            <div class="mt-auto flex justify-between items-center border-t pt-4">
                                <span class="text-2xl font-semibold text-red-600"
                                    x-text="`Rp ${new Intl.NumberFormat('id-ID').format(selectedPackage.price)}`"></span>
                                <button @click="buyNow(selectedPackage.id)"
                                    class="bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-xl shadow">
                                    Beli Sekarang
                                </button>
                            </div>
                        </div>

                        <!-- Tombol close -->
                        <button @click="closeDetail"
                            class="absolute top-4 right-4 bg-black/50 hover:bg-black/70 text-white rounded-full p-2">
                            ✕
                        </button>
                    </div>
                </div>
            </template>
        </div>

        {{-- Modal Create/Edit (punyamu tetap) --}}
        {{-- ... (kode form modal create/edit tidak aku ubah, tetap jalan) ... --}}

        {{-- Form tersembunyi untuk POST buyNow --}}
        <form id="buyForm" method="POST" style="display:none;">
            @csrf
        </form>
    </div>

    <style>
        @keyframes scaleIn {
            0% {
                transform: scale(0.9);
                opacity: 0;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .animate-scaleIn {
            animation: scaleIn 0.2s ease-out;
        }
    </style>

    <script>
        function bouquetPackage(bouquets, flowers, packages) {
        return {
            showModal: false,
            modalTitle: '',
            modalButton: '',
            maxCapacity: 0,
            selectedBouquet: null,
            selectedPackage: null,
            showDetail: false,
            form: { id: null, name: '', bouquet_id: '', flowers: [] },
            bouquets, flowers, packages,

            init() {
            // listen event dari luar
            window.addEventListener('open-create', () => {
                this.openCreate();
            });
        },

            openCreate() {
                this.modalTitle = 'Tambah Bouquet Package';
                this.modalButton = 'Simpan';
                this.form = { id: null, name: '', bouquet_id: '', flowers: [] };
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
            closeModal() { this.showModal = false; },

            openDetail(pkg) {
                this.selectedPackage = pkg;
                this.showDetail = true;
                document.body.classList.add("overflow-hidden");
            },
            closeDetail() {
                this.selectedPackage = null;
                this.showDetail = false;
                document.body.classList.remove("overflow-hidden");
            },

            updateCapacity() {
                this.selectedBouquet = this.bouquets.find(b => b.id == this.form.bouquet_id);
                this.maxCapacity = this.selectedBouquet ? this.selectedBouquet.capacity : 0;
                if (this.form.flowers.length > this.maxCapacity) {
                    this.form.flowers = this.form.flowers.slice(0, this.maxCapacity);
                }
            },

            async submitForm() {
               if (!this.form.name || !this.form.bouquet_id || this.form.flowers.length == 0) {
                    alert('Semua field harus diisi!');
                    return;
                }

                if (this.form.flowers.length > this.maxCapacity) {
                    alert('Jumlah bunga melebihi kapasitas bouquet!');
                    return;
                }

                let url = this.form.id
                    ? `/user/bouquets/${this.form.id}`
                    : `/user/bouquets`;

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

            async confirmDelete(id) {
                if (!confirm('Yakin ingin menghapus paket ini?')) return;

                try {
                    const res = await fetch(`/bouquet-packages/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    });
                    const data = await res.json();
                    if (data.success) {
                        this.packages = this.packages.filter(p => p.id !== id);
                    } else {
                        alert(data.message || 'Gagal menghapus paket.');
                    }
                } catch (err) {
                    console.error(err);
                    alert('Terjadi kesalahan saat menghubungi server!');
                }
            },

            async buyNow(pkgId) {
                const pkg = this.packages.find(p => p.id === pkgId);
                if (!pkg) return alert('Bouquet tidak ditemukan!');

                try {
                    const res = await fetch(`/user/bouquets/add-session/${pkgId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ quantity: 1 })
                    });
                    const data = await res.json();

                    if (data.success) {
                        window.location.href = data.redirect;
                    } else {
                        alert(data.message || 'Gagal menambahkan ke transaksi.');
                    }
                } catch (err) {
                    console.error(err);
                    alert('Terjadi kesalahan saat menghubungi server!');
                }
            }
        }
    }
    </script>

</x-app-layout>