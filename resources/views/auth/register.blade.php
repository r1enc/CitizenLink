<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar - CitizenLink</title>
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased"
      x-data="{ dark: localStorage.getItem('theme') === 'dark' }" 
      x-init="$watch('dark', val => localStorage.setItem('theme', val ? 'dark' : 'light'))"
      :class="dark ? 'bg-[#0f1115] text-white' : 'bg-white text-black'">

    <div class="min-h-screen flex flex-col justify-center items-center relative transition-colors duration-300 p-6 py-12">
        <div class="absolute top-6 right-6 z-50">
            <button @click="dark = !dark" class="p-3 rounded-full transition-all duration-300 shadow-lg border"
                    :class="dark ? 'bg-[#161b22] text-yellow-400 border-white/10 hover:bg-[#1c2128]' : 'bg-black text-white border-black hover:bg-gray-800'">
                <svg x-show="!dark" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                <svg x-show="dark" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
            </button>
        </div>

        <div class="mb-8 text-center">
            <div class="w-20 h-20 mx-auto rounded-3xl flex items-center justify-center shadow-[0_0_40px_rgba(6,182,212,0.6)] mb-6 transition-all duration-500 hover:scale-110"
                 :class="dark ? 'bg-cyan-500 text-black' : 'bg-black text-white'">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
            </div>
            <h2 class="text-3xl font-black tracking-tighter uppercase mb-2">CitizenLink</h2>
            <p class="text-xs font-bold tracking-[0.3em] uppercase opacity-50">Registrasi Akun</p>
        </div>

        <div class="w-full max-w-md p-8 rounded-[40px] border shadow-2xl transition-all duration-300 relative overflow-hidden"
             :class="dark ? 'bg-[#161b22] border-white/10 shadow-[0_0_50px_rgba(0,0,0,0.5)]' : 'bg-white border-black/5 shadow-xl'">
            
            <div class="absolute top-0 left-0 w-full h-1.5 shadow-[0_0_20px_rgba(6,182,212,0.5)]" :class="dark ? 'bg-gradient-to-r from-cyan-400 via-blue-500 to-purple-600' : 'bg-black'"></div>

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                @foreach(['name'=>'Nama Lengkap', 'username'=>'Username', 'nik'=>'NIK (Nomor Induk)', 'email'=>'Email'] as $field => $label)
                <div class="group">
                    <label class="text-[10px] font-black uppercase tracking-widest opacity-60 mb-1 block">{{ $label }}</label>
                    <input type="{{ $field == 'email' ? 'email' : ($field == 'nik' ? 'number' : 'text') }}" name="{{ $field }}" value="{{ old($field) }}" required 
                           class="w-full px-5 py-3 rounded-2xl border text-sm font-bold outline-none transition-all duration-300"
                           :class="dark ? 'bg-[#0f1115] border-white/10 text-white focus:border-cyan-500' : 'bg-gray-50 border-gray-200 text-black focus:border-black'">
                    <x-input-error :messages="$errors->get($field)" class="mt-2" />
                </div>
                @endforeach

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="text-[10px] font-black uppercase tracking-widest opacity-60 mb-1 block">Password</label>
                        <input type="password" name="password" required class="w-full px-5 py-3 rounded-2xl border text-sm font-bold outline-none transition-all duration-300"
                               :class="dark ? 'bg-[#0f1115] border-white/10 text-white focus:border-cyan-500' : 'bg-gray-50 border-gray-200 text-black focus:border-black'">
                    </div>
                    <div>
                        <label class="text-[10px] font-black uppercase tracking-widest opacity-60 mb-1 block">Konfirmasi</label>
                        <input type="password" name="password_confirmation" required class="w-full px-5 py-3 rounded-2xl border text-sm font-bold outline-none transition-all duration-300"
                               :class="dark ? 'bg-[#0f1115] border-white/10 text-white focus:border-cyan-500' : 'bg-gray-50 border-gray-200 text-black focus:border-black'">
                    </div>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />

                <div class="pt-4">
                    <button type="submit" class="w-full py-4 rounded-2xl font-black uppercase text-xs tracking-[0.2em] transition-all transform hover:scale-[1.02] hover:shadow-xl active:scale-[0.98] flex items-center justify-center gap-3 relative overflow-hidden group"
                            :class="dark ? 'bg-cyan-500 text-black hover:bg-cyan-400 shadow-[0_0_30px_rgba(6,182,212,0.3)]' : 'bg-black text-white hover:bg-gray-800 shadow-lg'">
                        <span>Daftar Sekarang</span>
                    </button>
                </div>
            </form>

            <div class="mt-6 pt-6 border-t text-center" :class="dark ? 'border-white/10' : 'border-black/5'">
                <p class="text-xs opacity-50 mb-3 font-medium">Sudah punya akun?</p>
                <a href="{{ route('login') }}" class="inline-flex px-6 py-2 rounded-lg border text-[10px] font-black uppercase tracking-widest transition-all hover:-translate-y-1"
                   :class="dark ? 'border-cyan-500/30 text-cyan-400 hover:bg-cyan-500/10' : 'border-black text-black hover:bg-black hover:text-white'">
                    Login Disini
                </a>
            </div>
        </div>

        <p class="text-[10px] font-black tracking-[1.2em] text-gray-700 uppercase mb-5 mt-12">CITIZENLINK &copy; 2025</p>
    </div>
</body>
</html>