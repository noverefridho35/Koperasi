@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="card p-6 border-l-4 border-[#4A7C59]">
        <h3 class="text-xs font-bold text-[#7A6E62] uppercase tracking-wider mb-2">Total Pemasukan</h3>
        <p class="font-heading text-2xl text-[#4A7C59]">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</p>
    </div>
    
    <div class="card p-6 border-l-4 border-[#8B3A3A]">
        <h3 class="text-xs font-bold text-[#7A6E62] uppercase tracking-wider mb-2">Total Pengeluaran</h3>
        <p class="font-heading text-2xl text-[#8B3A3A]">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</p>
    </div>

    <div class="card p-6 border-l-4 {{ $selisihKas >= 0 ? 'border-[#4A7C59]' : 'border-[#8B3A3A]' }}">
        <h3 class="text-xs font-bold text-[#7A6E62] uppercase tracking-wider mb-2">Selisih Kas</h3>
        <p class="font-heading text-2xl {{ $selisihKas >= 0 ? 'text-[#4A7C59]' : 'text-[#8B3A3A]' }}">
            Rp {{ number_format($selisihKas, 0, ',', '.') }}
        </p>
    </div>

    <div class="card p-6 border-l-4 border-[#2D5A7A]">
        <h3 class="text-xs font-bold text-[#7A6E62] uppercase tracking-wider mb-2">Total Jenis Barang</h3>
        <p class="font-heading text-2xl text-[#2D5A7A]">{{ $totalItem }} Item</p>
    </div>
</div>

@if($stokMenipis > 0)
<div class="bg-[#fff3cd] border border-[#ffe082] text-[#8B6914] px-6 py-4 rounded-xl mb-8 flex items-center gap-3">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
    <span class="font-semibold">Perhatian! Ada {{ $stokMenipis }} barang dengan stok menipis (<= 10).</span>
</div>
@endif

<div class="card p-6">
    <h3 class="font-heading text-lg mb-4">Transaksi Terkini</h3>
    @if($transactions->isEmpty())
        <p class="text-center text-[#7A6E62] py-4">Belum ada transaksi.</p>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="table-header">
                        <th class="p-3 rounded-tl-lg">Tanggal</th>
                        <th class="p-3">Jenis</th>
                        <th class="p-3">Kasir</th>
                        <th class="p-3 text-right rounded-tr-lg">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E2D9C9]">
                    @foreach($transactions as $trx)
                    <tr class="hover:bg-[#FAF6F0] transition">
                        <td class="p-3">{{ $trx->tanggal }}</td>
                        <td class="p-3">
                            <span class="px-2 py-1 text-xs font-bold rounded-full {{ $trx->jenis == 'PENJUALAN' ? 'bg-[#d4edda] text-[#4A7C59]' : 'bg-[#f8d7da] text-[#8B3A3A]' }}">
                                {{ $trx->jenis }}
                            </span>
                        </td>
                        <td class="p-3">{{ $trx->kasir }}</td>
                        <td class="p-3 text-right font-bold {{ $trx->jenis == 'PENJUALAN' ? 'text-[#4A7C59]' : 'text-[#8B3A3A]' }}">
                            {{ $trx->jenis == 'PENJUALAN' ? '+' : '-' }} Rp {{ number_format($trx->total_harga, 0, ',', '.') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
