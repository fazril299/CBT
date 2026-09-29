<x-app-layout>
    <div class="max-w-3xl mx-auto space-y-6">
        <!-- Top Navigation & Header -->
        <div class="flex items-center gap-3.5 bg-white p-6 rounded-2xl border border-neutral-200/80 shadow-xs">
            <a href="{{ route('dashboard') }}" class="w-9 h-9 rounded-xl bg-neutral-100 hover:bg-neutral-200 text-neutral-600 flex items-center justify-center transition-colors shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
            </a>
            <div>
                <h1 class="text-xl font-bold text-neutral-900 tracking-tight">
                    Pengaturan Akun &amp; Kata Sandi
                </h1>
                <p class="text-xs text-neutral-400 mt-0.5">
                    Kelola profil pengguna dan perbarui kata sandi akun Anda
                </p>
            </div>
        </div>

        <!-- Ubah Kata Sandi Card (Featured First) -->
        <div class="p-6 md:p-8 bg-white rounded-2xl border border-neutral-200/80 shadow-xs">
            @include('profile.partials.update-password-form')
        </div>

        <!-- Informasi Profil Card -->
        <div class="p-6 md:p-8 bg-white rounded-2xl border border-neutral-200/80 shadow-xs">
            @include('profile.partials.update-profile-information-form')
        </div>
    </div>
</x-app-layout>
