<section>
    <header class="flex items-start justify-between gap-4">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-lg bg-sky-50 text-sky-600 flex items-center justify-center shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                </svg>
            </div>
            <div>
                <h2 class="text-sm font-bold text-neutral-900 tracking-tight">
                    Informasi Profil
                </h2>
                <p class="text-xs text-neutral-500 mt-0.5">
                    Informasi identitas akun dan alamat surel Anda di sistem piket.
                </p>
            </div>
        </div>

        @if (session('status') === 'profile-updated')
            <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 4000)"
                 class="px-3 py-1.5 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-semibold flex items-center gap-1.5 shrink-0">
                <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Profil diperbarui!</span>
            </div>
        @endif
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-5 space-y-4">
        @csrf
        @method('patch')

        <div>
            <label for="name" class="block text-xs font-semibold text-neutral-700 mb-1">
                Nama Lengkap <span class="text-rose-500">*</span>
            </label>
            <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name"
                   class="w-full px-3.5 py-2.5 rounded-xl border border-neutral-200 text-xs text-neutral-900 focus:border-[#217C5B] focus:ring-0 transition-colors" />
            @error('name')
                <p class="text-xs text-rose-500 font-medium mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="block text-xs font-semibold text-neutral-700 mb-1">
                Alamat Email <span class="text-rose-500">*</span>
            </label>
            <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="username"
                   class="w-full px-3.5 py-2.5 rounded-xl border border-neutral-200 text-xs text-neutral-900 focus:border-[#217C5B] focus:ring-0 transition-colors" />
            @error('email')
                <p class="text-xs text-rose-500 font-medium mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-xs font-semibold text-neutral-700 mb-1">
                Peran Pengguna (Role)
            </label>
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-neutral-100 border border-neutral-200/80 text-xs text-neutral-700 font-semibold capitalize">
                <span>{{ $user->role === 'admin' ? '👑 Pembimbing Rayon (Admin)' : '🎒 Siswa Rayon Cisarua 5' }}</span>
            </div>
        </div>

        <div class="pt-2">
            <button type="submit" class="px-5 py-2.5 bg-neutral-900 hover:bg-neutral-800 text-white font-semibold rounded-xl text-xs transition-colors shadow-xs">
                Simpan Profil
            </button>
        </div>
    </form>
</section>
