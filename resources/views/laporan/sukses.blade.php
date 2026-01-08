<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Terkirim - CitizenLink</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>body { font-family: 'Poppins', sans-serif; background: #0f1115; }</style>
</head>
<body class="text-gray-300 min-h-screen flex flex-col items-center justify-center p-6">

    <div class="max-w-md w-full text-center space-y-8 relative">
        
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-cyan-500/20 rounded-full blur-[80px] -z-10"></div>

        <div class="w-24 h-24 bg-gradient-to-tr from-cyan-400 to-blue-600 rounded-full flex items-center justify-center mx-auto shadow-2xl shadow-cyan-500/30 animate-bounce">
            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
        </div>

        <div>
            <h1 class="text-3xl font-black text-white mb-2">Laporan Diterima!</h1>
            <p class="text-gray-400 text-sm">Terima kasih atas partisipasimu.</p>
        </div>

        <div class="bg-white text-slate-900 rounded-3xl p-6 shadow-2xl relative overflow-hidden transform hover:scale-105 transition duration-500">
            <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-cyan-400 to-blue-500"></div>

            <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400 mb-1">ID Pengaduan</p>
            <h2 class="text-5xl font-black tracking-tighter mb-6 text-slate-800">#{{ $laporan->id_laporan }}</h2>

            {{-- Generate QR Code Tracking --}}
            <div class="bg-slate-100 p-4 rounded-xl inline-block mb-4 border border-slate-200">
                {!! QrCode::size(150)->color(15, 23, 42)->generate(route('laporan.tracking', $laporan->id_laporan)) !!}
            </div>

            <p class="text-xs font-bold text-slate-500 max-w-[200px] mx-auto leading-relaxed">
                Scan QR ini atau simpan ID laporan untuk memantau proses penanganan.
            </p>
        </div>

        <div class="flex flex-col gap-3">
            <a href="{{ route('laporan.tracking', $laporan->id_laporan) }}" class="w-full py-4 bg-[#161b22] border border-gray-700 rounded-xl font-bold text-white hover:bg-cyan-500 hover:text-black hover:border-cyan-500 transition shadow-lg">
                Lihat Status Sekarang &rarr;
            </a>
            
            <a href="{{ route('dashboard') }}" class="text-sm font-bold text-gray-500 hover:text-white transition py-2">
                Kembali ke Dashboard
            </a>
        </div>
    </div>

</body>
</html>