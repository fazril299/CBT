<x-app-layout>
    <div class="space-y-6">
        <!-- Top Navigation & Title Bar -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-neutral-200/80 shadow-xs">
            <div class="flex items-center gap-3.5">
                <a href="{{ route('schedules.index') }}" class="w-9 h-9 rounded-xl bg-neutral-100 hover:bg-neutral-200 text-neutral-600 flex items-center justify-center transition-colors shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                    </svg>
                </a>
                <div>
                    <div class="flex items-center gap-2 mb-0.5">
                        @if($schedule->piket_type === 'piket_wc')
                            <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-sky-700">
                                <span class="w-1.5 h-1.5 rounded-full bg-sky-500"></span>
                                Piket WC
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-purple-700">
                                <span class="w-1.5 h-1.5 rounded-full bg-purple-500"></span>
                                Piket Rayon
                            </span>
                        @endif
                        <span class="text-xs text-neutral-400">• {{ $schedule->day }}, {{ date('d M Y', strtotime($schedule->date)) }}</span>
                    </div>

                    <h1 class="text-xl md:text-2xl font-bold text-neutral-900 tracking-tight">
                        {{ $schedule->location ?? $schedule->day }}
                    </h1>
                    <p class="text-xs text-neutral-400 mt-0.5">
                        Waktu pelaksanaan: {{ substr($schedule->time, 0, 5) }} WIB
                    </p>
                </div>
            </div>

            <!-- Admin Actions -->
            @if(Auth::user()->role === 'admin')
                <div class="flex items-center gap-2 shrink-0">
                    <a href="{{ route('schedules.edit', $schedule->id) }}" class="px-3.5 py-2 rounded-xl bg-neutral-100 hover:bg-neutral-200 text-neutral-700 text-xs font-semibold transition-colors">
                        Edit Jadwal
                    </a>

                    <form action="{{ route('schedules.destroy', $schedule->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal piket ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-3.5 py-2 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-600 text-xs font-semibold transition-colors">
                            Hapus
                        </button>
                    </form>
                </div>
            @endif
        </div>

        <!-- Ketentuan Piket Denda Rayon Cisarua 5 -->
        <div class="flex items-center gap-3 p-4 rounded-xl bg-amber-50/70 border border-amber-200/80 text-xs text-amber-900">
            <svg class="w-4 h-4 text-amber-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
            <div>
                <span class="font-bold">Ketentuan Piket:</span> Siswa berstatus <strong>Alpa</strong> (tidak piket) dikenakan <strong>denda Rp 5.000 / hari</strong>. Siswa bertanda <span class="px-1.5 py-0.5 rounded bg-emerald-100 text-emerald-800 font-bold text-[10px]">PJ</span> bertanggung jawab memastikan kebersihan area tugas sebelum dilaporkan ke Pembimbing.
            </div>
        </div>

        <!-- Success Toast -->
        @if(session('success'))
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-medium flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Error / Warning Toast -->
        @if(session('error'))
            <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-medium flex items-center gap-2">
                <svg class="w-4 h-4 text-rose-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Desktop 2-Column Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column: Attendance & Members Sheet -->
            <div class="lg:col-span-2 space-y-4">
                <!-- Card Unggah Bukti Piket (Khusus Anggota Jadwal Ini / Admin) -->
                @if($myDutyMember)
                    @php
                        $myAttendance = $myDutyMember->latestAttendance ?? $myDutyMember->attendances->first();
                        $myStatus = $myDutyMember->effective_status;
                    @endphp
                    <div class="bg-white p-6 rounded-2xl border border-neutral-200/80 shadow-xs space-y-4">
                        <div class="flex items-center justify-between pb-3 border-b border-neutral-100">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-[#F0FDF6] text-[#217C5B] flex items-center justify-center font-bold shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z"/><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0z"/></svg>
                                </div>
                                <div>
                                    <h3 class="text-sm font-bold text-neutral-900">Unggah Bukti Hasil Piket Anda</h3>
                                    <p class="text-[11px] text-neutral-400">Lampirkan foto kondisi ruang kelas / area yang telah dibersihkan</p>
                                </div>
                            </div>
                            <div>
                                @if($myStatus === 'hadir')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <svg class="w-3.5 h-3.5 text-emerald-600 shrink-0" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" /></svg>
                                        <span>Terverifikasi Hadir</span>
                                    </span>
                                @elseif($myStatus === 'menunggu_verifikasi')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold rounded-full bg-amber-50 text-amber-700 border border-amber-200 animate-pulse">
                                        <svg class="w-3.5 h-3.5 text-amber-600 shrink-0" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-13a.75.75 0 00-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 000-1.5h-3.25V5z" clip-rule="evenodd" /></svg>
                                        <span>Menunggu Verifikasi PJ</span>
                                    </span>
                                @elseif($myStatus === 'belum_waktunya')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-medium rounded-full bg-neutral-100 text-neutral-600 border border-neutral-200">
                                        <svg class="w-3.5 h-3.5 text-neutral-500 shrink-0" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" /></svg>
                                        <span>Jadwal Mendatang ({{ $schedule->day }})</span>
                                    </span>
                                @elseif($myStatus === 'belum_absen')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-medium rounded-full bg-amber-50 text-amber-800 border border-amber-200">
                                        <svg class="w-3.5 h-3.5 text-amber-700 shrink-0" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-13a.75.75 0 00-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 000-1.5h-3.25V5z" clip-rule="evenodd" /></svg>
                                        <span>Belum Kirim Bukti</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold rounded-full bg-rose-50 text-rose-700 border border-rose-200">
                                        <svg class="w-3.5 h-3.5 text-rose-600 shrink-0" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" /></svg>
                                        <span>Alpa (Denda Rp 5.000)</span>
                                    </span>
                                @endif
                            </div>
                        </div>

                        @if($myStatus === 'belum_waktunya')
                            <div class="p-3.5 rounded-xl bg-neutral-50 border border-neutral-200/80 text-xs text-neutral-600 flex items-center gap-2.5">
                                <svg class="w-4 h-4 text-neutral-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span>Jadwal piket Anda adalah hari <strong>{{ $schedule->day }}, {{ $schedule->date->format('d M Y') }}</strong>. Bukti foto hasil piket diunggah saat hari pelaksanaan piket.</span>
                            </div>
                        @endif


                        @if($myAttendance && $myAttendance->proof_image)
                            <div class="flex flex-col sm:flex-row items-start gap-4 p-3.5 rounded-xl bg-neutral-50 border border-neutral-100">
                                <a href="{{ asset('storage/' . $myAttendance->proof_image) }}" target="_blank" class="shrink-0 relative group">
                                    <img src="{{ asset('storage/' . $myAttendance->proof_image) }}" alt="Bukti Piket" class="w-20 h-20 object-cover rounded-lg border border-neutral-200 shadow-xs group-hover:opacity-90 transition-opacity">
                                    <span class="absolute inset-0 flex items-center justify-center bg-black/40 text-white text-[10px] font-bold rounded-lg opacity-0 group-hover:opacity-100 transition-opacity">Buka</span>
                                </a>
                                <div class="space-y-1 text-xs flex-1">
                                    <div class="font-semibold text-neutral-800">Catatan Pengerjaan:</div>
                                    <p class="text-neutral-600 italic">"{{ $myAttendance->proof_note ?? 'Tugas piket selesai dilaksanakan.' }}"</p>
                                    <div class="text-[11px] text-neutral-400 pt-1">
                                        Dikirim: {{ $myAttendance->recorded_at?->format('d M Y, H:i') ?? '-' }} WIB
                                    </div>
                                    @if($myAttendance->verifiedBy)
                                        <div class="text-[11px] text-emerald-700 font-semibold pt-0.5">
                                            Diverifikasi oleh: {{ $myAttendance->verifiedBy->name }} ({{ $myAttendance->verified_at?->format('H:i') }} WIB)
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif

                        @if($myStatus !== 'hadir' && $myStatus !== 'belum_waktunya')
                            <form action="{{ route('attendances.submit-proof', $myDutyMember->id) }}" method="POST" enctype="multipart/form-data" class="space-y-3 pt-1">
                                @csrf
                                <div>
                                    <label class="block text-xs font-semibold text-neutral-700 mb-1">
                                        {{ $myAttendance && $myAttendance->proof_image ? 'Unggah Ulang Foto Bukti' : 'Pilih Foto Hasil Piket' }} <span class="text-rose-500">*</span>
                                    </label>
                                    <input type="file" name="proof_image" accept="image/*" required
                                           class="w-full text-xs text-neutral-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-neutral-100 file:text-neutral-700 hover:file:bg-neutral-200 cursor-pointer border border-neutral-200 rounded-xl p-1 bg-white" />
                                    <span class="text-[10px] text-neutral-400 mt-1 block">Format: JPG, PNG, WEBP (Maksimal 5MB). Foto ruang kelas/WC yang telah dibersihkan.</span>
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-neutral-700 mb-1">
                                        Catatan Pelaksanaan <span class="text-neutral-400 font-normal">(Opsional)</span>
                                    </label>
                                    <input type="text" name="proof_note" placeholder="Contoh: Sudah menyapu dan mengepel lantai kelas, meja guru dan siswa rapi"
                                           class="w-full px-3.5 py-2 rounded-xl border border-neutral-200 text-xs text-neutral-800 focus:border-[#217C5B] focus:ring-0" />
                                </div>

                                <button type="submit" class="px-5 py-2.5 rounded-xl bg-[#217C5B] hover:bg-[#1A684C] text-white text-xs font-semibold shadow-xs transition-colors">
                                    {{ $myAttendance && $myAttendance->proof_image ? 'Kirim Pembaruan Bukti' : 'Kirim Bukti untuk Diverifikasi' }}
                                </button>
                            </form>
                        @endif

                    </div>
                @endif

                <div class="bg-white p-6 rounded-2xl border border-neutral-200/80 shadow-xs space-y-4">
                    <div class="flex items-center justify-between pb-3 border-b border-neutral-100">
                        <div>
                            <h2 class="text-base font-bold text-neutral-900">Daftar Anggota &amp; Absensi</h2>
                            <p class="text-xs text-neutral-400">Verifikasi kehadiran oleh Penanggung Jawab (PJ) atau Pembimbing</p>
                        </div>
                        <span class="text-xs font-semibold text-neutral-500 bg-neutral-100 px-3 py-1 rounded-lg">
                            {{ $schedule->dutyMembers->count() }} Siswa
                        </span>
                    </div>

                    <!-- Members List -->
                    <div class="divide-y divide-neutral-100">
                        @forelse ($schedule->dutyMembers as $member)
                            @php
                                $attendance = $member->latestAttendance ?? $member->attendances->first();
                                $status = $member->effective_status;
                                $canVerify = (Auth::user()->role === 'admin' || $isPj);
                            @endphp
                            <div class="py-4 flex flex-col gap-3">
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                    <div>
                                        <div class="flex items-center gap-2 flex-wrap">
                                            <h3 class="text-sm font-semibold text-[#37352F]">{{ $member->user->name }}</h3>
                                            @if($member->is_pj)
                                                <span class="px-1.5 py-[1px] rounded bg-[#37352F] text-white text-[9px] font-bold tracking-wider uppercase leading-none">PJ</span>
                                            @endif
                                            @if($member->user_id === Auth::id())
                                                <span class="px-1.5 py-[1px] rounded bg-[#EFEFED] text-[#37352F] text-[9.5px] font-semibold border border-[#EBEBEA]">Anda</span>
                                            @endif

                                        </div>
                                        <div class="flex items-center gap-2 mt-0.5">
                                            <span class="text-xs text-neutral-400">{{ $member->user->email }}</span>
                                            @if(Auth::user()->role === 'admin')
                                                <form action="{{ route('duty-members.toggle-pj', $member->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="text-[10px] px-1.5 py-0.2 rounded font-medium transition-colors text-neutral-400 hover:text-neutral-700 underline" title="Ubah status PJ">
                                                        {{ $member->is_pj ? 'Status: PJ' : '+ Jadikan PJ' }}
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Status Badge -->
                                    <div class="flex items-center gap-2 flex-wrap">
                                        @if($status === 'hadir')
                                            <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-emerald-600">
                                                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                                <span>Hadir (Terverifikasi)</span>
                                            </span>
                                        @elseif($status === 'menunggu_verifikasi')
                                            <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-amber-600">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                                <span>Menunggu Verifikasi PJ</span>
                                            </span>
                                        @elseif($status === 'izin')
                                            <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-sky-600">
                                                <span class="w-1.5 h-1.5 rounded-full bg-sky-500"></span>
                                                <span>Izin</span>
                                            </span>
                                        @elseif($status === 'sakit')
                                            <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-amber-600">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                                <span>Sakit</span>
                                            </span>
                                        @elseif($status === 'belum_waktunya')
                                            <span class="inline-flex items-center gap-1.5 text-xs font-medium text-neutral-400">
                                                <span class="w-1.5 h-1.5 rounded-full bg-neutral-300"></span>
                                                <span>Belum Waktunya ({{ $schedule->day }})</span>
                                            </span>
                                        @elseif($status === 'belum_absen')
                                            <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-amber-600">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                                <span>Belum Piket / Absen</span>
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-rose-600">
                                                <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                                <span>Alpa (Denda Rp 5.000)</span>
                                            </span>
                                        @endif


                                        @if(Auth::user()->role === 'admin')
                                            <form action="{{ route('duty-members.destroy', $member->id) }}" method="POST" onsubmit="return confirm('Keluarkan siswa ini dari jadwal piket?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" title="Hapus anggota" class="w-7 h-7 rounded-lg text-neutral-400 hover:text-rose-600 hover:bg-rose-50 flex items-center justify-center transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>

                                <!-- Bukti Piket Detail (jika sudah diupload) -->
                                @if($attendance && $attendance->proof_image)
                                    <div class="flex items-center gap-3 p-3 rounded-xl bg-neutral-50/80 border border-neutral-200/60">
                                        <a href="{{ asset('storage/' . $attendance->proof_image) }}" target="_blank" class="shrink-0 relative group">
                                            <img src="{{ asset('storage/' . $attendance->proof_image) }}" alt="Bukti" class="w-12 h-12 object-cover rounded-lg border border-neutral-300">
                                            <span class="absolute inset-0 flex items-center justify-center bg-black/40 text-white text-[9px] font-bold rounded-lg opacity-0 group-hover:opacity-100 transition-opacity">Buka</span>
                                        </a>
                                        <div class="text-xs space-y-0.5 flex-1">
                                            <p class="text-neutral-700 italic">"{{ $attendance->proof_note ?? 'Bukti kebersihan area piket.' }}"</p>
                                            <span class="text-[11px] text-neutral-400 block">
                                                Diunggah: {{ $attendance->recorded_at?->format('H:i') ?? '-' }} WIB
                                                @if($attendance->verifiedBy)
                                                    • Diverifikasi: <strong class="text-emerald-700">{{ $attendance->verifiedBy->name }}</strong>
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                @endif

                                <!-- Action Buttons: Verifikasi oleh PJ / Pembimbing -->
                                @if($canVerify && $member->user_id !== Auth::id())
                                    <div x-data="{ showOverride: false }" class="pt-1">
                                        @if($status === 'menunggu_verifikasi')
                                            <!-- Tombol Verifikasi Aktif jika belum diputuskan -->
                                            <div class="flex items-center gap-2 flex-wrap">
                                                <span class="text-[11px] font-medium text-neutral-500">Tindakan PJ / Pembimbing:</span>
                                                <form action="{{ route('attendances.verify', $member->id) }}" method="POST" class="inline-flex gap-1.5">
                                                    @csrf
                                                    <button type="submit" name="action" value="approve"
                                                            class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold shadow-xs transition-colors">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                                        <span>Setujui (Hadir)</span>
                                                    </button>
                                                    <button type="submit" name="action" value="reject"
                                                            onclick="return confirm('Tolak piket siswa ini karena belum bersih? Status akan menjadi ALPA (Denda Rp 5.000).')"
                                                            class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-700 text-xs font-semibold border border-rose-200 transition-colors">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                                        <span>Tolak (Alpa / Denda)</span>
                                                    </button>
                                                </form>
                                            </div>
                                        @elseif($status === 'belum_waktunya')
                                            <div class="text-[11px] text-neutral-400 italic">
                                                Jadwal belum berlangsung (Pelaksanaan: {{ $schedule->day }}, {{ $schedule->date->format('d M Y') }}). Absensi dibuka pada hari H.
                                            </div>
                                        @elseif($status === 'belum_absen')
                                            <div class="text-[11px] text-amber-700 bg-amber-50/60 px-2 py-1 rounded-md border border-amber-200/50 inline-flex items-center gap-1.5">
                                                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                <span>Menunggu siswa melaksanakan piket &amp; mengunggah bukti foto hari ini.</span>
                                            </div>
                                        @else
                                            <!-- Jika sudah diputuskan: Sembunyikan tombol, tampilkan status & opsi ubah keputusan -->
                                            <div class="flex items-center gap-3 text-xs">
                                                <div class="flex items-center gap-1.5 text-neutral-500 text-[11px]">
                                                    <span class="w-1.5 h-1.5 rounded-full {{ $status === 'hadir' ? 'bg-emerald-500' : ($status === 'izin' || $status === 'sakit' ? 'bg-sky-500' : 'bg-rose-500') }}"></span>
                                                    <span>Keputusan tersimpan: <strong class="{{ $status === 'hadir' ? 'text-emerald-700' : ($status === 'izin' || $status === 'sakit' ? 'text-sky-700' : 'text-rose-700') }}">
                                                        @if($status === 'hadir')
                                                            Disetujui (Hadir)
                                                        @elseif($status === 'izin')
                                                            Izin
                                                        @elseif($status === 'sakit')
                                                            Sakit
                                                        @else
                                                            Ditolak (Alpa / Denda Rp 5.000)
                                                        @endif
                                                    </strong></span>
                                                </div>
                                                <button type="button" @click="showOverride = !showOverride" class="text-[10px] text-neutral-400 hover:text-neutral-700 underline transition-colors">
                                                    <span x-text="showOverride ? 'Tutup' : 'Ubah Keputusan'"></span>
                                                </button>
                                            </div>

                                            <div x-show="showOverride" x-cloak class="mt-2 p-2 rounded-xl bg-neutral-50 border border-neutral-200 flex items-center gap-2">
                                                <span class="text-[11px] text-neutral-500">Ganti status ke:</span>
                                                <form action="{{ route('attendances.verify', $member->id) }}" method="POST" class="inline-flex gap-1.5">
                                                    @csrf
                                                    <button type="submit" name="action" value="approve" class="px-2.5 py-1 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-[11px] font-semibold transition-colors">
                                                        Setujui (Hadir)
                                                    </button>
                                                    <button type="submit" name="action" value="reject" class="px-2.5 py-1 rounded-lg bg-rose-600 hover:bg-rose-700 text-white text-[11px] font-semibold transition-colors">
                                                        Tolak (Alpa / Denda)
                                                    </button>
                                                </form>
                                            </div>
                                        @endif

                                    </div>
                                @endif

                                <!-- Admin Manual Override -->
                                @if(Auth::user()->role === 'admin')
                                    <div class="pt-1 flex items-center gap-1.5">
                                        <span class="text-[10px] text-neutral-400">Ubah Manual:</span>
                                        <form action="{{ route('attendances.update', $member->id) }}" method="POST" class="flex items-center gap-1 p-0.5 rounded-lg bg-neutral-100 text-[11px]">
                                            @csrf
                                            <button type="submit" name="status" value="hadir" class="px-2 py-0.5 rounded {{ $status === 'hadir' ? 'bg-emerald-600 text-white font-semibold' : 'text-neutral-600 hover:text-neutral-900' }}">Hadir</button>
                                            <button type="submit" name="status" value="izin" class="px-2 py-0.5 rounded {{ $status === 'izin' ? 'bg-sky-600 text-white font-semibold' : 'text-neutral-600 hover:text-neutral-900' }}">Izin</button>
                                            <button type="submit" name="status" value="sakit" class="px-2 py-0.5 rounded {{ $status === 'sakit' ? 'bg-amber-600 text-white font-semibold' : 'text-neutral-600 hover:text-neutral-900' }}">Sakit</button>
                                            <button type="submit" name="status" value="alpa" class="px-2 py-0.5 rounded {{ $status === 'alpa' ? 'bg-rose-600 text-white font-semibold' : 'text-neutral-600 hover:text-neutral-900' }}">Alpa</button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="py-6 text-center text-xs text-neutral-400">
                                Belum ada siswa yang ditugaskan pada jadwal ini.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Right Column: Status & Add Member -->
            <div class="space-y-5">
                <!-- Status Pelaksanaan -->
                <div class="bg-white p-5 rounded-2xl border border-neutral-200/80 shadow-xs space-y-3">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-neutral-500">Status Pelaksanaan</h3>

                    @if(Auth::user()->role === 'admin')
                        <form action="{{ route('schedules.status', $schedule->id) }}" method="POST" class="space-y-2">
                            @csrf
                            <button type="submit" name="status" value="belum_dilakukan"
                                    class="w-full p-2.5 rounded-xl border text-left flex items-center justify-between text-xs font-medium transition-colors {{ $schedule->status === 'belum_dilakukan' ? 'bg-neutral-900 text-white font-semibold' : 'border-neutral-200 text-neutral-700 hover:bg-neutral-50' }}">
                                <span>Belum Dilakukan</span>
                                @if($schedule->status === 'belum_dilakukan') ✓ @endif
                            </button>

                            <button type="submit" name="status" value="sedang_berlangsung"
                                    class="w-full p-2.5 rounded-xl border text-left flex items-center justify-between text-xs font-medium transition-colors {{ $schedule->status === 'sedang_berlangsung' ? 'bg-amber-600 text-white font-semibold' : 'border-neutral-200 text-neutral-700 hover:bg-neutral-50' }}">
                                <span>Sedang Berlangsung</span>
                                @if($schedule->status === 'sedang_berlangsung') ✓ @endif
                            </button>

                            <button type="submit" name="status" value="selesai"
                                    class="w-full p-2.5 rounded-xl border text-left flex items-center justify-between text-xs font-medium transition-colors {{ $schedule->status === 'selesai' ? 'bg-emerald-600 text-white font-semibold' : 'border-neutral-200 text-neutral-700 hover:bg-neutral-50' }}">
                                <span>Selesai Bersih</span>
                                @if($schedule->status === 'selesai') ✓ @endif
                            </button>
                        </form>
                    @else
                        <div class="p-3 rounded-xl bg-neutral-50 border border-neutral-200 text-xs text-neutral-700 font-medium">
                            Status saat ini: <strong class="capitalize">{{ str_replace('_', ' ', $schedule->status) }}</strong>
                        </div>
                    @endif
                </div>

                <!-- Add Student Form (Admin Only) -->
                @if(Auth::user()->role === 'admin')
                    <div class="bg-white p-5 rounded-2xl border border-neutral-200/80 shadow-xs space-y-3">
                        <div>
                            <h3 class="text-xs font-bold uppercase tracking-wider text-neutral-500">Tambah Anggota</h3>
                            <p class="text-[11px] text-neutral-400">Pilih siswa yang belum bertugas</p>
                        </div>

                        <form action="{{ route('duty-members.store', $schedule->id) }}" method="POST" class="space-y-3">
                            @csrf
                            <select name="user_id" required class="w-full px-3 py-2 rounded-xl border border-neutral-200 text-xs text-neutral-800 bg-white focus:border-[#217C5B] focus:ring-0">
                                <option value="">-- Pilih Siswa --</option>
                                @forelse($availableStudents as $student)
                                    <option value="{{ $student->id }}">{{ $student->name }}</option>
                                @empty
                                    <option value="" disabled>Semua siswa sudah ditugaskan</option>
                                @endforelse
                            </select>

                            <button type="submit" class="w-full py-2 bg-neutral-900 hover:bg-black text-white text-xs font-semibold rounded-xl transition-colors">
                                Tambah ke Jadwal
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
