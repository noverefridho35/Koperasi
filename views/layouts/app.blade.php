<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Koperasi Sekolah') | Koperasi</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #F5EFE6; }
        .font-heading { font-family: 'Playfair Display', serif; }
        .card { background: #FFFDF9; border: 1px solid #E2D9C9; border-radius: 12px; box-shadow: 0 4px 12px rgba(61,43,31,0.05); }
        .btn-primary { background-color: #3D2B1F; color: #FFF; padding: 0.5rem 1rem; border-radius: 8px; font-weight: 600; }
        .btn-primary:hover { background-color: #2a1e15; }
        .table-header { background-color: #FAF6F0; color: #7A6E62; text-transform: uppercase; font-size: 0.75rem; font-weight: 700; }
        .input-field { background-color: #FAF6F0; border: 1px solid #E2D9C9; border-radius: 8px; padding: 0.5rem 1rem; width: 100%; outline: none; }
        .input-field:focus { border-color: #6B4C3B; }
    </style>
</head>
<body class="text-[#1A1A1A] antialiased flex min-h-screen">

    <!-- Sidebar -->
    <aside class="w-64 bg-[#3D2B1F] text-[#FAF3E8] min-h-screen sticky top-0 flex flex-col shrink-0">
        <div class="p-6 border-b border-white/10">
            <h1 class="font-heading text-2xl font-bold">Koperasi</h1>
            <p class="text-xs text-white/60">Sekolah</p>
        </div>
        <nav class="flex-1 py-4">
            <a href="{{ route('dashboard') }}" class="block px-6 py-3 {{ request()->routeIs('dashboard') ? 'bg-white/10 font-bold' : 'hover:bg-white/5' }}">Dashboard</a>
            <a href="{{ route('transactions.index') }}" class="block px-6 py-3 {{ request()->routeIs('transactions.*') ? 'bg-white/10 font-bold' : 'hover:bg-white/5' }}">Transaksi</a>
            <a href="{{ route('products.index') }}" class="block px-6 py-3 {{ request()->routeIs('products.*') ? 'bg-white/10 font-bold' : 'hover:bg-white/5' }}">Stok Barang</a>
            <a href="{{ route('reports.index') }}" class="block px-6 py-3 {{ request()->routeIs('reports.*') ? 'bg-white/10 font-bold' : 'hover:bg-white/5' }}">Laporan Keuangan</a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col min-w-0">
        <!-- Navbar -->
        <header class="bg-[#FFFDF9] border-b border-[#E2D9C9] h-16 flex items-center justify-between px-8 sticky top-0 z-50">
            <h2 class="font-heading text-xl font-bold">@yield('title', 'Koperasi')</h2>
            <div class="text-sm font-semibold text-[#7A6E62]">
                {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }}
            </div>
        </header>

        <!-- Page Content -->
        <div class="p-8">
            @yield('content')
        </div>
    </main>

    @stack('scripts')
</body>
</html>
