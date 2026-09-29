<x-app-layout>
    <div class="max-w-2xl mx-auto space-y-6">
        <!-- Top Navigation & Title Bar -->
        <div class="flex items-center gap-3.5 bg-white p-6 rounded-2xl border border-neutral-200/80 shadow-xs">
            <a href="{{ route('activities.index') }}" class="w-9 h-9 rounded-xl bg-neutral-100 hover:bg-neutral-200 text-neutral-600 flex items-center justify-center transition-colors shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
            </a>
            <div>
                <h1 class="text-xl font-bold text-neutral-900 tracking-tight">
                    Tambah Kegiatan Piket
                </h1>
                <p class="text-xs text-neutral-400 mt-0.5">
                    Form pembuatan tugas / aktivitas kebersihan area sekolah
                </p>
            </div>
        </div>

        <!-- Form Card with Exact Validation Rules -->
        <div class="p-6 md:p-8 bg-white rounded-2xl border border-neutral-200/80 shadow-xs">
            <form method="POST" action="{{ route('activities.store') }}" class="space-y-5">
                @csrf

                <!-- Nama Kegiatan (title) -->
                <div>
                    <label for="title" class="block text-xs font-semibold text-neutral-700 mb-1.5">
                        Nama Kegiatan <span class="text-rose-500">*</span>
                    </label>
                    <input id="title" type="text" name="title" value="{{ old('title') }}" required autofocus
                           placeholder="Contoh: Menguras Bak Mandi WC / Menyapu Selasar Rayon"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-neutral-200 text-xs text-neutral-900 focus:border-[#217C5B] focus:ring-0 transition-colors" />
                    <span class="text-[11px] text-neutral-400 mt-1 block">Minimal 4 karakter.</span>
                    @error('title')
                        <p class="text-xs text-rose-500 font-medium mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deskripsi (description) -->
                <div>
                    <label for="description" class="block text-xs font-semibold text-neutral-700 mb-1.5">
                        Deskripsi Kegiatan <span class="text-rose-500">*</span>
                    </label>
                    <textarea id="description" name="description" rows="3" required
                              placeholder="Contoh: Menguras air kotor dan menyikat bak WC, atau menyapu dan mengepel lantai ruang kelas Cisarua 5."
                              class="w-full px-3.5 py-2.5 rounded-xl border border-neutral-200 text-xs text-neutral-900 focus:border-[#217C5B] focus:ring-0 transition-colors">{{ old('description') }}</textarea>
                    <span class="text-[11px] text-neutral-400 mt-1 block">Minimal 15 karakter.</span>
                    @error('description')
                        <p class="text-xs text-rose-500 font-medium mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Target Selesai (target_date) -->
                <div>
                    <label for="target_date" class="block text-xs font-semibold text-neutral-700 mb-1.5">
                        Target Selesai <span class="text-rose-500">*</span>
                    </label>
                    <input id="target_date" type="datetime-local" name="target_date" value="{{ old('target_date', now()->addHours(2)->format('Y-m-d\TH:i')) }}" required
                           class="w-full px-3.5 py-2.5 rounded-xl border border-neutral-200 text-xs text-neutral-900 focus:border-[#217C5B] focus:ring-0 transition-colors" />
                    @error('target_date')
                        <p class="text-xs text-rose-500 font-medium mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div class="pt-2 flex gap-3">
                    <a href="{{ route('activities.index') }}" class="px-5 py-2.5 bg-neutral-100 hover:bg-neutral-200 text-neutral-700 font-medium rounded-xl text-xs transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="flex-1 py-2.5 bg-[#217C5B] hover:bg-[#1A684C] text-white font-semibold rounded-xl text-xs transition-colors shadow-xs">
                        Simpan Kegiatan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
