<x-app-layout>
    <div class="flex items-center justify-between mb-10">
        <div>
            <h2 class="text-3xl font-black uppercase tracking-tighter mb-2" :class="dark ? 'text-white' : 'text-black'">
                Kelola Petugas
            </h2>
            <p class="text-xs font-bold tracking-[0.2em] uppercase opacity-50">Manajemen Akun Petugas Lapangan</p>
        </div>
        
        <a href="{{ route('dashboard') }}" class="px-6 py-3 rounded-xl font-bold text-xs uppercase tracking-widest border transition-all flex items-center gap-2"
           :class="dark ? 'border-white/10 hover:bg-white/5 text-white' : 'border-black text-black hover:bg-black hover:text-white'">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- FORM TAMBAH PETUGAS --}}
        <div class="rounded-[2rem] p-8 border h-fit shadow-lg transition-colors"
             :class="dark ? 'bg-[#161b22] border-white/5' : 'bg-white border-black/5'">
            
            <h3 class="text-lg font-bold mb-6 flex items-center gap-2">
                <span class="w-8 h-8 rounded-lg flex items-center justify-center font-bold transition-colors"
                      :class="dark ? 'bg-harmony-cyan text-black' : 'bg-black text-white'">+</span>
                Tambah Petugas
            </h3>
            
            <form action="{{ route('admin.petugas.store') }}" method="POST" class="space-y-5">
                @csrf
                @foreach(['name' => 'Nama Lengkap', 'email' => 'Email', 'nik' => 'NIK (Nomor Induk)', 'password' => 'Password'] as $field => $label)
                <div>
                    <label class="text-[10px] font-bold uppercase tracking-wider opacity-50 mb-1 block">{{ $label }}</label>
                    <input type="{{ $field == 'password' ? 'password' : ($field == 'email' ? 'email' : 'text') }}" 
                           name="{{ $field }}" required 
                           class="w-full px-4 py-3 rounded-xl border text-sm font-medium outline-none transition-all"
                           :class="dark ? 'bg-[#0f1115] border-white/10 text-white focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500' : 'bg-white border-black/20 text-black focus:border-black focus:ring-1 focus:ring-black'">
                </div>
                @endforeach

                <button type="submit" class="w-full py-3 rounded-xl font-bold uppercase text-xs tracking-widest shadow-lg transition-all mt-4"
                        :class="dark ? 'bg-harmony-cyan hover:bg-cyan-400 text-black' : 'bg-black hover:bg-gray-800 text-white'">
                    + Simpan Petugas
                </button>
            </form>
        </div>

        {{-- LIST DAFTAR PETUGAS --}}
        <div class="lg:col-span-2 rounded-[2rem] border overflow-hidden shadow-lg transition-colors"
             :class="dark ? 'bg-[#161b22] border-white/5' : 'bg-white border-black/5'">
            
            <div class="p-6 border-b flex justify-between items-center transition-colors" 
                 :class="dark ? 'border-white/5' : 'border-black/5'">
                <h3 class="font-bold">Daftar Petugas Aktif</h3>
                <span class="px-3 py-1 rounded text-xs font-bold transition-colors"
                      :class="dark ? 'bg-white/5 text-white' : 'bg-black/5 text-black'">{{ $petugas->count() }} Personel</span>
            </div>
            
            <div class="p-6 grid gap-4">
                @foreach($petugas as $p)
                <div class="flex items-center justify-between p-4 rounded-xl border transition-all hover:translate-x-1"
                     :class="dark ? 'bg-[#0f1115] border-white/5 hover:border-harmony-cyan/30' : 'bg-white border-black/10 hover:border-black'">
                    
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold transition-colors"
                             :class="dark ? 'bg-gradient-to-br from-slate-700 to-slate-900 text-white' : 'bg-black text-white'">
                            {{ substr($p->name, 0, 1) }}
                        </div>
                        <div>
                            <h4 class="font-bold text-sm">{{ $p->name }}</h4>
                            <p class="text-xs opacity-50">{{ $p->email }} • {{ $p->nik }}</p>
                        </div>
                    </div>
                    
                    <form action="{{ route('admin.petugas.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Hapus petugas ini?');">
                        @csrf @method('DELETE')
                        <button type="submit" class="px-4 py-2 rounded-lg border text-[10px] font-bold uppercase tracking-wider transition-all"
                                :class="dark ? 'text-red-500 border-red-500/20 hover:bg-red-500 hover:text-white' : 'text-red-600 border-red-200 hover:bg-red-600 hover:text-white'">
                            Hapus
                        </button>
                    </form>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>