@extends('layouts.app')

@section('title', 'Data & Stok Barang')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="card p-4 text-center border-b-4 border-[#2D5A7A]">
        <h4 class="text-xs font-bold text-[#7A6E62] uppercase mb-1">Total Jenis</h4>
        <p class="font-heading text-xl text-[#2D5A7A]">{{ $totalJenis }} Item</p>
    </div>
    <div class="card p-4 text-center border-b-4 border-[#4A7C59]">
        <h4 class="text-xs font-bold text-[#7A6E62] uppercase mb-1">Nilai Stok (Jual)</h4>
        <p class="font-heading text-xl text-[#4A7C59]">Rp {{ number_format($totalNilaiStok, 0, ',', '.') }}</p>
    </div>
    <div class="card p-4 text-center border-b-4 border-[#8B6914]">
        <h4 class="text-xs font-bold text-[#7A6E62] uppercase mb-1">Stok Menipis</h4>
        <p class="font-heading text-xl text-[#8B6914]">{{ $stokMenipis }} Item</p>
    </div>
    <div class="card p-4 text-center border-b-4 border-[#8B3A3A]">
        <h4 class="text-xs font-bold text-[#7A6E62] uppercase mb-1">Stok Habis</h4>
        <p class="font-heading text-xl text-[#8B3A3A]">{{ $stokHabis }} Item</p>
    </div>
</div>

<div class="card p-6">
    <div class="flex flex-wrap justify-between items-center gap-4 mb-6">
        <form action="{{ route('products.index') }}" method="GET" class="flex flex-wrap gap-2 flex-1">
            <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama atau kode..." class="input-field min-w-48">
            <select name="kategori" class="input-field sm:w-auto">
                <option value="Semua">Semua Kategori</option>
                @foreach($categories as $category)
                    <option value="{{ $category }}" {{ $kategori === $category ? 'selected' : '' }}>{{ $category }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn-primary px-4">Cari</button>
            @if($search || ($kategori && $kategori !== 'Semua'))
                <a href="{{ route('products.index') }}" class="px-3 py-2 text-sm text-[#7A6E62] hover:underline">Reset</a>
            @endif
        </form>

        <details class="w-full">
            <summary class="btn-primary inline-block cursor-pointer list-none">+ Tambah Barang</summary>
            <form action="{{ route('products.store') }}" method="POST" class="mt-4 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 border-t border-[#E2D9C9] pt-4">
                @csrf
                <label class="text-sm">Kode Barang
                    <input name="kode_barang" value="{{ old('kode_barang') }}" class="input-field mt-1" required maxlength="255">
                    @error('kode_barang')<span class="text-xs text-[#8B3A3A]">{{ $message }}</span>@enderror
                </label>
                <label class="text-sm">Nama Barang
                    <input name="nama_barang" value="{{ old('nama_barang') }}" class="input-field mt-1" required maxlength="255">
                    @error('nama_barang')<span class="text-xs text-[#8B3A3A]">{{ $message }}</span>@enderror
                </label>
                <label class="text-sm">Kategori
                    <input name="kategori" value="{{ old('kategori') }}" class="input-field mt-1" required maxlength="255" list="kategori-list">
                    <datalist id="kategori-list">@foreach($categories as $category)<option value="{{ $category }}">@endforeach</datalist>
                    @error('kategori')<span class="text-xs text-[#8B3A3A]">{{ $message }}</span>@enderror
                </label>
                <label class="text-sm">Satuan
                    <input name="satuan" value="{{ old('satuan', 'Pcs') }}" class="input-field mt-1" required maxlength="50">
                    @error('satuan')<span class="text-xs text-[#8B3A3A]">{{ $message }}</span>@enderror
                </label>
                <label class="text-sm">Stok Tersedia
                    <input type="number" name="stok_tersedia" value="{{ old('stok_tersedia', 0) }}" class="input-field mt-1" required min="0" step="1">
                    @error('stok_tersedia')<span class="text-xs text-[#8B3A3A]">{{ $message }}</span>@enderror
                </label>
                <label class="text-sm">Stok Tersisa
                    <input type="number" name="stok_tersisa" value="{{ old('stok_tersisa', 0) }}" class="input-field mt-1" required min="0" step="1">
                    @error('stok_tersisa')<span class="text-xs text-[#8B3A3A]">{{ $message }}</span>@enderror
                </label>
                <label class="text-sm">Harga Beli (Rp)
                    <input type="number" name="harga_beli" value="{{ old('harga_beli', 0) }}" class="input-field mt-1" required min="0" step="0.01">
                    @error('harga_beli')<span class="text-xs text-[#8B3A3A]">{{ $message }}</span>@enderror
                </label>
                <label class="text-sm">Harga Jual (Rp)
                    <input type="number" name="harga_jual" value="{{ old('harga_jual', 0) }}" class="input-field mt-1" required min="0" step="0.01">
                    @error('harga_jual')<span class="text-xs text-[#8B3A3A]">{{ $message }}</span>@enderror
                </label>
                @error('stok_tersisa')<span class="text-sm text-[#8B3A3A] md:col-span-2 xl:col-span-4">{{ $message }}</span>@enderror
                <div class="md:col-span-2 xl:col-span-4"><button type="submit" class="btn-primary">Simpan Barang</button></div>
            </form>
        </details>
    </div>

    @if(session('success'))
        <div class="bg-[#d4edda] text-[#4A7C59] px-4 py-2 rounded-lg mb-4" role="status">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="bg-[#f8d7da] text-[#8B3A3A] px-4 py-2 rounded-lg mb-4" role="alert">
            <p class="font-semibold">Periksa kembali isian formulir:</p>
            <ul class="list-disc pl-5">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse text-sm">
            <thead>
                <tr class="table-header">
                    <th class="p-3">Kode</th>
                    <th class="p-3">Nama Barang</th>
                    <th class="p-3">Kategori</th>
                    <th class="p-3 text-center">Tersedia</th>
                    <th class="p-3 text-center">Tersisa</th>
                    <th class="p-3 text-right">Harga Jual</th>
                    <th class="p-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#E2D9C9]">
                @forelse($products as $product)
                <tr class="hover:bg-[#FAF6F0] transition">
                    <td class="p-3"><code class="bg-[#EDE3D5] px-2 py-1 rounded text-xs">{{ $product->kode_barang }}</code></td>
                    <td class="p-3 font-semibold">{{ $product->nama_barang }}</td>
                    <td class="p-3"><span class="px-2 py-1 text-xs rounded-full bg-[#EDE3D5] text-[#4A4035]">{{ $product->kategori }}</span></td>
                    <td class="p-3 text-center">{{ $product->stok_tersedia }}</td>
                    <td class="p-3 text-center font-bold {{ $product->stok_tersisa == 0 ? 'text-[#8B3A3A]' : ($product->stok_tersisa <= 10 ? 'text-[#8B6914]' : 'text-[#4A7C59]') }}">
                        {{ $product->stok_tersisa }}
                    </td>
                    <td class="p-3 text-right font-bold">Rp {{ number_format($product->harga_jual, 0, ',', '.') }}</td>
                    <td class="p-3 text-center">
                        <details>
                            <summary class="cursor-pointer text-[#3D2B1F] font-semibold hover:underline">Edit</summary>
                            <form action="{{ route('products.update', $product) }}" method="POST" class="absolute right-8 z-10 mt-2 grid w-[min(90vw,48rem)] grid-cols-1 gap-3 rounded-xl border border-[#E2D9C9] bg-[#FFFDF9] p-5 text-left shadow-xl sm:grid-cols-2 lg:grid-cols-4">
                                @csrf
                                @method('PUT')
                                <label class="text-xs">Kode
                                    <input name="kode_barang" value="{{ $product->kode_barang }}" class="input-field mt-1" required maxlength="255">
                                </label>
                                <label class="text-xs">Nama Barang
                                    <input name="nama_barang" value="{{ $product->nama_barang }}" class="input-field mt-1" required maxlength="255">
                                </label>
                                <label class="text-xs">Kategori
                                    <input name="kategori" value="{{ $product->kategori }}" class="input-field mt-1" required maxlength="255">
                                </label>
                                <label class="text-xs">Satuan
                                    <input name="satuan" value="{{ $product->satuan }}" class="input-field mt-1" required maxlength="50">
                                </label>
                                <label class="text-xs">Stok Tersedia
                                    <input type="number" name="stok_tersedia" value="{{ $product->stok_tersedia }}" class="input-field mt-1" required min="0" step="1">
                                </label>
                                <label class="text-xs">Stok Tersisa
                                    <input type="number" name="stok_tersisa" value="{{ $product->stok_tersisa }}" class="input-field mt-1" required min="0" step="1">
                                </label>
                                <label class="text-xs">Harga Beli (Rp)
                                    <input type="number" name="harga_beli" value="{{ $product->harga_beli }}" class="input-field mt-1" required min="0" step="0.01">
                                </label>
                                <label class="text-xs">Harga Jual (Rp)
                                    <input type="number" name="harga_jual" value="{{ $product->harga_jual }}" class="input-field mt-1" required min="0" step="0.01">
                                </label>
                                <div class="sm:col-span-2 lg:col-span-4"><button type="submit" class="btn-primary">Simpan Perubahan</button></div>
                            </form>
                        </details>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="p-6 text-center text-[#7A6E62]">Belum ada barang yang cocok dengan pencarian.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $products->links() }}</div>
</div>
@endsection
