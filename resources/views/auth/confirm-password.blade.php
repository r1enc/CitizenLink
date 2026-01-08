<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Konfirmasi - CitizenLink</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased"
      x-data="{ dark: localStorage.getItem('theme') === 'dark' }" 
      x-init="$watch('dark', val => localStorage.setItem('theme', val ? 'dark' : 'light'))"
      :class="dark ? 'bg-[#0f1115] text-white' : 'bg-slate-50 text-slate-900'">

    <div class="min-h-screen flex flex-col justify-center items-center relative transition-colors duration-300 p-6">
        <div class="absolute top-6 right-6 z-50">
            <button @click="dark = !dark" class="p-3 rounded-full transition-all duration-300 shadow-lg border"
                    :class="dark ? 'bg-[#161b22] text-yellow-400 border-white/10 hover:bg-[#1c2128]' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-100'">
                <svg x-show="!dark" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                <svg x-show="dark" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
            </button>
        </div>

        <div class="mb-8 text-center">
            <div class="w-20 h-20 mx-auto rounded-3xl flex items-center justify-center shadow-[0_0_40px_rgba(6,182,212,0.6)] mb-6 transition-all duration-500 hover:scale-110"
                 :class="dark ? 'bg-cyan-500 text-black' : 'bg-gradient-to-br from-cyan-500 to-blue-600 text-white'">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
            </div>
            <h2 class="text-3xl font-black tracking-tighter uppercase mb-2">Konfirmasi Akses</h2>
        </div>

        <div class="w-full max-w-md p-8 rounded-[40px] border shadow-2xl transition-all duration-300 relative overflow-hidden"
             :class="dark ? 'bg-[#161b22] border-white/10 shadow-[0_0_50px_rgba(0,0,0,0.5)]' : 'bg-white border-white shadow-xl'">
            <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-cyan-400 via-blue-500 to-purple-600 shadow-[0_0_20px_rgba(6,182,212,0.5)]"></div>

            <div class="mb-6 text-sm font-medium leading-relaxed opacity-70">
                {{ __('Ini adalah area aman. Mohon konfirmasi password Anda sebelum melanjutkan.') }}
            </div>

            <form method="POST" action="{{ route('password.confirm') }}" class="space-y-6">
                @csrf
                <div class="group">
                    <label class="text-[10px] font-black uppercase tracking-widest opacity-60 mb-2 block">Password Saat Ini</label>
                    <input type="password" name="password" required autocomplete="current-password"
                           class="w-full px-5 py-4 rounded-2xl border text-sm font-bold outline-none transition-all duration-300"
                           :class="dark ? 'bg-[#0f1115] border-white/10 text-white focus:border-cyan-500' : 'bg-slate-50 border-slate-200 text-slate-900 focus:border-cyan-500'">
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full py-4 rounded-2xl font-black uppercase text-xs tracking-[0.2em] transition-all transform hover:scale-[1.02] hover:shadow-xl active:scale-[0.98] flex items-center justify-center gap-3 relative overflow-hidden group"
                            :class="dark ? 'bg-cyan-500 text-black hover:bg-cyan-400 shadow-[0_0_30px_rgba(6,182,212,0.3)]' : 'bg-slate-900 text-white hover:bg-slate-800 shadow-lg'">
                        <span>Konfirmasi</span>
                    </button>
                </div>
            </form>
        </div>
        <div class="mt-10 text-[10px] font-black uppercase tracking-widest opacity-30">&copy; CitizenLink</div>
    </div>
</body>
</html>