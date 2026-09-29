<x-app-layout>
    <div class="max-w-2xl mx-auto space-y-6" x-data="{ 
        piketType: '{{ old('piket_type', $schedule->piket_type) }}',
        locationInput: '{{ old('location', $schedule->location) }}'
    }">
        <!-- Top Navigation & Title Bar -->
        <div class="flex items-center gap-3.5 bg-white p-6 rounded-2xl border border-neutral-200/80 shadow-xs">
            <a href="{{ route('schedules.show', $schedule->id) }}" class="w-9 h-9 rounded-xl bg-neutral-100 hover:bg-neutral-200 text-neutral-600 flex items-center justify-center transition-colors shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
            </a>
            <div>
                <h1 class="text-xl font-bold text-neutral-900 tracking-tight">
                    Edit Jadwal {{ $schedule->type_label }}
                </h1>
                <p class="text-xs text-neutral-400 mt-0.5">
                    Perbarui informasi area, tanggal, waktu, dan status pelaksanaan
                </p>
            </div>
        </div>

        <!-- Form Card -->
        <div class="p-6 md:p-8 bg-white rounded-2xl border border-neutral-200/80 shadow-xs">
            <form method="POST" action="{{ route('schedules.update', $schedule->id) }}" class="space-y-5">
                @csrf
                @method('PUT')

                <!-- Pilihan Kategori Piket -->
                <div>
                    <label class="block text-xs font-semibold text-neutral-700 mb-2">
                        Kategori Piket <span class="text-rose-500">*</span>
                    </label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <label class="flex items-center gap-3 p-3.5 rounded-xl border cursor-pointer transition-colors select-none"
                               :class="piketType === 'piket_wc' ? 'border-sky-500 bg-sky-50/40 text-sky-900' : 'border-neutral-200 hover:border-neutral-300'">
                            <input type="radio" name="piket_type" value="piket_wc" x-model="piketType" class="text-sky-600 focus:ring-0">
                            <div>
                                <span class="text-xs font-bold block">Piket WC</span>
                                <span class="text-[11px] text-neutral-500">Toilet &amp; kamar mandi sekolah</span>
                            </div>
                        </label>

                        <label class="flex items-center gap-3 p-3.5 rounded-xl border cursor-pointer transition-colors select-none"
                               :class="piketType === 'piket_rayon' ? 'border-purple-500 bg-purple-50/40 text-purple-900' : 'border-neutral-200 hover:border-neutral-300'">
                            <input type="radio" name="piket_type" value="piket_rayon" x-model="piketType" class="text-purple-600 focus:ring-0">
                            <div>
                                <span class="text-xs font-bold block">Piket Rayon</span>
                                <span class="text-[11px] text-neutral-500">Selasar &amp; lingkungan rayon</span>
                            </div>
                        </label>
                    </div>
                    @error('piket_type')
                        <p class="text-xs text-rose-500 font-medium mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Lokasi / Nama Area -->
                <div>
                    <label for="location" class="block text-xs font-semibold text-neutral-700 mb-1.5">
                        Lokasi / Nama Area <span class="text-rose-500">*</span>
                    </label>
                    <input id="location" type="text" name="location" x-model="locationInput" required
                           placeholder="Contoh: Selasar Depan Cisarua 5 atau WC Siswa Lt. 1"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-neutral-200 text-xs text-neutral-900 placeholder:text-neutral-400 focus:border-[#217C5B] focus:ring-0 transition-colors" />

                    <!-- Quick Preset Chips for Rayon Cisarua 5 -->
                    <div class="mt-2 flex flex-wrap items-center gap-1.5">
                        <span class="text-[11px] text-neutral-400 mr-1">Rekomendasi Cisarua 5:</span>
                        <template x-if="piketType === 'piket_wc'">
                            <div class="flex flex-wrap gap-1.5">
                                <button type="button" @click="locationInput = 'WC Siswa Lt. 1 Cisarua 5'" class="text-[11px] px-2 py-0.5 rounded-md bg-sky-50 text-sky-700 hover:bg-sky-100 transition-colors border border-sky-100">WC Siswa Lt. 1</button>
                                <button type="button" @click="locationInput = 'WC Putra Gd. B Cisarua 5'" class="text-[11px] px-2 py-0.5 rounded-md bg-sky-50 text-sky-700 hover:bg-sky-100 transition-colors border border-sky-100">WC Putra Gd. B</button>
                                <button type="button" @click="locationInput = 'WC Putri Lt. 2 Cisarua 5'" class="text-[11px] px-2 py-0.5 rounded-md bg-sky-50 text-sky-700 hover:bg-sky-100 transition-colors border border-sky-100">WC Putri Lt. 2</button>
                                <button type="button" @click="locationInput = 'WC Area Lapangan Cisarua 5'" class="text-[11px] px-2 py-0.5 rounded-md bg-sky-50 text-sky-700 hover:bg-sky-100 transition-colors border border-sky-100">WC Lapangan</button>
                            </div>
                        </template>
                        <template x-if="piketType === 'piket_rayon'">
                            <div class="flex flex-wrap gap-1.5">
                                <button type="button" @click="locationInput = 'Ruang Kelas Rayon Cisarua 5'" class="text-[11px] px-2 py-0.5 rounded-md bg-purple-50 text-purple-700 hover:bg-purple-100 transition-colors border border-purple-100">Ruang Kelas Cisarua 5</button>
                                <button type="button" @click="locationInput = 'Piket Kelas Cisarua 5'" class="text-[11px] px-2 py-0.5 rounded-md bg-purple-50 text-purple-700 hover:bg-purple-100 transition-colors border border-purple-100">Piket Kelas</button>
                                <button type="button" @click="locationInput = 'Selasar Depan Kelas Cisarua 5'" class="text-[11px] px-2 py-0.5 rounded-md bg-purple-50 text-purple-700 hover:bg-purple-100 transition-colors border border-purple-100">Selasar Depan Kelas</button>
                                <button type="button" @click="locationInput = 'Koridor Depan Kelas Cisarua 5'" class="text-[11px] px-2 py-0.5 rounded-md bg-purple-50 text-purple-700 hover:bg-purple-100 transition-colors border border-purple-100">Koridor Kelas</button>
                            </div>
                        </template>
                    </div>

                    @error('location')
                        <p class="text-xs text-rose-500 font-medium mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tanggal, Hari, Waktu Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <!-- Tanggal Piket -->
                    <div>
                        <label for="date" class="block text-xs font-semibold text-neutral-700 mb-1.5">
                            Tanggal <span class="text-rose-500">*</span>
                        </label>
                        <input id="date" type="date" name="date" value="{{ old('date', $schedule->date->format('Y-m-d')) }}" required
                               class="w-full px-3 py-2.5 rounded-xl border border-neutral-200 text-xs text-neutral-800 focus:border-[#217C5B] focus:ring-0 transition-colors" />
                        @error('date')
                            <p class="text-xs text-rose-500 font-medium mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Hari Piket -->
                    <div>
                        <label for="day" class="block text-xs font-semibold text-neutral-700 mb-1.5">
                            Hari <span class="text-rose-500">*</span>
                        </label>
                        <select id="day" name="day" required
                                class="w-full px-3 py-2.5 rounded-xl border border-neutral-200 text-xs text-neutral-800 focus:border-[#217C5B] focus:ring-0 transition-colors bg-white">
                            <option value="">-- Pilih Hari --</option>
                            @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $d)
                                <option value="{{ $d }}" {{ old('day', $schedule->day) == $d ? 'selected' : '' }}>{{ $d }}</option>
                            @endforeach
                        </select>
                        @error('day')
                            <p class="text-xs text-rose-500 font-medium mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Waktu Piket -->
                    <div>
                        <label for="time" class="block text-xs font-semibold text-neutral-700 mb-1.5">
                            Jam <span class="text-rose-500">*</span>
                        </label>
                        <input id="time" type="time" name="time" value="{{ old('time', substr($schedule->time, 0, 5)) }}" required
                               class="w-full px-3 py-2.5 rounded-xl border border-neutral-200 text-xs text-neutral-800 focus:border-[#217C5B] focus:ring-0 transition-colors" />
                        @error('time')
                            <p class="text-xs text-rose-500 font-medium mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Status Pelaksanaan -->
                <div>
                    <label for="status" class="block text-xs font-semibold text-neutral-700 mb-1.5">
                        Status Pelaksanaan <span class="text-rose-500">*</span>
                    </label>
                    <select id="status" name="status" required
                            class="w-full px-3 py-2.5 rounded-xl border border-neutral-200 text-xs text-neutral-800 focus:border-[#217C5B] focus:ring-0 transition-colors bg-white">
                        <option value="belum_dilakukan" {{ old('status', $schedule->status) == 'belum_dilakukan' ? 'selected' : '' }}>Belum Dilakukan</option>
                        <option value="sedang_berlangsung" {{ old('status', $schedule->status) == 'sedang_berlangsung' ? 'selected' : '' }}>Sedang Berlangsung</option>
                        <option value="selesai" {{ old('status', $schedule->status) == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                    @error('status')
                        <p class="text-xs text-rose-500 font-medium mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div class="pt-2 flex gap-3">
                    <a href="{{ route('schedules.show', $schedule->id) }}" class="px-5 py-2.5 bg-neutral-100 hover:bg-neutral-200 text-neutral-700 font-medium rounded-xl text-xs transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="flex-1 py-2.5 bg-[#217C5B] hover:bg-[#1A684C] text-white font-semibold rounded-xl text-xs transition-colors shadow-xs">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
