<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">{{ __('Form Pembayaran') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4">

            @if (session('success'))
                <div class="bg-green-200 text-green-800 p-3 rounded mb-4">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="bg-red-200 text-red-800 p-3 rounded mb-4">{{ session('error') }}</div>
            @endif

            @if (!empty($items))
                <form method="POST" action="{{ route('user.transaction.session.checkout') }}">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        @foreach ($items as $index => $item)
                            <div class="border rounded-lg shadow p-4 bg-white">
                                <img src="{{ $item['image'] }}" class="h-40 w-full object-cover rounded" alt="{{ $item['name'] }}">
                                <h3 class="text-lg font-semibold mt-2">{{ $item['name'] }}</h3>

                                <p>Harga per item: Rp {{ number_format($item['price'], 0, ',', '.') }}</p>

                                @if ($item['type'] === 'papan')
                                    <label class="text-sm font-medium mt-2">Jenis Papan</label>
                                    <input type="text" name="jenis_{{ $index }}" value="{{ $item['extra']['keterangan'] }}" list="jenisPapanList" class="border px-2 py-1 w-full jenis-papan" data-index="{{ $index }}">
                                    <datalist id="jenisPapanList">
                                        <option value="Congratulation">
                                        <option value="Turut Berduka Cita">
                                    </datalist>

                                    <label class="text-sm font-medium mt-2">Tujuan</label>
                                    <input type="text" name="tujuan_{{ $index }}" value="{{ $item['extra']['tujuan'] }}" class="border px-2 py-1 w-full tujuan-papan" data-index="{{ $index }}">
                                @else
                                    <label class="text-sm font-medium mt-2">Qty</label>
                                    <input type="number" min="1" value="{{ $item['quantity'] }}" class="border rounded px-2 py-1 w-20 quantity-input" data-index="{{ $index }}">
                                @endif

                                <p class="mt-2 font-semibold subtotal">
                                    Subtotal: Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                                </p>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-4 p-4 bg-gray-100 rounded flex justify-between items-center">
                        <h3 class="text-lg font-bold total">
                            Total: Rp {{ number_format(array_sum(array_column($items,'subtotal')), 0, ',', '.') }}
                        </h3>
                        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Bayar Sekarang</button>
                    </div>
                </form>
            @else
                <p class="text-gray-500">Belum ada item untuk dibayar.</p>
            @endif
        </div>
    </div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('input', function() {
            const index = this.dataset.index;
            const quantity = parseInt(this.value) || 1;

            fetch(`/user/transaction/session/${index}/update`, {
                method: 'POST',
                headers: {'Content-Type': 'application/json','X-CSRF-TOKEN': '{{ csrf_token() }}'},
                body: JSON.stringify({quantity})
            }).then(res => res.json()).then(data => {
                if(data.success){
                    this.closest('div.border').querySelector('.subtotal').textContent = 'Subtotal: Rp ' + new Intl.NumberFormat('id-ID').format(data.subtotal);
                    document.querySelector('.total').textContent = 'Total: Rp ' + new Intl.NumberFormat('id-ID').format(data.total);
                }
            });
        });
    });

    document.querySelectorAll('.jenis-papan, .tujuan-papan').forEach(input => {
        input.addEventListener('input', function(){
            const index = this.dataset.index;
            const keterangan = document.querySelector(`.jenis-papan[data-index="${index}"]`).value;
            const tujuan = document.querySelector(`.tujuan-papan[data-index="${index}"]`).value;

            fetch(`/user/transaction/session/${index}/update-papan`, {
                method:'POST',
                headers:{'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'},
                body:JSON.stringify({keterangan, tujuan})
            }).then(res=>res.json()).then(data=>{
            });
        });
    });
});
</script>

</x-app-layout>
