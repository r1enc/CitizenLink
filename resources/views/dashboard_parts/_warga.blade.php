<x-app-layout>
    {{-- CSS Leaflet Map --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    
    {{-- Header Dashboard --}}
    <div class="relative rounded-[30px] p-8 mb-8 border transition-all duration-500 overflow-hidden shadow-xl"
         :class="dark ? 'bg-harmony-darkcard border-white/5' : 'bg-white border-black/5'">
        
        <div class="absolute right-0 top-0 w-64 h-64 rounded-full blur-3xl -mr-16 -mt-16 pointer-events-none" :class="dark ? 'bg-harmony-cyan/10' : 'bg-black/5'"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest border transition-colors"
                          :class="dark ? 'bg-harmony-cyan/20 text-harmony-cyan border-harmony-cyan/20' : 'bg-black text-white border-black'">
                        Dashboard Warga
                    </span>
                </div>
                <h1 class="text-3xl md:text-4xl font-black tracking-tight transition-colors">
                    Halo, {{ explode(' ', Auth::user()->name)[0] }}!
                </h1>
                <p class="text-sm mt-2 max-w-xl opacity-60 font-medium">
                    Laporkan masalah sekitarmu. Sistem kami akan membantu validasi laporanmu.
                </p>
            </div>

            <div class="flex gap-3">
                <div class="backdrop-blur border px-5 py-3 rounded-2xl min-w-[120px] transition-all"
                     :class="dark ? 'bg-white/5 border-white/10' : 'bg-white border-black/10'">
                    <p class="text-[10px] font-bold uppercase tracking-wider mb-1 opacity-50">Total Lapor</p>
                    <p class="text-2xl font-black">{{ $riwayat->count() }}</p>
                </div>
                <div class="backdrop-blur border px-5 py-3 rounded-2xl min-w-[120px] transition-all"
                     :class="dark ? 'bg-white/5 border-white/10' : 'bg-white border-black/10'">
                    <p class="text-[10px] font-bold uppercase tracking-wider mb-1 opacity-50">Selesai</p>
                    <p class="text-2xl font-black text-emerald-500">{{ $riwayat->where('status_laporan', 'selesai')->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        {{-- State Management AlpineJS --}}
        <div class="lg:col-span-8" x-data="{ charCount: 0, photoPreview: null, isDragging: false, mapLocation: '', manualLocation: '', isCheckingAI: false }">
            <div class="rounded-[30px] p-1 relative overflow-hidden transition-all duration-500 border shadow-2xl"
                 :class="dark ? 'bg-harmony-darkcard border-white/5' : 'bg-white border-black/5'">
                <div class="rounded-[28px] p-6 md:p-8 transition-colors duration-500"
                     :class="dark ? 'bg-harmony-dark' : 'bg-white'">
                    
                    <form action="{{ route('pengaduan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8" id="form-lapor">
                        @csrf
                        <input type="hidden" name="duplicate_id" id="duplicate_id_input">
                        
                        <div class="space-y-4">
                            <div class="flex justify-between items-end">
                                <label class="text-[10px] font-bold uppercase tracking-widest block opacity-60">Lokasi Kejadian</label>
                                
                                <span x-show="mapLocation.length > 0" class="text-[10px] font-bold uppercase tracking-widest text-emerald-500 bg-emerald-500/10 px-2 py-1 rounded-md animate-pulse">
                                    Mode: Auto
                                </span>
                                <span x-show="manualLocation.length > 0" class="text-[10px] font-bold uppercase tracking-widest text-orange-500 bg-orange-500/10 px-2 py-1 rounded-md animate-pulse">
                                    Mode: Manual
                                </span>
                            </div>
                            
                            {{-- Logic Disable Peta saat Manual Mode --}}
                            <div class="relative transition-all duration-300" 
                                 :class="manualLocation.length > 0 ? 'opacity-40 grayscale pointer-events-none select-none' : ''">
                                
                                <div id="map" class="w-full h-64 rounded-2xl z-0 border-2 transition-colors" 
                                     :class="dark ? 'border-[#30363d]' : 'border-black/10'"></div>
                                
                                <input type="hidden" name="latitude" id="lat">
                                <input type="hidden" name="longitude" id="lng">

                                <div class="relative mt-2">
                                    <input type="text" name="lokasi" id="lokasi" x-model="mapLocation" 
                                           placeholder="Klik titik di peta untuk isi otomatis..." readonly
                                           class="w-full border rounded-xl pl-4 pr-12 py-3 outline-none font-medium transition-all text-sm cursor-pointer"
                                           :class="[
                                               dark ? 'bg-[#0d1117] border-[#30363d] text-gray-400' : 'bg-gray-50 border-gray-200 text-black',
                                               manualLocation.length > 0 ? 'bg-opacity-50' : ''
                                           ]">
                                    
                                    {{-- Tombol Reset Lokasi Peta --}}
                                    <button type="button" 
                                            @click="mapLocation = ''; document.getElementById('lokasi').value = ''; document.getElementById('lat').value = ''; document.getElementById('lng').value = '';" 
                                            x-show="mapLocation.length > 0"
                                            class="absolute right-2 top-1/2 -translate-y-1/2 p-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors shadow-lg z-20 flex items-center justify-center">
                                        <svg class="w-4 h-4 font-bold" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </button>
                                </div>
                            </div>

                            <div class="mt-4">
                                <label class="text-[10px] font-bold uppercase tracking-widest mb-2 block opacity-60">Atau Tulis Alamat Manual</label>
                                <textarea name="alamat_manual" id="alamat_manual" rows="2" 
                                    x-model="manualLocation" 
                                    :disabled="mapLocation.length > 0"
                                    placeholder="Contoh: Jl. Slamet Riyadi No. 5, Surakarta (Mode Manual)"
                                    class="w-full border rounded-xl px-5 py-4 focus:ring-2 outline-none font-medium transition-all resize-none leading-relaxed disabled:opacity-50 disabled:cursor-not-allowed"
                                    :class="dark ? 'bg-[#0d1117] border-[#30363d] text-white focus:ring-cyan-500/50' : 'bg-gray-50 border-gray-200 text-black focus:ring-black/20 focus:border-black'"></textarea>
                            </div>
                        </div>

                        <div>
                            <label class="text-[10px] font-bold uppercase tracking-widest opacity-60 mb-2 block">Keterangan</label>
                            <textarea name="isi_laporan" id="isi_laporan" rows="5" required
                                      class="w-full border rounded-xl px-5 py-4 focus:ring-2 outline-none font-medium transition-all resize-none leading-relaxed"
                                      :class="dark ? 'bg-[#0d1117] border-[#30363d] text-white focus:ring-cyan-500/50' : 'bg-gray-50 border-gray-200 text-black focus:ring-black/20 focus:border-black'"></textarea>
                        </div>

                        <div>
                            <label class="text-[10px] font-bold uppercase tracking-widest mb-3 block opacity-60">Bukti Foto</label>
                            <label class="relative w-full h-64 rounded-2xl border-2 border-dashed transition-all duration-300 cursor-pointer flex flex-col items-center justify-center overflow-hidden group"
                                   :class="[isDragging ? (dark ? 'border-cyan-500 bg-cyan-500/10' : 'border-black bg-black/5') : (dark ? 'border-[#30363d] bg-[#0d1117]' : 'border-gray-300 bg-gray-50')]">
                                <input type="file" name="foto_bukti" class="hidden" required @change="photoPreview = URL.createObjectURL($event.target.files[0])">
                                <div x-show="!photoPreview" class="text-center p-6">
                                    <p class="font-bold text-sm">Klik atau Drag Foto</p>
                                </div>
                                <div x-show="photoPreview" class="absolute inset-0"><img :src="photoPreview" class="w-full h-full object-cover"></div>
                            </label>
                        </div>

                        <div class="pt-4 border-t flex justify-end" :class="dark ? 'border-white/5' : 'border-black/5'">
                            <button type="submit" class="px-8 py-4 font-black uppercase text-xs tracking-widest rounded-xl shadow-lg transition-all active:scale-95 hover:shadow-xl"
                                    :class="dark ? 'bg-gradient-to-r from-cyan-500 to-blue-600 text-white hover:shadow-cyan-500/30' : 'bg-black text-white hover:bg-gray-900'">
                                Kirim Laporan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="lg:col-span-4 space-y-8">
            <div class="border rounded-[30px] p-6 h-[400px] flex flex-col transition-all duration-500 shadow-xl"
                 :class="dark ? 'bg-[#161b22] border-white/5' : 'bg-white border-black/5'">
                <h3 class="text-lg font-bold mb-6 pb-4 border-b flex items-center justify-between" :class="dark ? 'border-white/5' : 'border-black/5'">
                    <span>Timeline Aktivitas</span>
                    <span class="w-2 h-2 rounded-full animate-pulse" :class="dark ? 'bg-cyan-500' : 'bg-black'"></span>
                </h3>
                <div class="flex-1 overflow-y-auto space-y-6 custom-scrollbar pr-2">
                    {{-- Loop Riwayat Laporan Warga --}}
                    @forelse($riwayat as $laporan)
                    <div class="relative pl-6 group">
                        <div class="absolute left-[5px] top-3 bottom-0 w-[2px] rounded-full" :class="dark ? 'bg-white/5' : 'bg-black/5'"></div>
                        <div class="absolute left-0 top-1.5 w-3 h-3 rounded-full border-2 transition-all group-hover:scale-125 z-10" 
                             :class="[dark ? 'border-[#161b22]' : 'border-white', $laporan->status_laporan == 'selesai' ? 'bg-emerald-500' : ($laporan->status_laporan == 'proses' ? 'bg-yellow-500' : 'bg-gray-400')]"></div>
                        <a href="{{ route('laporan.tracking', $laporan->id_laporan) }}" class="block border rounded-xl p-4 transition-all hover:translate-x-1"
                           :class="dark ? 'bg-[#0f1115] border-white/5 hover:border-cyan-500/50' : 'bg-gray-50 border-black/5 hover:border-black/30'">
                            <div class="flex justify-between items-start mb-1">
                                <span class="text-[10px] font-mono opacity-50">#{{ $laporan->id_laporan }}</span>
                                <span class="text-[9px] font-bold uppercase opacity-40">{{ $laporan->created_at->diffForHumans() }}</span>
                            </div>
                            <h4 class="text-sm font-bold truncate mb-1">{{ $laporan->isi_laporan }}</h4>
                            <p class="text-[10px] font-bold uppercase tracking-wider">{{ $laporan->status_laporan }}</p>
                        </a>
                    </div>
                    @empty
                    <div class="h-full flex flex-col items-center justify-center text-center opacity-40">
                        <p class="text-xs">Belum ada aktivitas.</p>
                    </div>
                    @endforelse
                </div>
            </div>
            
            </div>
    </div>
    
    {{-- MODAL POPUP: DETEKSI DUPLIKAT --}}
    <div id="modal-duplicate" class="fixed inset-0 z-[100] hidden flex items-center justify-center bg-black/80 backdrop-blur-sm p-4">
        <div class="bg-[#161b22] border border-cyan-500/50 w-full max-w-md rounded-[30px] p-8 shadow-[0_0_50px_rgba(6,182,212,0.2)]">
            <div class="flex flex-col items-center text-center">
                <div class="w-20 h-20 rounded-full bg-cyan-500/10 flex items-center justify-center mb-6 animate-pulse ring-1 ring-cyan-500/30">
                    <svg class="h-10 w-10 text-cyan-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                </div>
                <h3 class="text-2xl font-black text-white mb-2 tracking-tighter uppercase">Laporan Serupa!</h3>
                <p class="text-sm text-gray-400 mb-6 leading-relaxed">Sistem mendeteksi laporan ini mirip dengan yang sudah ada. Cek di Jelajah lalu lakukan Upvote agar lebih efektif.</p>
                
                <div class="w-full bg-[#0d1117] rounded-xl p-5 border border-white/5 text-left mb-8 relative overflow-hidden group">
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-cyan-500"></div>
                    <p class="text-[10px] text-cyan-500 font-bold uppercase mb-2 tracking-wider">Ditemukan di Database:</p>
                    <p id="dup-text" class="text-white text-sm font-bold leading-relaxed line-clamp-2"></p>
                    <div class="flex items-center gap-2 mt-3 pt-3 border-t border-white/5">
                        <svg class="w-3 h-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <p id="dup-lokasi" class="text-[10px] text-gray-400 uppercase font-mono truncate"></p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 w-full">
                    <a id="dup-link" href="#" class="px-6 py-4 bg-cyan-500 text-black rounded-xl font-black uppercase text-[10px] tracking-widest text-center hover:bg-cyan-400 transition hover:scale-105 shadow-lg shadow-cyan-500/20">
                        Cek & Upvote
                    </a>
                    <button type="button" onclick="document.getElementById('modal-duplicate').classList.add('hidden')" class="px-6 py-4 bg-white/5 text-white rounded-xl font-black uppercase text-[10px] tracking-widest hover:bg-white/10 transition border border-white/10">
                        Tetap Lapor
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Setup Leaflet Map
            var map = L.map('map').setView([-7.5755, 110.8243], 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);          
            var marker = L.marker([-7.5755, 110.8243], {draggable: true}).addTo(map);

            // Update Input Hidden saat marker pindah
            function updateLocation(lat, lng) {
                document.getElementById('lat').value = lat;
                document.getElementById('lng').value = lng;                
                // Reverse Geocoding via Nominatim
                fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
                    .then(res => res.json())
                    .then(data => { 
                        let locationInput = document.getElementById('lokasi');
                        locationInput.value = data.display_name;
                        locationInput.dispatchEvent(new Event('input')); // Trigger AlpineJS
                    });
            }

            marker.on('dragend', (e) => updateLocation(e.target.getLatLng().lat, e.target.getLatLng().lng));           
            map.on('click', (e) => {
                if(document.getElementById('alamat_manual').value.length === 0) {
                    marker.setLatLng(e.latlng); 
                    updateLocation(e.latlng.lat, e.latlng.lng);
                }
            });

            // Logic Smart Checker via AJAX
            let duplicateIdFound = null;
            document.getElementById('isi_laporan').addEventListener('blur', function() {
                const content = this.value;
                const location = document.getElementById('alamat_manual').value || document.getElementById('lokasi').value;
                const alpineData = document.querySelector('[x-data]')._x_dataStack[0];

                if (content.length > 3) {
                    alpineData.isCheckingAI = true; 
                    fetch("{{ route('laporan.cek_duplikat') }}", {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                        body: JSON.stringify({ isi: content, lokasi: location })
                    })
                    .then(res => res.json())
                    .then(data => {
                        alpineData.isCheckingAI = false; 
                        if (data.status === 'found') {
                            // Isi Modal dengan Data Duplikat
                            duplicateIdFound = data.data.id_laporan;
                            document.getElementById('dup-text').innerText = `"${data.data.isi_laporan}"`;
                            document.getElementById('dup-lokasi').innerText = data.data.lokasi;
                            document.getElementById('dup-link').href = data.url_tracking;
                            document.getElementById('modal-duplicate').classList.remove('hidden');
                            document.getElementById('duplicate_id_input').value = duplicateIdFound;
                        }
                    })
                    .catch(() => alpineData.isCheckingAI = false);
                }
            });
        });
    </script>
</x-app-layout>