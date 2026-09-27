@extends('layouts.app')

@section('title', 'Transaksi')

@section('content')
<div class="grid grid-cols-1 xl:grid-cols-3 gap-6 items-start">
    <!-- Form Transaksi Baru -->
    <div class="card p-6 xl:col-span-1">
        <h3 class="font-heading text-lg mb-4">Transaksi Baru</h3>
        @if(session('success'))
            <div class="bg-[#d4edda] text-[#4A7C59] px-4 py-2 rounded-lg mb-4 text-sm" role="status">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="bg-[#f8d7da] text-[#8B3A3A] px-4 py-2 rounded-lg mb-4 text-sm" role="alert">
                @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
            </div>
        @endif

        <form action="{{ route('transactions.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-xs font-bold text-[#7A6E62] uppercase mb-1">Jenis</label>
                <select name="jenis" class="input-field" required>
                    <option value="PENJUALAN" {{ old('jenis') === 'PENJUALAN' ? 'selected' : '' }}>Penjualan (Uang Masuk)</option>
                    <option value="PEMBELIAN" {{ old('jenis') === 'PEMBELIAN' ? 'selected' : '' }}>Pembelian (Uang Keluar / Restok)</option>
                </select>
            </div>
            
            <div class="mb-4">
                <label class="block text-xs font-bold text-[#7A6E62] uppercase mb-1">Kasir / Operator</label>
                <input type="text" name="kasir" value="{{ old('kasir') }}" class="input-field" required maxlength="255" placeholder="Nama Kasir">
            </div>

            <div class="mb-4" id="items-container">
                <label class="block text-xs font-bold text-[#7A6E62] uppercase mb-1 flex justify-between">
                    Barang
                    <button type="button" onclick="addItem()" class="text-[#3D2B1F] hover:underline">+ Tambah</button>
                </label>
                <div class="item-row flex gap-2 mb-2">
                    <select name="items[0][product_id]" class="input-field w-2/3" required>
                        <option value="">Pilih Barang...</option>
                        @foreach($products as $p)
                            <option value="{{ $p->id }}" {{ old('items.0.product_id') == $p->id ? 'selected' : '' }}>{{ $p->nama_barang }} (Sisa: {{ $p->stok_tersisa }})</option>
                        @endforeach
                    </select>
                    <input type="number" name="items[0][jumlah]" class="input-field w-1/3" min="1" step="1" value="{{ old('items.0.jumlah', 1) }}" required placeholder="Qty">
                </div>
                @error('items')<p class="text-sm text-[#8B3A3A]">{{ $message }}</p>@enderror
            </div>

            <button type="submit" class="btn-primary w-full">Simpan Transaksi</button>
        </form>
    </div>

    <!-- Riwayat Transaksi -->
    <div class="card p-6 xl:col-span-2 min-w-0">
        <h3 class="font-heading text-lg mb-4">Riwayat Transaksi</h3>
        
        <form action="{{ route('transactions.index') }}" method="GET" class="mb-4 flex gap-2">
            <select name="jenis" aria-label="Filter jenis transaksi" class="input-field w-auto" onchange="this.form.submit()">
                <option value="SEMUA">Semua Jenis</option>
                <option value="PENJUALAN" {{ $jenis == 'PENJUALAN' ? 'selected' : '' }}>Penjualan</option>
                <option value="PEMBELIAN" {{ $jenis == 'PEMBELIAN' ? 'selected' : '' }}>Pembelian</option>
            </select>
            <select name="minggu" aria-label="Filter minggu" class="input-field w-auto" onchange="this.form.submit()">
                <option value="">Semua Minggu</option>
                @for($week = 1; $week <= 4; $week++)
                    <option value="{{ $week }}" {{ (string) $minggu === (string) $week ? 'selected' : '' }}>Minggu {{ $week }}</option>
                @endfor
            </select>
        </form>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="table-header">
                        <th class="p-3">Tanggal</th>
                        <th class="p-3">Jenis</th>
                        <th class="p-3">Kasir</th>
                        <th class="p-3">Item</th>
                        <th class="p-3 text-right">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E2D9C9]">
                    @forelse($transactions as $trx)
                    <tr class="hover:bg-[#FAF6F0] transition">
                        <td class="p-3 whitespace-nowrap">{{ $trx->tanggal->format('d/m/Y H:i') }}</td>
                        <td class="p-3">
                            <span class="px-2 py-1 text-xs font-bold rounded-full {{ $trx->jenis == 'PENJUALAN' ? 'bg-[#d4edda] text-[#4A7C59]' : 'bg-[#f8d7da] text-[#8B3A3A]' }}">
                                {{ $trx->jenis }}
                            </span>
                        </td>
                        <td class="p-3">{{ $trx->kasir }}</td>
                        <td class="p-3">
                            <ul class="list-disc pl-4 text-xs text-[#7A6E62]">
                                @foreach($trx->items as $item)
                                    <li>{{ $item->product->nama_barang }} (x{{ $item->jumlah }})</li>
                                @endforeach
                            </ul>
                        </td>
                        <td class="p-3 text-right font-bold {{ $trx->jenis == 'PENJUALAN' ? 'text-[#4A7C59]' : 'text-[#8B3A3A]' }}">
                            {{ $trx->jenis == 'PENJUALAN' ? '+' : '-' }} Rp {{ number_format($trx->total_harga, 0, ',', '.') }}
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="p-6 text-center text-[#7A6E62]">Belum ada transaksi untuk filter ini.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $transactions->links() }}</div>
    </div>
</div>

@push('scripts')
<script>
    let itemIdx = 1;
    function addItem() {
        const container = document.getElementById('items-container');
        const row = document.createElement('div');
        row.className = 'item-row flex gap-2 mb-2';
        row.innerHTML = `
            <select name="items[${itemIdx}][product_id]" class="input-field w-2/3" required>
                <option value="">Pilih Barang...</option>
                @foreach($products as $p)
                    <option value="{{ $p->id }}">{{ $p->nama_barang }} (Sisa: {{ $p->stok_tersisa }})</option>
                @endforeach
            </select>
            <input type="number" name="items[${itemIdx}][jumlah]" class="input-field w-1/3" min="1" value="1" required placeholder="Qty">
            <button type="button" onclick="this.parentElement.remove()" class="text-[#8B3A3A] px-2 font-bold">X</button>
        `;
        container.appendChild(row);
        itemIdx++;
    }
</script>
@endpush
@endsection
