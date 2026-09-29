<x-app-layout>
    <div class="space-y-6">
        <!-- Header & Action -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-neutral-200/80 shadow-xs">
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-neutral-900 tracking-tight">
                    Checklist &amp; Kegiatan Piket
                </h1>
                <p class="text-xs md:text-sm text-neutral-500 mt-0.5">
                    Daftar panduan dan checklist pembersihan area WC dan Rayon
                </p>
            </div>

            <a href="{{ route('activities.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-[#217C5B] hover:bg-[#1A684C] text-white text-xs font-semibold shadow-xs transition-colors shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                <span>Buat Tugas Baru</span>
            </a>
        </div>

        <!-- Success Toast -->
        @if(session('success'))
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-medium flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Activities Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @forelse ($activities as $act)
                <div class="p-5 bg-white rounded-2xl border transition-colors {{ $act->status ? 'bg-neutral-50/50 border-neutral-200/60' : 'border-neutral-200/80 hover:border-neutral-300' }} flex flex-col justify-between">
                    <div class="flex items-start gap-3.5">
                        <form action="{{ route('activities.toggle', $act->id) }}" method="POST" class="mt-0.5">
                            @csrf
                            <button type="submit" title="Tandai selesai / belum" class="w-5 h-5 rounded-md border flex items-center justify-center transition-colors {{ $act->status ? 'bg-emerald-600 border-emerald-600 text-white' : 'border-neutral-300 bg-white' }}">
                                @if($act->status)
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                @endif
                            </button>
                        </form>

                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between gap-2">
                                <h2 class="text-sm font-semibold text-neutral-900 truncate {{ $act->status ? 'line-through text-neutral-400' : '' }}">
                                    {{ $act->title }}
                                </h2>

                                @if($act->status)
                                    <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-emerald-600">
                                        <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                        <span>Selesai</span>
                                    </span>
                                @else
                                    <span class="text-[11px] font-medium text-amber-600">
                                        Tertunda
                                    </span>
                                @endif
                            </div>

                            <p class="text-xs text-neutral-500 mt-1 leading-relaxed">
                                {{ $act->description }}
                            </p>

                            <div class="flex items-center justify-between pt-3 text-[11px] text-neutral-400">
                                <span>Target: {{ date('d M, H:i', strtotime($act->target_date)) }} WIB</span>

                                @if(Auth::user()->role === 'admin' || Auth::id() === $act->user_id)
                                    <form action="{{ route('activities.destroy', $act->id) }}" method="POST" onsubmit="return confirm('Hapus kegiatan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-neutral-400 hover:text-rose-600 text-[11px] font-medium transition-colors">
                                            Hapus
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full p-12 text-center bg-white rounded-2xl border border-neutral-200 text-neutral-400 text-xs">
                    Belum ada kegiatan piket yang dibuat.
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
