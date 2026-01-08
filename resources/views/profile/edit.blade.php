<x-app-layout>
    <div :class="dark ? 'theme-dark' : 'theme-light'">
        
        {{-- CSS Override untuk Form --}}
        <style>
            /* Reset Transisi */
            .profile-form-container input,
            .profile-form-container button {
                transition: all 0.3s ease-in-out;
            }

            /* Tema Light (Hitam Putih Bersih) */
            .theme-light .profile-form-container label {
                color: #000000 !important;
                font-weight: 800 !important;
                text-transform: uppercase !important;
                font-size: 0.7rem !important;
                opacity: 0.8 !important;
            }
            .theme-light .profile-form-container input {
                background-color: #ffffff !important;
                border: 1px solid #e5e7eb !important;
                color: #000000 !important;
                border-radius: 0.8rem !important;
            }
            .theme-light .profile-form-container input:focus {
                border-color: #000000 !important;
                ring: 1px solid #000000 !important;
                outline: none !important;
            }
            .theme-light .profile-form-container button {
                background-color: #000000 !important;
                color: #ffffff !important;
                font-weight: 900 !important;
                text-transform: uppercase !important;
                border-radius: 0.8rem !important;
                padding: 0.8rem 2rem !important;
            }

            /* Tema Dark (Cyan Cyberpunk) */
            .theme-dark .profile-form-container label {
                color: #ffffff !important;
                opacity: 0.7 !important;
                font-weight: 800 !important;
                text-transform: uppercase !important;
                font-size: 0.7rem !important;
            }
            .theme-dark .profile-form-container input {
                background-color: #0f1115 !important;
                border: 1px solid #374151 !important;
                color: #ffffff !important;
                border-radius: 0.8rem !important;
            }
            .theme-dark .profile-form-container input:focus {
                border-color: #06b6d4 !important;
                box-shadow: 0 0 15px rgba(6, 182, 212, 0.2) !important;
            }
            .theme-dark .profile-form-container button {
                background-color: #06b6d4 !important;
                color: #000000 !important;
                font-weight: 900 !important;
                text-transform: uppercase !important;
                border-radius: 0.8rem !important;
                padding: 0.8rem 2rem !important;
                box-shadow: 0 0 20px rgba(6, 182, 212, 0.4) !important;
            }
        </style>

        <div class="mb-6">
            <h1 class="text-3xl font-black tracking-tight transition-colors" 
                :class="dark ? 'text-white' : 'text-black'">Pengaturan Akun</h1>
        </div>

        {{-- Kartu Identitas Digital --}}
        <div class="mb-10 relative group">
            <div class="absolute -inset-1 rounded-[35px] blur opacity-25 group-hover:opacity-40 transition duration-1000"
                 :class="dark ? 'bg-gradient-to-r from-cyan-400 to-blue-600' : 'bg-black'"></div>
            
            <div class="relative rounded-[30px] p-8 md:p-10 text-white overflow-hidden shadow-2xl transition-all duration-500"
                 :class="dark ? 'bg-gradient-to-br from-cyan-500 to-blue-700' : 'bg-black'">
                
                <div class="absolute top-0 right-0 w-64 h-64 rounded-full blur-3xl -mr-16 -mt-16 mix-blend-overlay transition-colors"
                     :class="dark ? 'bg-white/10' : 'bg-white/5'"></div>
                
                <div class="relative z-10 flex flex-col md:flex-row items-center gap-8 md:gap-12">
                    <div class="relative shrink-0">
                        <div class="w-32 h-32 rounded-full border-4 p-1 backdrop-blur-sm shadow-xl transition-colors"
                             :class="dark ? 'border-white/20 bg-white/10' : 'border-gray-800 bg-gray-900'">
                            <div class="w-full h-full rounded-full flex items-center justify-center overflow-hidden"
                                 :class="dark ? 'bg-[#0f1115]' : 'bg-[#1a1a1a]'">
                                <span class="text-5xl font-black text-transparent bg-clip-text"
                                      :class="dark ? 'bg-gradient-to-tr from-cyan-400 to-blue-500' : 'bg-gradient-to-tr from-white to-gray-400'">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </span>
                            </div>
                        </div>
                        <div class="absolute -bottom-2 -right-2 backdrop-blur border px-4 py-1.5 rounded-full text-xs font-black uppercase tracking-widest shadow-lg transition-colors"
                             :class="dark ? 'bg-black/80 text-cyan-400 border-cyan-500/50' : 'bg-white text-black border-black'">
                            {{ Auth::user()->role }}
                        </div>
                    </div>

                    <div class="text-center md:text-left flex-1 space-y-2">
                        <p class="font-bold uppercase tracking-widest text-xs mb-1 opacity-80"
                           :class="dark ? 'text-cyan-100' : 'text-gray-400'">Kartu Identitas</p>
                        <h2 class="text-4xl md:text-5xl font-black tracking-tight drop-shadow-lg text-white">
                            {{ Auth::user()->name }}
                        </h2>
                        <p class="font-mono text-sm tracking-wide inline-block px-3 py-1 rounded-lg transition-colors"
                           :class="dark ? 'text-white/80 bg-white/10' : 'text-gray-300 bg-white/5'">
                            {{ Auth::user()->email }}
                        </p>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-6 pt-6 border-t"
                             :class="dark ? 'border-white/20' : 'border-white/10'">
                            <div>
                                <p class="text-[10px] uppercase opacity-70 font-bold" :class="dark ? 'text-cyan-100' : 'text-gray-500'">Username</p>
                                <p class="font-bold text-lg">@ {{ Auth::user()->username }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] uppercase opacity-70 font-bold" :class="dark ? 'text-cyan-100' : 'text-gray-500'">NIK / ID</p>
                                <p class="font-bold text-lg font-mono">{{ Auth::user()->nik ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Form Edit & Keamanan --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start mb-12">
            
            <div class="rounded-[30px] p-8 h-full transition-all duration-500 border"
                 :class="dark ? 'bg-[#161b22] border-white/5 hover:border-cyan-500/30' : 'bg-white border-gray-200 shadow-xl'">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center transition-colors shadow-sm" 
                         :class="dark ? 'bg-cyan-500/10 text-cyan-400' : 'bg-black text-white'">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-black uppercase tracking-tight transition-colors" :class="dark ? 'text-white' : 'text-black'">Edit Biodata</h3>
                        <p class="text-[10px] font-bold uppercase tracking-wider opacity-50">Perbarui Data Diri</p>
                    </div>
                </div>
                <div class="profile-form-container space-y-5">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="rounded-[30px] p-8 h-full transition-all duration-500 border"
                 :class="dark ? 'bg-[#161b22] border-white/5 hover:border-cyan-500/30' : 'bg-white border-gray-200 shadow-xl'">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center transition-colors shadow-sm" 
                         :class="dark ? 'bg-cyan-500/10 text-cyan-400' : 'bg-black text-white'">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-black uppercase tracking-tight transition-colors" :class="dark ? 'text-white' : 'text-black'">Keamanan</h3>
                        <p class="text-[10px] font-bold uppercase tracking-wider opacity-50">Update Password</p>
                    </div>
                </div>
                <div class="profile-form-container space-y-5">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>

        {{-- Hapus Akun --}}
        <div class="border rounded-[25px] p-8 mb-10 transition-all overflow-hidden"
             :class="dark ? 'bg-red-500/5 border-red-500/30' : 'bg-white border-red-200 shadow-lg'">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center text-white"
                         :class="dark ? 'bg-red-500/20 text-red-500' : 'bg-red-500'">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-black uppercase text-red-500">Hapus Akun Permanen</h3>
                        <p class="text-xs font-bold opacity-60" :class="dark ? 'text-red-400' : 'text-red-600'">Data yang dihapus tidak dapat dikembalikan.</p>
                    </div>
                </div>
                <div class="profile-form-container w-full md:w-auto">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>