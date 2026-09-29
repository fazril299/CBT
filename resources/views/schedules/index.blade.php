<x-app-layout>
    <div class="space-y-5">
        <!-- Header & Filter Bar (Notion Style) -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-5 rounded-xl border border-[#EBEBEA]">
            <div>
                <h1 class="text-xl font-bold text-[#37352F] tracking-tight">
                    Jadwal Piket Rayon Cisarua 5
                </h1>
                <p class="text-xs text-[#787774] mt-0.5">
                    Daftar pembagian tugas Piket WC & Piket Rayon khusus Rayon Cisarua 5
                </p>
            </div>

            <!-- Filter Tabs & Create Button -->
            <div class="flex flex-wrap items-center gap-2.5">
                <div class="flex flex-wrap p-1 rounded-lg bg-[#F7F7F5] border border-[#EBEBEA] text-xs font-medium gap-1">
                    <a href="{{ route('schedules.index', ['filter' => 'all']) }}"
                       class="px-2.5 py-1 rounded-md transition-colors {{ ($filter ?? 'all') === 'all' ? 'bg-white text-[#37352F] font-semibold border border-[#EBEBEA]' : 'text-[#787774] hover:text-[#37352F]' }}">
                        Semua ({{ $totalAll ?? count($schedules) }})
                    </a>

                    <a href="{{ route('schedules.index', ['filter' => 'piket_wc']) }}"
                       class="px-2.5 py-1 rounded-md transition-colors {{ ($filter ?? '') === 'piket_wc' ? 'bg-white text-[#37352F] font-semibold border border-[#EBEBEA]' : 'text-[#787774] hover:text-[#37352F]' }}">
                        Piket WC ({{ $totalWc ?? 0 }})
                    </a>

                    <a href="{{ route('schedules.index', ['filter' => 'piket_rayon']) }}"
                       class="px-2.5 py-1 rounded-md transition-colors {{ ($filter ?? '') === 'piket_rayon' ? 'bg-white text-[#37352F] font-semibold border border-[#EBEBEA]' : 'text-[#787774] hover:text-[#37352F]' }}">
                        Piket Rayon ({{ $totalRayon ?? 0 }})
                    </a>

                    <a href="{{ route('schedules.index', ['filter' => 'my']) }}"
                       class="px-2.5 py-1 rounded-md transition-colors {{ ($filter ?? '') === 'my' ? 'bg-white text-[#37352F] font-semibold border border-[#EBEBEA]' : 'text-[#787774] hover:text-[#37352F]' }}">
                        Jadwal Saya
                        @if(isset($totalMy) && $totalMy > 0)
                            <span class="text-[10px] ml-0.5">({{ $totalMy }})</span>
                        @endif
                    </a>
                </div>

                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('schedules.create') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-md bg-[#2F2E2B] hover:bg-[#191919] text-white text-xs font-medium transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                        <span>Buat Jadwal</span>
                    </a>
                @endif
            </div>
        </div>

        <!-- Success Toast -->
        @if(session('success'))
            <div class="p-3.5 rounded-lg bg-[#F7F7F5] border border-[#EBEBEA] text-[#37352F] text-xs font-medium flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Schedule Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse ($schedules as $schedule)
                @php
                    $isMySchedule = $schedule->dutyMembers->contains('user_id', Auth::id());
                @endphp
                <div class="p-5 bg-white rounded-xl border border-[#EBEBEA] hover:border-[#D3D3D0] transition-colors flex flex-col justify-between">
                    <div>
                        <div class="flex items-start justify-between gap-3 pb-3 border-b border-[#EBEBEA]">
                            <div>
                                <div class="flex items-center gap-2 mb-1">
                                    @if($schedule->piket_type === 'piket_wc')
                                        <span class="inline-flex items-center gap-1.5 text-xs font-medium text-sky-700">
                                            <span class="w-1.5 h-1.5 rounded-full bg-sky-500"></span>
                                            Piket WC
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 text-xs font-medium text-purple-700">
                                            <span class="w-1.5 h-1.5 rounded-full bg-purple-500"></span>
                                            Piket Rayon
                                        </span>
                                    @endif

                                    @if($isMySchedule)
                                        <span class="text-[11px] font-medium text-[#787774]">
                                            • Tugas Anda
                                        </span>
                                    @endif
                                </div>


                                <h2 class="text-sm font-semibold text-[#37352F] leading-snug">
                                    {{ $schedule->location ?? $schedule->day }}
                                </h2>
                            </div>

                            <div>
                                @if($schedule->status === 'selesai')
                                    <span class="inline-flex items-center gap-1 text-xs font-semibold text-emerald-600">
                                        <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                        <span>Selesai</span>
                                    </span>
                                @elseif($schedule->status === 'sedang_berlangsung')
                                    <span class="inline-flex items-center gap-1.5 text-xs font-medium text-amber-600">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                        <span>Berlangsung</span>
                                    </span>
                                @else
                                    <span class="text-xs font-medium text-[#9B9A97]">
                                        Belum
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Date & Time -->
                        <div class="py-3 text-xs text-[#787774] space-y-2">
                            <div class="flex items-center gap-1.5">
                                <span class="font-medium text-[#37352F]">{{ $schedule->day }}, {{ date('d M Y', strtotime($schedule->date)) }}</span>
                                <span>•</span>
                                <span class="text-[#787774]">{{ substr($schedule->time, 0, 5) }} WIB</span>
                            </div>

                            <div class="pt-1">
                                <div class="text-[11px] font-medium text-[#787774] mb-1.5 flex items-center justify-between">
                                    <span>Petugas ({{ $schedule->dutyMembers->count() }}):</span>
                                </div>
                                <div class="flex flex-wrap gap-1.5">
                                    @forelse($schedule->dutyMembers as $m)
                                        <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-md text-[11px] leading-relaxed transition-colors {{ $m->is_pj ? 'bg-[#EFEFED] text-[#2F2E2B] font-semibold border border-[#DCDCDA]' : 'bg-[#F7F7F5] text-[#4A4945] font-normal border border-[#EBEBEA]' }}">
                                            <span>{{ $m->user->name }}</span>
                                            @if($m->is_pj)
                                                <span class="px-1 py-[1px] rounded bg-[#37352F] text-white text-[8.5px] font-bold tracking-wider uppercase leading-none">PJ</span>
                                            @endif
                                        </span>
                                    @empty
                                        <span class="text-xs text-[#9B9A97] italic">Belum ada anggota</span>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Action -->
                    <div class="pt-3 border-t border-[#EBEBEA] flex items-center justify-between">
                        <span class="text-[11px] text-[#9B9A97]">Verifikasi &amp; Absensi</span>
                        <a href="{{ route('schedules.show', $schedule->id) }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-md bg-[#2F2E2B] hover:bg-[#191919] text-white text-xs font-medium transition-colors">
                            <span>Buka Detail</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full p-12 text-center bg-white rounded-xl border border-[#EBEBEA] text-[#9B9A97] text-xs">
                    Tidak ada jadwal piket yang ditemukan.
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
