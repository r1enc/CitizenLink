<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tracking Laporan #{{ $laporan->id_laporan }}</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Poppins', sans-serif; background: #0f1115; }
        .btn-press:active { transform: scale(0.95); }
    </style>
</head>
<body class="text-gray-300 antialiased min-h-screen flex flex-col items-center py-10 px-4">

    <div class="flex items-center justify-center gap-5 mb-10 text-left">
        <div class="w-14 h-14 bg-cyan-500 rounded-2xl flex items-center justify-center text-[#0f1115] shadow-[0_0_25px_rgba(6,182,212,0.4)] shrink-0">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
            </svg>
        </div>
        <div>
            <h1 class="text-3xl font-black text-white leading-none mb-1">Tracking Pengaduan</h1>
            <p class="text-gray-500 text-sm font-medium">Pantau progres laporanmu secara real-time.</p>
        </div>
    </div>

    <div class="w-full max-w-4xl bg-[#161b22] border border-gray-700/50 rounded-[30px] p-8 relative overflow-hidden shadow-2xl">
        
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 border-b border-gray-800 pb-8 gap-6">
            <div class="text-center md:text-left">
                <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-1">ID Laporan</p>
                <h2 class="text-4xl font-bold tracking-tighter text-white">#{{ $laporan->id_laporan }}</h2>
            </div>
            
            <div class="text-center md:text-right">
                <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Status Saat Ini</p>
                @php
                    $badgeColor = match($laporan->status_laporan) {
                        'selesai' => 'bg-emerald-500 text-black shadow-emerald-500/20',
                        'proses' => 'bg-yellow-500 text-black shadow-yellow-500/20',
                        default => 'bg-gray-700 text-white'
                    };
                    $statusText = match($laporan->status_laporan) {
                        '0' => 'Menunggu Validasi', 'proses' => 'Sedang Diproses', 'selesai' => 'Selesai', default => $laporan->status_laporan
                    };
                @endphp
                <span class="px-5 py-2.5 rounded-xl text-sm font-bold uppercase shadow-lg {{ $badgeColor }}">
                    {{ $statusText }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-12 gap-8 mb-10">
            
            <div class="md:col-span-7 space-y-6">
                <div class="flex items-center gap-4">
                    <h3 class="text-white font-bold text-lg flex items-center gap-2">Detail Pengaduan</h3>
                    @auth
                        <button onclick="kirimUpvote({{ $laporan->id_laporan }})" id="upvote-btn" class="btn-press flex items-center gap-2 px-4 py-2 rounded-xl border-2 border-dashed transition-all duration-300 group {{ $hasVoted ? 'border-cyan-500 bg-cyan-500/10' : 'border-gray-600 bg-transparent hover:border-cyan-500' }}">
                            <svg id="btn-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-cyan-500 group-hover:scale-110 transition-transform">
                                <path d="M7.493 18.75c-.425 0-.82-.236-.975-.632A7.48 7.48 0 0 1 6 15.375c0-1.75.599-3.358 1.602-4.634.151-.192.373-.309.6-.397.473-.183.89-.514 1.212-.924a9.042 9.042 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V3a.75.75 0 0 1 .75-.75 2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H14.23c-.483 0-.987-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23H7.494Z" />
                                <path d="M3.75 15.375c0 .69.113 1.356.325 1.985.253.75.745 1.373 1.377 1.772.063.04.13.074.2.1.354.14.742.226 1.148.226h.75a.75.75 0 0 0 .75-.75V9a.75.75 0 0 0-.75-.75h-.75c-1.16 0-2.138.835-2.355 1.947a10.483 10.483 0 0 0-.322 1.928v3.25Z" />
                            </svg>
                            <span class="text-xs font-bold uppercase tracking-widest text-white group-hover:text-cyan-400"><span id="vote-count">{{ $laporan->jumlah_upvote }}</span> UPVOTES</span>
                        </button>
                    @else
                        <a href="{{ route('login') }}" class="flex items-center gap-2 px-4 py-2 rounded-xl border-2 border-dashed border-gray-700 bg-transparent text-gray-500 cursor-pointer hover:border-gray-500 hover:text-white transition-all">
                             <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5"><path d="M7.493 18.75c-.425 0-.82-.236-.975-.632A7.48 7.48 0 0 1 6 15.375c0-1.75.599-3.358 1.602-4.634.151-.192.373-.309.6-.397.473-.183.89-.514 1.212-.924a9.042 9.042 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V3a.75.75 0 0 1 .75-.75 2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H14.23c-.483 0-.987-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23H7.494Z" /><path d="M3.75 15.375c0 .69.113 1.356.325 1.985.253.75.745 1.373 1.377 1.772.063.04.13.074.2.1.354.14.742.226 1.148.226h.75a.75.75 0 0 0 .75-.75V9a.75.75 0 0 0-.75-.75h-.75c-1.16 0-2.138.835-2.355 1.947a10.483 10.483 0 0 0-.322 1.928v3.25Z" /></svg>
                            <span class="text-xs font-bold uppercase tracking-widest">{{ $laporan->jumlah_upvote }} UPVOTES</span>
                        </a>
                    @endauth
                </div>
                
                <div class="bg-[#0a0c10] p-6 rounded-3xl border border-gray-800 space-y-5">
                    @if($laporan->foto_bukti)
                    <div class="group relative overflow-hidden rounded-2xl border border-gray-700">
                        <img src="{{ asset('storage/' . $laporan->foto_bukti) }}" alt="Bukti Kejadian" class="w-full h-56 object-cover group-hover:scale-105 transition-transform duration-500 cursor-pointer" onclick="window.open(this.src, '_blank')">
                    </div>
                    @endif
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1">Lokasi</p>
                            <p class="text-white font-medium text-sm leading-snug">{{ $laporan->lokasi }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1">Kategori</p>
                            <span class="inline-block px-3 py-1 rounded-lg border text-[10px] font-bold uppercase tracking-wider text-cyan-400 border-cyan-400/30 bg-cyan-400/10">{{ $laporan->kategori ?? 'Lainnya' }}</span>
                        </div>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Isi Laporan</p>
                        <div class="bg-[#161b22] p-4 rounded-xl border border-gray-800"><p class="text-gray-300 text-sm leading-relaxed font-medium">"{{ $laporan->isi_laporan }}"</p></div>
                    </div>
                </div>
            </div>

            <div class="md:col-span-5 space-y-6">
                <h3 class="text-white font-bold text-lg flex items-center gap-2">⏱Timeline & SLA</h3>
                <div class="relative pl-6 border-l-2 border-gray-800 space-y-8 ml-2">
                    
                    <div class="relative">
                        <div class="absolute -left-[31px] top-1 w-4 h-4 bg-cyan-500 rounded-full ring-4 ring-[#161b22] shadow-[0_0_10px_rgba(6,182,212,0.5)]"></div>
                        <p class="text-white font-bold text-sm">Laporan Diterima</p>
                        <p class="text-xs text-gray-500 font-medium">{{ $laporan->created_at->format('d M Y, H:i') }}</p>
                    </div>

                    <div class="relative">
                        @php
                            // Status '0' = Menunggu, 'proses'/'selesai' = Aktif
                            $isActive = $laporan->status_laporan != '0';
                            $dotColor = $isActive ? 'bg-yellow-500' : 'bg-gray-700';
                            $textColor = $isActive ? 'text-white' : 'text-gray-600';
                        @endphp

                        <div class="absolute -left-[31px] top-1 w-4 h-4 {{ $dotColor }} rounded-full ring-4 ring-[#161b22]"></div>
                        
                        <p class="{{ $textColor }} font-bold text-sm">
                            {{ $laporan->status_laporan == '0' ? 'Menunggu Konfirmasi' : 'Dalam Penanganan' }}
                        </p>

                        <p class="text-xs text-gray-500 mt-1 font-medium">
                            @if($laporan->status_laporan == '0')
                                {{-- KONDISI 1: Belum Divalidasi Admin --}}
                                <span class="opacity-50">Estimasi: Menunggu Admin</span>

                            @elseif($laporan->status_laporan == 'proses')
                                {{-- KONDISI 2: Sedang Diproses -> Tampilkan Deadline (SLA) --}}
                                <span class="text-cyan-400">
                                    Estimasi Selesai: 
                                    <span class="font-mono">{{ $laporan->deadline_date->format('d M Y') }}</span>
                                </span>

                            @elseif($laporan->status_laporan == 'selesai')
                                {{-- KONDISI 3: Sudah Selesai -> Tampilkan Tanggal Selesai (Updated_at) --}}
                                <span class="text-emerald-500">
                                    Diselesaikan pada: 
                                    <span class="font-mono">{{ $laporan->updated_at->format('d M Y') }}</span>
                                </span>
                            @endif
                        </p>
                    </div>

                    <div class="relative">
                        <div class="absolute -left-[31px] top-1 w-4 h-4 {{ $laporan->status_laporan == 'selesai' ? 'bg-emerald-500' : 'bg-gray-700' }} rounded-full ring-4 ring-[#161b22]"></div>
                        <p class="{{ $laporan->status_laporan == 'selesai' ? 'text-white' : 'text-gray-600' }} font-bold text-sm">Selesai</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center border-t border-gray-800 pt-8">
            <a href="{{ url('/') }}" class="inline-block px-10 py-3 bg-gray-800 hover:bg-white hover:text-black text-gray-400 font-bold rounded-xl transition-all duration-300 text-xs uppercase tracking-widest transform hover:-translate-y-1">
                &larr; Kembali ke Beranda
            </a>
        </div>
    </div>

    <script>
        function kirimUpvote(id) {
            const btn = document.getElementById('upvote-btn');
            const countDisplay = document.getElementById('vote-count');
            btn.classList.add('opacity-50', 'cursor-wait');
            fetch(`/laporan/${id}/upvote`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' }
            })
            .then(res => res.json())
            .then(data => {
                btn.classList.remove('opacity-50', 'cursor-wait');
                if(data.status === 'success') {
                    countDisplay.innerText = data.new_count;
                    if(data.action === 'voted') {
                        btn.classList.remove('border-gray-600', 'bg-transparent');
                        btn.classList.add('border-cyan-500', 'bg-cyan-500/10');
                    } else {
                        btn.classList.add('border-gray-600', 'bg-transparent');
                        btn.classList.remove('border-cyan-500', 'bg-cyan-500/10');
                    }
                } else if(data.status === 'error') {
                    alert(data.message); window.location.href = "{{ route('login') }}";
                }
            })
            .catch(err => { console.error(err); btn.classList.remove('opacity-50', 'cursor-wait'); });
        }
    </script>
</body>
</html>