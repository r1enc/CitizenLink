<div id="modal-duplicate" class="fixed inset-0 z-[100] hidden">
    
    <div class="absolute inset-0 bg-black/80 backdrop-blur-sm transition-opacity" onclick="tutupModalDuplikat()"></div>

    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-[#161b22] border border-cyan-500/50 w-full max-w-md rounded-2xl shadow-[0_0_50px_rgba(6,182,212,0.15)] relative transform transition-all scale-100 p-6">
            
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-cyan-500/10 mb-6 animate-pulse">
                <svg class="h-8 w-8 text-cyan-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>

            <div class="text-center">
                <h3 class="text-xl font-bold text-white mb-2">Sebentar, Ada Laporan Mirip!</h3>
                <p class="text-sm text-gray-400">
                    Sistem menemuka laporan yang sama. Silahkan cek dan lakukan Upvote untuk mempercepat penanganan.
                </p>
            </div>

            <div class="mt-6 bg-[#0d1117] rounded-xl p-4 border border-white/5 text-left">
                <p class="text-[10px] text-cyan-500 font-bold uppercase mb-1">Ditemukan:</p>
                <p id="dup-text" class="text-white text-sm italic line-clamp-2">"..."</p>
                <p class="text-[10px] text-gray-500 mt-2">Lokasi: <span id="dup-lokasi" class="text-gray-300">...</span></p>
            </div>

            <div class="mt-8 grid grid-cols-2 gap-3">
                <a id="dup-link" href="#" target="_blank" class="flex items-center justify-center px-4 py-3 border border-transparent rounded-xl shadow-sm text-sm font-bold text-black bg-cyan-500 hover:bg-cyan-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500 transition">
                    Cek & Upvote 
                </a>

                <button type="button" onclick="tutupModalDuplikat()" class="flex items-center justify-center px-4 py-3 border border-white/10 rounded-xl shadow-sm text-sm font-bold text-gray-300 bg-white/5 hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition">
                    Tetap Lapor
                </button>
            </div>
        </div>
    </div>
</div>