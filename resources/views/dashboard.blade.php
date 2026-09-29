<x-app-layout>
    @php
        $user = Auth::user();
        $isAdmin = $user->role === 'admin';
        
        $totalSchedules = \App\Models\Schedule::count();
        $totalPiketWc = \App\Models\Schedule::where('piket_type', 'piket_wc')->count();
        $totalPiketRayon = \App\Models\Schedule::where('piket_type', 'piket_rayon')->count();
        $totalStudents = \App\Models\User::where('role', 'siswa')->count();
        $completedSchedules = \App\Models\Schedule::where('status', 'selesai')->count();
        $pendingActivities = \App\Models\Activity::where('status', false)->count();
        
        // Next personal schedule for logged in student
        $myNextSchedule = \App\Models\Schedule::with('dutyMembers.user')
            ->whereHas('dutyMembers', function($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->where('date', '>=', now()->toDateString())
            ->orderBy('date', 'asc')
            ->first();

        // Active schedules list
        $recentSchedules = \App\Models\Schedule::with('dutyMembers.user')->orderBy('date', 'asc')->take(6)->get();

        // Activities
        $activityList = \App\Models\Activity::orderBy('status', 'asc')->orderBy('target_date', 'asc')->take(5)->get();
    @endphp

    <div class="space-y-6">
      
        <div class="bg-white p-6 md:p-7 rounded-xl border border-[#EBEBEA] flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="text-[11px] font-medium px-2 py-0.5 rounded bg-[#EFEFED] text-[#37352F]">Rayon Cisarua 5</span>
                    @if(!$isAdmin && $myNextSchedule)
                        <span class="text-[11px] font-medium px-2 py-0.5 rounded bg-[#EDF3EC] text-[#448361]">Piket: {{ $myNextSchedule->day }}</span>
                    @endif
                </div>
                <h1 class="text-2xl font-bold text-[#37352F] tracking-tight">
                    @if($isAdmin)
                        {{ $user->name }}
                    @else
                        Selamat Datang, {{ $user->name }}
                    @endif
                </h1>
                <p class="text-xs text-[#787774] mt-1.5 max-w-xl leading-relaxed">
                    @if($isAdmin)
                        Sistem manajemen pembagian tugas <strong>Piket WC</strong> &amp; <strong>Piket Rayon</strong> khusus untuk seluruh siswa <strong>Rayon Cisarua 5</strong>.
                    @elseif($myNextSchedule)
                        Tugas piket Anda berikutnya: <strong>{{ $myNextSchedule->type_label }} ({{ $myNextSchedule->location ?? $myNextSchedule->day }})</strong> pada hari {{ $myNextSchedule->day }}, {{ date('d M Y', strtotime($myNextSchedule->date)) }} pukul {{ substr($myNextSchedule->time, 0, 5) }} WIB.
                    @else
                        Belum ada tugas piket yang dijadwalkan untuk Anda di Rayon Cisarua 5.
                    @endif
                </p>
            </div>

            <div class="flex items-center gap-2 shrink-0">
                @if($isAdmin)
                    <a href="{{ route('schedules.create') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg bg-[#2F2E2B] hover:bg-[#191919] text-white text-xs font-medium transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                        <span>Buat Jadwal Baru</span>
                    </a>
                @elseif($myNextSchedule)
                    <a href="{{ route('schedules.show', $myNextSchedule->id) }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg bg-[#2F2E2B] hover:bg-[#191919] text-white text-xs font-medium transition-colors">
                        <span>Lihat Tugas Saya</span>
                    </a>
                @endif

                <a href="{{ route('activities.create') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg bg-white border border-[#E5E5E3] hover:bg-[#F7F7F5] text-[#37352F] text-xs font-medium transition-colors">
                    <span>+ Tambah Tugas</span>
                </a>
            </div>
        </div>

        <!-- ================= STATS GRID ================= -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3.5">
            <!-- Stat 1: Piket WC -->
            <a href="{{ route('schedules.index', ['filter' => 'piket_wc']) }}" class="p-4 bg-white rounded-xl border border-[#EBEBEA] hover:border-[#D3D3D0] transition-colors block">
                <div class="text-xs font-medium text-[#787774] mb-1.5">Piket WC</div>
                <div class="text-2xl font-bold text-[#37352F]">{{ $totalPiketWc }}</div>
                <div class="text-[11px] text-[#9B9A97] mt-1">Area toilet &amp; kamar mandi</div>
            </a>

            <!-- Stat 2: Piket Rayon (Kelas) -->
            <a href="{{ route('schedules.index', ['filter' => 'piket_rayon']) }}" class="p-4 bg-white rounded-xl border border-[#EBEBEA] hover:border-[#D3D3D0] transition-colors block">
                <div class="text-xs font-medium text-[#787774] mb-1.5">Piket Rayon</div>
                <div class="text-2xl font-bold text-[#37352F]">{{ $totalPiketRayon }}</div>
                <div class="text-[11px] text-[#9B9A97] mt-1">Kebersihan ruang kelas rayon</div>
            </a>

            <!-- Stat 3: Piket Selesai -->
            <div class="p-4 bg-white rounded-xl border border-[#EBEBEA]">
                <div class="text-xs font-medium text-[#787774] mb-1.5">Piket Selesai</div>
                <div class="text-2xl font-bold text-[#37352F]">{{ $completedSchedules }}</div>
                <div class="text-[11px] text-[#9B9A97] mt-1">Jadwal terlaksana</div>
            </div>

            <!-- Stat 4: Siswa Terdaftar -->
            <div class="p-4 bg-white rounded-xl border border-[#EBEBEA]">
                <div class="text-xs font-medium text-[#787774] mb-1.5">Total Siswa</div>
                <div class="text-2xl font-bold text-[#37352F]">{{ $totalStudents }}</div>
                <div class="text-[11px] text-[#9B9A97] mt-1">Personel terdaftar</div>
            </div>
        </div>

        <!-- ================= MAIN TWO-COLUMN CONTENT ================= -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
            <!-- Left Area: Monitoring Jadwal (Takes 2 Columns) -->
            <div class="lg:col-span-2 space-y-3">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-sm font-semibold text-[#37352F]">Jadwal Piket Terbaru</h2>
                        <p class="text-xs text-[#787774]">Daftar giliran tugas Piket WC dan Rayon aktif</p>
                    </div>
                    <a href="{{ route('schedules.index') }}" class="text-xs font-medium text-[#37352F] hover:underline">
                        Lihat Semua →
                    </a>
                </div>

                <div class="bg-white rounded-xl border border-[#EBEBEA] divide-y divide-[#EBEBEA] overflow-hidden">
                    @forelse($recentSchedules as $sched)
                        <div class="p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3 hover:bg-[#FBFBFA] transition-colors">
                            <div class="flex items-start sm:items-center gap-3">
                                <div class="w-9 h-9 rounded-lg bg-[#F7F7F5] border border-[#EBEBEA] text-[#37352F] flex flex-col items-center justify-center font-bold shrink-0">
                                    <span class="text-[8px] uppercase tracking-wider text-[#9B9A97]">{{ substr($sched->day, 0, 3) }}</span>
                                    <span class="text-xs font-semibold leading-none">{{ date('d', strtotime($sched->date)) }}</span>
                                </div>
                                <div class="space-y-0.5">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        @if($sched->piket_type === 'piket_wc')
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
                                        <h3 class="text-xs font-semibold text-[#37352F]">
                                            {{ $sched->location ?? $sched->day }}
                                        </h3>
                                    </div>

                                    <div class="text-[11px] text-[#787774] flex items-center gap-1.5">
                                        <span>{{ $sched->day }}, {{ date('d M Y', strtotime($sched->date)) }}</span>
                                        <span>•</span>
                                        <span>{{ substr($sched->time, 0, 5) }} WIB</span>
                                    </div>

                                    <div class="flex items-center gap-1.5 pt-1.5 flex-wrap">
                                        <span class="text-[11px] font-medium text-[#787774]">Petugas:</span>
                                        @forelse($sched->dutyMembers as $dm)
                                            <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded text-[11px] leading-tight {{ $dm->is_pj ? 'bg-[#EFEFED] text-[#2F2E2B] font-semibold border border-[#DCDCDA]' : 'bg-[#F7F7F5] text-[#4A4945] font-normal border border-[#EBEBEA]' }}">
                                                <span>{{ $dm->user->name }}</span>
                                                @if($dm->is_pj)
                                                    <span class="px-1 py-[1px] rounded bg-[#37352F] text-white text-[8px] font-bold tracking-wider uppercase leading-none">PJ</span>
                                                @endif
                                            </span>
                                        @empty
                                            <span class="text-[11px] italic text-[#9B9A97]">Belum ada anggota</span>
                                        @endforelse
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center justify-between sm:justify-end gap-3 pt-2 sm:pt-0 border-t sm:border-t-0 border-[#EBEBEA] shrink-0">
                                @if($sched->status === 'selesai')
                                    <span class="inline-flex items-center gap-1 text-xs font-semibold text-emerald-600">
                                        <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                        <span>Selesai</span>
                                    </span>
                                @elseif($sched->status === 'sedang_berlangsung')
                                    <span class="inline-flex items-center gap-1.5 text-xs font-medium text-amber-600">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                        <span>Berlangsung</span>
                                    </span>
                                @else
                                    <span class="text-xs font-medium text-[#9B9A97]">
                                        Belum
                                    </span>
                                @endif

                                <a href="{{ route('schedules.show', $sched->id) }}" class="text-xs font-medium text-[#37352F] hover:underline">
                                    Detail →
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-xs text-[#9B9A97]">
                            Belum ada jadwal piket yang dibuat.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Right Area: Checklist Tugas (Notion Action Items Style) -->
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-sm font-semibold text-[#37352F]">Checklist Tugas</h2>
                        <p class="text-xs text-[#787774]">Aktivitas pembersihan harian</p>
                    </div>
                    <a href="{{ route('activities.create') }}" class="text-xs font-medium text-[#37352F] hover:underline">
                        + Tambah
                    </a>
                </div>

                <div class="bg-white p-3.5 rounded-xl border border-[#EBEBEA] space-y-2">
                    @forelse($activityList as $act)
                        <div class="p-2.5 rounded-lg border {{ $act->status ? 'bg-[#FBFBFA] border-[#EBEBEA] opacity-60' : 'bg-white border-[#EBEBEA]' }} flex items-start gap-2.5">
                            <form action="{{ route('activities.toggle', $act->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="mt-0.5 w-4 h-4 rounded-sm border flex items-center justify-center transition-colors {{ $act->status ? 'bg-[#37352F] border-[#37352F] text-white' : 'border-[#D3D3D0] hover:border-[#37352F] bg-white' }}">
                                    @if($act->status)
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                    @endif
                                </button>
                            </form>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-xs font-medium text-[#37352F] truncate {{ $act->status ? 'line-through text-[#9B9A97]' : '' }}">
                                    {{ $act->title }}
                                </h3>
                                <p class="text-[11px] text-[#787774] truncate mt-0.5">
                                    {{ $act->description }}
                                </p>
                                <span class="text-[10px] text-[#9B9A97] block mt-1">
                                    Target: {{ date('H:i', strtotime($act->target_date)) }} WIB
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="p-6 text-center text-xs text-[#9B9A97]">
                            Belum ada tugas kebersihan.
                        </div>
                    @endforelse

                    <div class="pt-1">
                        <a href="{{ route('activities.index') }}" class="w-full py-2 rounded-md bg-[#F7F7F5] hover:bg-[#EFEFED] text-[#5A5A57] text-xs font-medium block text-center transition-colors">
                            Lihat Semua Tugas ({{ $pendingActivities }} Tertunda)
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
