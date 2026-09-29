<section>
    <header class="flex items-start justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-[#F0FDF6] text-[#217C5B] flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-sm font-bold text-neutral-900 tracking-tight">
                        Ubah Kata Sandi
                    </h2>
                    <p class="text-xs text-neutral-500 mt-0.5">
                        Pastikan akun Anda menggunakan kata sandi yang aman untuk mencegah akses tidak sah.
                    </p>
                </div>
            </div>
        </div>

        @if (session('status') === 'password-updated')
            <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 4000)"
                 class="px-3 py-1.5 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-semibold flex items-center gap-1.5 shrink-0">
                <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Kata sandi berhasil diperbarui!</span>
            </div>
        @endif
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-5 space-y-4">
        @csrf
        @method('put')

        <!-- Kata Sandi Saat Ini -->
        <div x-data="{ show: false }">
            <label for="update_password_current_password" class="block text-xs font-semibold text-neutral-700 mb-1">
                Kata Sandi Saat Ini <span class="text-rose-500">*</span>
            </label>
            <div class="relative">
                <input id="update_password_current_password" name="current_password" :type="show ? 'text' : 'password'" required autocomplete="current-password"
                       placeholder="Masukkan kata sandi lama Anda"
                       class="w-full px-3.5 py-2.5 rounded-xl border border-neutral-200 text-xs text-neutral-900 focus:border-[#217C5B] focus:ring-0 transition-colors pr-10" />
                <button type="button" @click="show = !show" class="absolute right-3 top-2.5 text-neutral-400 hover:text-neutral-600">
                    <span class="text-[11px] font-semibold" x-text="show ? 'Sembunyi' : 'Lihat'"></span>
                </button>
            </div>
            @if($errors->updatePassword->has('current_password'))
                <p class="text-xs text-rose-500 font-medium mt-1">
                    {{ $errors->updatePassword->first('current_password') }}
                </p>
            @endif
        </div>

        <!-- Kata Sandi Baru -->
        <div x-data="{ show: false }">
            <label for="update_password_password" class="block text-xs font-semibold text-neutral-700 mb-1">
                Kata Sandi Baru <span class="text-rose-500">*</span>
            </label>
            <div class="relative">
                <input id="update_password_password" name="password" :type="show ? 'text' : 'password'" required autocomplete="new-password"
                       placeholder="Minimal 8 karakter"
                       class="w-full px-3.5 py-2.5 rounded-xl border border-neutral-200 text-xs text-neutral-900 focus:border-[#217C5B] focus:ring-0 transition-colors pr-10" />
                <button type="button" @click="show = !show" class="absolute right-3 top-2.5 text-neutral-400 hover:text-neutral-600">
                    <span class="text-[11px] font-semibold" x-text="show ? 'Sembunyi' : 'Lihat'"></span>
                </button>
            </div>
            @if($errors->updatePassword->has('password'))
                <p class="text-xs text-rose-500 font-medium mt-1">
                    {{ $errors->updatePassword->first('password') }}
                </p>
            @endif
        </div>

        <!-- Konfirmasi Kata Sandi Baru -->
        <div x-data="{ show: false }">
            <label for="update_password_password_confirmation" class="block text-xs font-semibold text-neutral-700 mb-1">
                Konfirmasi Kata Sandi Baru <span class="text-rose-500">*</span>
            </label>
            <div class="relative">
                <input id="update_password_password_confirmation" name="password_confirmation" :type="show ? 'text' : 'password'" required autocomplete="new-password"
                       placeholder="Ketik ulang kata sandi baru"
                       class="w-full px-3.5 py-2.5 rounded-xl border border-neutral-200 text-xs text-neutral-900 focus:border-[#217C5B] focus:ring-0 transition-colors pr-10" />
                <button type="button" @click="show = !show" class="absolute right-3 top-2.5 text-neutral-400 hover:text-neutral-600">
                    <span class="text-[11px] font-semibold" x-text="show ? 'Sembunyi' : 'Lihat'"></span>
                </button>
            </div>
            @if($errors->updatePassword->has('password_confirmation'))
                <p class="text-xs text-rose-500 font-medium mt-1">
                    {{ $errors->updatePassword->first('password_confirmation') }}
                </p>
            @endif
        </div>

        <div class="pt-2">
            <button type="submit" class="px-5 py-2.5 bg-[#217C5B] hover:bg-[#1A684C] text-white font-semibold rounded-xl text-xs transition-colors shadow-xs">
                Perbarui Kata Sandi
            </button>
        </div>
    </form>
</section>
