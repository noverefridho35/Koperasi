@extends('layouts.app')

@section('title', 'Laporan Keuangan')

@section('content')
@php
    $namaBulan = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
    ];
@endphp

<div class="card p-5 mb-6">
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <h3 class="font-heading text-lg">Ringkasan Keuangan</h3>
            <p class="text-sm text-[#7A6E62]">Periode {{ $namaBulan[$bulan] }} {{ $tahun }}</p>
        </div>
        <form action="{{ route('reports.index') }}" method="GET" class="flex flex-wrap items-end gap-3">
            <label class="text-xs font-bold text-[#7A6E62] uppercase">Bulan
                <select name="bulan" class="input-field mt-1" required>
                    @foreach($namaBulan as $nomor => $nama)
                        <option value="{{ $nomor }}" {{ $bulan === $nomor ? 'selected' : '' }}>{{ $nama }}</option>
                    @endforeach
                </select>
            </label>
            <label class="text-xs font-bold text-[#7A6E62] uppercase">Tahun
                <input type="number" name="tahun" value="{{ $tahun }}" min="2000" max="2100" class="input-field mt-1" required>
            </label>
            <button type="submit" class="btn-primary">Tampilkan</button>
        </form>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">
    <div class="card p-5 border-l-4 border-[#4A7C59]">
        <h4 class="text-xs font-bold text-[#7A6E62] uppercase mb-2">Pemasukan Penjualan</h4>
        <p class="font-heading text-xl text-[#4A7C59]">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</p>
    </div>
    <div class="card p-5 border-l-4 border-[#8B3A3A]">
        <h4 class="text-xs font-bold text-[#7A6E62] uppercase mb-2">Pengeluaran Pembelian</h4>
        <p class="font-heading text-xl text-[#8B3A3A]">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</p>
    </div>
    <div class="card p-5 border-l-4 {{ $selisihKas >= 0 ? 'border-[#4A7C59]' : 'border-[#8B3A3A]' }}">
        <h4 class="text-xs font-bold text-[#7A6E62] uppercase mb-2">Selisih Kas</h4>
        <p class="font-heading text-xl {{ $selisihKas >= 0 ? 'text-[#4A7C59]' : 'text-[#8B3A3A]' }}">Rp {{ number_format($selisihKas, 0, ',', '.') }}</p>
    </div>
    <div class="card p-5 border-l-4 border-[#2D5A7A]">
        <h4 class="text-xs font-bold text-[#7A6E62] uppercase mb-2">Jumlah Transaksi</h4>
        <p class="font-heading text-xl text-[#2D5A7A]">{{ number_format($totalTransaksi, 0, ',', '.') }} Transaksi</p>
    </div>
</div>

<div class="card p-6">
    <h3 class="font-heading text-lg mb-4">Rincian Mingguan</h3>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse text-sm">
            <thead>
                <tr class="table-header">
                    <th class="p-3">Periode</th>
                    <th class="p-3 text-right">Pemasukan</th>
                    <th class="p-3 text-right">Pengeluaran</th>
                    <th class="p-3 text-right">Selisih Kas</th>
                    <th class="p-3 text-right">Transaksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#E2D9C9]">
                @foreach($mingguan as $nomor => $data)
                    @php
                        $awal = (($nomor - 1) * 7) + 1;
                        $akhir = $nomor === 4 ? 'akhir bulan' : $nomor * 7;
                    @endphp
                    <tr class="hover:bg-[#FAF6F0]">
                        <td class="p-3">Minggu {{ $nomor }} ({{ $awal }}–{{ $akhir }})</td>
                        <td class="p-3 text-right text-[#4A7C59]">Rp {{ number_format($data['pemasukan'], 0, ',', '.') }}</td>
                        <td class="p-3 text-right text-[#8B3A3A]">Rp {{ number_format($data['pengeluaran'], 0, ',', '.') }}</td>
                        <td class="p-3 text-right font-semibold">Rp {{ number_format($data['selisih_kas'], 0, ',', '.') }}</td>
                        <td class="p-3 text-right">{{ $data['transaksi'] }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="table-header">
                    <th class="p-3">Total {{ $namaBulan[$bulan] }}</th>
                    <th class="p-3 text-right">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</th>
                    <th class="p-3 text-right">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</th>
                    <th class="p-3 text-right">Rp {{ number_format($selisihKas, 0, ',', '.') }}</th>
                    <th class="p-3 text-right">{{ $totalTransaksi }}</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection
