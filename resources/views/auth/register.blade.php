<x-guest-layout>
    <!-- Left Section on Desktop / Top Section on Mobile: Brand Banner -->
    <div class="relative w-full md:w-1/2 h-[28vh] min-h-[180px] md:h-auto bg-gradient-to-br from-[#217C5B] via-[#1A684C] to-[#0F3F2D] text-white flex flex-col justify-between p-8 overflow-hidden">
        <!-- Subtle Topographic Contour Lines -->
        <svg class="absolute inset-0 w-full h-full object-cover pointer-events-none opacity-20" viewBox="0 0 400 480" preserveAspectRatio="none" fill="none">
            <ellipse cx="270" cy="180" rx="30" ry="24" stroke="#FFFFFF" stroke-width="1.8" />
            <ellipse cx="270" cy="180" rx="58" ry="46" stroke="#FFFFFF" stroke-width="1.8" />
            <ellipse cx="265" cy="178" rx="90" ry="72" stroke="#FFFFFF" stroke-width="1.8" />
            <ellipse cx="90" cy="70" rx="22" ry="18" stroke="#FFFFFF" stroke-width="1.8" />
            <ellipse cx="92" cy="72" rx="48" ry="38" stroke="#FFFFFF" stroke-width="1.8" />
        </svg>

        <!-- Desktop Info -->
        <div class="hidden md:flex flex-col justify-between h-full relative z-10 space-y-6">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-white/20 flex items-center justify-center font-bold text-sm">
                    JP
                </div>
                <span class="text-xs font-bold tracking-wider uppercase">Jadwal Piket</span>
            </div>

            <div class="space-y-2">
                <h2 class="text-2xl font-bold tracking-tight">Daftar Akun Siswa</h2>
                <p class="text-xs text-white/90 leading-relaxed max-w-xs">
                    Daftarkan diri Anda untuk melihat penugasan Piket WC dan Rayon, serta mencatat kehadiran harian.
                </p>
            </div>

            <div class="text-[11px] text-white/70">
                © {{ date('Y') }} Sistem Piket
            </div>
        </div>
    </div>

    <!-- Right Section on Desktop / Bottom Section on Mobile: Form Card -->
    <div class="w-full md:w-1/2 flex-1 flex flex-col justify-between p-6 sm:p-8 md:p-10 bg-white relative z-20">
        <div>
            <!-- Heading -->
            <div class="mb-5">
                <h1 class="text-2xl font-bold text-neutral-900 tracking-tight">
                    Buat Akun
                </h1>
                <p class="text-xs text-neutral-400 mt-0.5">Lengkapi data untuk mendaftar sebagai siswa</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <!-- Name Input -->
                <div>
                    <label for="name" class="block text-xs font-semibold text-neutral-700 mb-1">
                        Nama Lengkap
                    </label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                           placeholder="Nama Siswa"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-neutral-300 text-xs text-neutral-900 focus:border-[#217C5B] focus:ring-0 transition-colors" />
                    <x-input-error :messages="$errors->get('name')" class="mt-1 text-xs" />
                </div>

                <!-- Email Input -->
                <div>
                    <label for="email" class="block text-xs font-semibold text-neutral-700 mb-1">
                        Email
                    </label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                           placeholder="siswa@email.com"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-neutral-300 text-xs text-neutral-900 focus:border-[#217C5B] focus:ring-0 transition-colors" />
                    <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs" />
                </div>

                <!-- Password Input -->
                <div>
                    <label for="password" class="block text-xs font-semibold text-neutral-700 mb-1">
                        Password
                    </label>
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                           placeholder="••••••••"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-neutral-300 text-xs text-neutral-900 focus:border-[#217C5B] focus:ring-0 transition-colors" />
                    <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs" />
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-xs font-semibold text-neutral-700 mb-1">
                        Konfirmasi Password
                    </label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                           placeholder="••••••••"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-neutral-300 text-xs text-neutral-900 focus:border-[#217C5B] focus:ring-0 transition-colors" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-xs" />
                </div>

                <!-- Submit Button -->
                <div class="pt-2">
                    <button type="submit" class="w-full py-2.5 bg-[#217C5B] hover:bg-[#1A684C] text-white font-semibold rounded-xl text-xs transition-colors shadow-xs">
                        Daftar Akun
                    </button>
                </div>
            </form>
        </div>

        <!-- Footer: Login Link -->
        <div class="pt-4 border-t border-neutral-100">
            <p class="text-center text-xs text-neutral-500">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="font-semibold text-[#217C5B] hover:underline ml-1">
                    Masuk
                </a>
            </p>
        </div>
    </div>
</x-guest-layout>
