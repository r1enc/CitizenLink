<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>CitizenLink Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: { sans: ['Poppins', 'sans-serif'] },
                    colors: {
                        harmony: {
                            dark: '#0f1115',     
                            darkcard: '#161b22', 
                            light: '#ffffff',    
                            cyan: '#06b6d4',     
                        }
                    }
                }
            }
        }
    </script>
    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Poppins', sans-serif; transition: background-color 0.3s ease; }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #e5e7eb; border-radius: 10px; }
        .dark ::-webkit-scrollbar-thumb { background: #374151; }
    </style>
</head>
{{-- Logic AlpineJS: Mengatur Sidebar (Collapsed/Expand) & Dark Mode (Simpan di LocalStorage) --}}
<body x-data="{ 
    sidebarOpen: false, 
    isCollapsed: localStorage.getItem('sidebarCollapsed') === 'true',
    dark: localStorage.getItem('theme') === 'light' ? false : true,
    toggleSidebar() { this.isCollapsed = !this.isCollapsed; localStorage.setItem('sidebarCollapsed', this.isCollapsed); }
}" 
x-init="$watch('dark', val => localStorage.setItem('theme', val ? 'dark' : 'light'))"
x-cloak
:class="dark ? 'bg-harmony-dark text-gray-300' : 'bg-white text-black'" 
class="antialiased overflow-hidden selection:bg-black selection:text-white dark:selection:bg-cyan-500">
    
    <div class="flex h-screen relative transition-colors duration-500">
        {{-- SIDEBAR: Lebar berubah dinamis berdasarkan state 'isCollapsed' --}}
        <div :class="[ 
                isCollapsed ? 'w-20' : 'w-72',
                dark ? 'bg-harmony-darkcard border-r border-white/5' : 'bg-white border-r border-black/10'
             ]" 
             class="fixed inset-y-0 left-0 z-50 transition-all duration-300 transform border-r lg:translate-x-0 lg:static lg:inset-0 flex flex-col overflow-hidden py-6">
            
            {{-- Header Sidebar (Logo & Toggle Button) --}}
            <div class="flex items-center h-16 shrink-0 px-4 mb-6 transition-all duration-300" :class="isCollapsed ? 'justify-center' : 'justify-between'">
                <a href="{{ url('/') }}" x-show="!isCollapsed" class="flex items-center gap-3 group">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center text-white shadow-lg transition-transform duration-300 group-hover:rotate-12"
                         :class="dark ? 'bg-harmony-cyan text-black' : 'bg-black text-white'">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                    </div>
                    <span class="text-lg font-black italic tracking-tighter uppercase whitespace-nowrap" :class="dark ? 'text-white' : 'text-black'">CitizenLink</span>
                </a>
                <button @click="toggleSidebar()" class="p-2 rounded-lg transition-colors"
                        :class="dark ? 'hover:bg-white/10 text-gray-400' : 'hover:bg-gray-100 text-black'">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
            </div>

            {{-- Menu Navigasi --}}
            <nav class="flex-1 px-3 space-y-2 overflow-y-auto custom-scrollbar">
                <p x-show="!isCollapsed" class="text-[10px] font-bold uppercase tracking-widest opacity-50 px-3 mt-4 mb-2">Menu Utama</p>

                {{-- Menu Dashboard --}}
                <a href="{{ route('dashboard') }}" 
                   class="flex items-center transition-all duration-300 rounded-xl group relative"
                   :class="[
                        isCollapsed ? 'justify-center w-12 h-12 mx-auto' : 'px-4 py-3 gap-3',
                        '{{ request()->routeIs('dashboard') }}' 
                            ? (dark ? 'bg-harmony-cyan text-black font-bold shadow-lg shadow-cyan-500/20' : 'bg-black text-white font-bold shadow-lg') 
                            : (dark ? 'text-gray-400 hover:bg-white/5 hover:text-white' : 'text-gray-500 hover:bg-gray-100 hover:text-black')
                   ]">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    <span x-show="!isCollapsed" x-transition class="text-xs font-bold truncate">Dashboard</span>
                </a>

                {{-- Menu Khusus Petugas (Kondisional Blade) --}}
                @if(Auth::user()->role == 'petugas')
                <a href="{{ route('petugas.tugas') }}" 
                   class="flex items-center transition-all duration-300 rounded-xl group relative"
                   :class="[
                        isCollapsed ? 'justify-center w-12 h-12 mx-auto' : 'px-4 py-3 gap-3',
                        '{{ request()->routeIs('petugas.tugas') }}' 
                            ? (dark ? 'bg-harmony-cyan text-black font-bold' : 'bg-black text-white font-bold') 
                            : (dark ? 'text-gray-400 hover:bg-white/5 hover:text-white' : 'text-gray-500 hover:bg-gray-100 hover:text-black')
                   ]">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 00-2-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                    <span x-show="!isCollapsed" x-transition class="text-xs font-bold truncate">Tugas Saya</span>
                </a>
                @endif

                {{-- Menu Profile (Kecuali Admin) --}}
                @if(Auth::user()->role !== 'admin')
                <a href="{{ route('profile.edit') }}" 
                   class="flex items-center transition-all duration-300 rounded-xl group relative"
                   :class="[
                        isCollapsed ? 'justify-center w-12 h-12 mx-auto' : 'px-4 py-3 gap-3',
                        '{{ request()->routeIs('profile.edit') }}' 
                            ? (dark ? 'bg-harmony-cyan text-black font-bold' : 'bg-black text-white font-bold') 
                            : (dark ? 'text-gray-400 hover:bg-white/5 hover:text-white' : 'text-gray-500 hover:bg-gray-100 hover:text-black')
                   ]">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    <span x-show="!isCollapsed" x-transition class="text-xs font-bold truncate">Profile</span>
                </a>
                @endif

                {{-- Toggle Dark Mode --}}
                <div class="pt-4 mt-2 border-t" :class="dark ? 'border-white/10' : 'border-black/5'">
                    <div @click="dark = !dark" 
                         class="flex items-center transition-all duration-300 rounded-xl cursor-pointer overflow-hidden group relative"
                         :class="[
                            isCollapsed ? 'justify-center w-12 h-12 mx-auto' : 'px-4 py-3 gap-3',
                            dark ? 'hover:bg-white/5' : 'hover:bg-gray-100'
                         ]">
                        <div class="relative w-10 h-5 rounded-full transition-colors duration-300 shrink-0 border box-content" 
                             :class="dark ? 'bg-gray-700 border-gray-600' : 'bg-gray-200 border-gray-300'">
                            <div class="absolute top-0.5 left-0.5 w-4 h-4 rounded-full transition-transform duration-300 shadow-sm" 
                                 :class="[
                                    !dark ? 'bg-black translate-x-[20px]' : 'bg-gray-400 translate-x-0'
                                 ]"></div>
                        </div>
                        <span x-show="!isCollapsed" x-transition class="text-[10px] font-bold opacity-70">
                            <span x-show="dark">Dark Mode</span>
                            <span x-show="!dark">Light Mode</span>
                        </span>
                    </div>
                </div>
            </nav>

            {{-- Footer Sidebar (User Info & Logout) --}}
            <div class="px-3 pb-2 pt-4 border-t" :class="dark ? 'border-white/10' : 'border-black/5'">
                <div class="flex items-center gap-3 mb-4 transition-all" :class="isCollapsed ? 'justify-center' : ''">
                    <div class="w-9 h-9 rounded-lg flex items-center justify-center font-bold uppercase shrink-0 shadow-md text-white transition-all"
                         :class="dark ? 'bg-[#21262d]' : 'bg-black'">
                        {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                    </div>
                    <div x-show="!isCollapsed" x-transition class="overflow-hidden min-w-0">
                        <p class="text-xs font-bold truncate">{{ Str::limit(Auth::user()->name, 15) }}</p>
                        <p class="text-[10px] uppercase font-bold tracking-wider opacity-60">{{ Auth::user()->role }}</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" 
                            class="flex items-center justify-center w-full transition-all duration-300 rounded-xl group text-red-500 hover:bg-red-500/10 border border-transparent hover:border-red-500/20 relative"
                            :class="isCollapsed ? 'h-12' : 'py-3 gap-3'">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        <span x-show="!isCollapsed" x-transition class="text-xs font-bold truncate">Keluar</span>
                    </button>
                </form>
            </div>
        </div>

        <div class="flex-1 flex flex-col overflow-hidden relative z-10 transition-colors duration-500">
            <main class="flex-1 overflow-x-hidden overflow-y-auto p-6 lg:p-10 scroll-smooth custom-scrollbar">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>