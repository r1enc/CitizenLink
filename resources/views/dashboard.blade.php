<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Logic Switcher Dashboard --}}
            {{-- Cek Role User saat ini dan load view partial yang sesuai --}}
            
            @if(Auth::user()->role === 'admin')
                {{-- Dashboard Admin: Statistik Global + Manajemen Laporan --}}
                @include('dashboard_parts._admin')

            @elseif(Auth::user()->role === 'petugas')
                {{-- Dashboard Petugas: Kolam Tugas (Pool) --}}
                @include('dashboard_parts._petugas')

            @else
                {{-- Dashboard Warga: Form Lapor + Riwayat Pribadi --}}
                @include('dashboard_parts._warga')
            @endif

        </div>
    </div>
</x-app-layout>