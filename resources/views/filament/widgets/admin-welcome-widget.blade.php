<x-filament-widgets::widget>
    <x-filament::section class="bg-white/50 backdrop-blur-sm border-none shadow-sm dark:bg-gray-900/50 rounded-2xl">
        <div class="flex items-center gap-x-6">
            <div class="flex-shrink-0">
                <img 
                    src="{{ asset('images/admin_hero.png') }}" 
                    alt="Admin Hero" 
                    class="h-32 w-32 object-contain"
                >
            </div>
            
            <div>
                <h2 class="text-xl font-bold tracking-tight text-gray-950 dark:text-white sm:text-2xl">
                    Halo, {{ auth()->user()->name }}! 👋
                </h2>
                
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400 max-w-xl">
                    Selamat datang di halaman Admin Panel Piket Cisarua 5. 
                    Gunakan menu di samping kiri untuk mengelola Jadwal Piket, Anggota Piket, Pengguna, dan Aktivitas Harian dengan mudah.
                </p>
                
                <div class="mt-4 flex gap-x-3">
                    <x-filament::button tag="a" href="{{ url('/admin/activities') }}" size="sm" color="primary">
                        Lihat Aktivitas
                    </x-filament::button>
                    
                    <x-filament::button tag="a" href="{{ url('/admin/schedules') }}" size="sm" color="gray">
                        Kelola Jadwal
                    </x-filament::button>
                </div>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
