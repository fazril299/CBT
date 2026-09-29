<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Jadwal Piket') }} - Rayon Cisarua 5</title>

    <!-- Google Fonts: Inter (Notion Style) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            color: #37352F;
        }
    </style>
</head>
<body class="bg-white text-[#37352F] antialiased min-h-screen flex flex-col selection:bg-[#E8E8E6] selection:text-[#37352F]">

    <div class="flex min-h-screen w-full">
        <!-- ================= NOTION-STYLE DESKTOP SIDEBAR ================= -->
        <aside class="hidden md:flex flex-col w-64 bg-[#F7F7F5] border-r border-[#EBEBEA] shrink-0 sticky top-0 h-screen justify-between p-4 z-40 select-none">
            <div class="space-y-5">
                <!-- App Brand -->
                <a href="{{ route('dashboard') }}" class="block px-2.5 py-1.5 rounded-lg hover:bg-[#EFEFED] transition-colors">
                    <span class="text-xs font-semibold text-[#37352F] block leading-tight">Piket Cisarua 5</span>
                    <span class="text-[10px] text-[#787774] font-normal block">TP 2026/2027</span>
                </a>

                <!-- Navigation Links -->
                <nav class="space-y-0.5">
                    <div class="text-[10px] font-semibold text-[#9B9A97] uppercase tracking-wider px-2.5 pt-2 pb-1">
                        Menu
                    </div>

                    <!-- Dashboard -->
                    <a href="{{ route('dashboard') }}" 
                       class="flex items-center gap-2.5 px-2.5 py-1.5 rounded-md text-xs transition-colors {{ request()->routeIs('dashboard') ? 'bg-[#EFEFED] text-[#37352F] font-semibold' : 'text-[#5A5A57] hover:bg-[#EFEFED] hover:text-[#37352F] font-medium' }}">
                        <svg class="w-4 h-4 shrink-0 text-[#787774]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                        </svg>
                        <span>Dashboard</span>
                    </a>

                    <!-- Semua Jadwal -->
                    <a href="{{ route('schedules.index') }}" 
                       class="flex items-center gap-2.5 px-2.5 py-1.5 rounded-md text-xs transition-colors {{ request()->routeIs('schedules.index') && !request()->has('filter') ? 'bg-[#EFEFED] text-[#37352F] font-semibold' : 'text-[#5A5A57] hover:bg-[#EFEFED] hover:text-[#37352F] font-medium' }}">
                        <svg class="w-4 h-4 shrink-0 text-[#787774]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                        </svg>
                        <span>Semua Jadwal</span>
                    </a>

                    <div class="pt-3 pb-1 text-[10px] font-semibold text-[#9B9A97] uppercase tracking-wider px-2.5">
                        Kategori Piket
                    </div>

                    <!-- Piket WC -->
                    <a href="{{ route('schedules.index', ['filter' => 'piket_wc']) }}" 
                       class="flex items-center justify-between px-2.5 py-1.5 rounded-md text-xs transition-colors {{ request()->query('filter') === 'piket_wc' ? 'bg-[#EFEFED] text-[#37352F] font-semibold' : 'text-[#5A5A57] hover:bg-[#EFEFED] hover:text-[#37352F] font-medium' }}">
                        <div class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 shrink-0 text-[#787774]" fill="currentColor" viewBox="0 0 24 24">
                                <circle cx="6" cy="3.5" r="2"/>
                                <path d="M4 7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v6h-.6v6.5a1 1 0 1 1-2 0V14H4V7z"/>
                                <line x1="12" y1="2" x2="12" y2="22" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                <circle cx="18" cy="3.5" r="2"/>
                                <path d="M16.2 7a1 1 0 0 1 .8-.8h2a1 1 0 0 1 .8.8l1.6 5.5a.8.8 0 0 1-.76 1h-1.24v6a1 1 0 1 1-2 0v-6h-1.24a.8.8 0 0 1-.76-1L16.2 7z"/>
                            </svg>
                            <span>Piket WC</span>
                        </div>
                        <span class="text-[10px] px-1.5 py-0.5 rounded font-normal bg-[#EAEAE8] text-[#787774]">WC</span>
                    </a>

                    <!-- Piket Rayon -->
                    <a href="{{ route('schedules.index', ['filter' => 'piket_rayon']) }}" 
                       class="flex items-center justify-between px-2.5 py-1.5 rounded-md text-xs transition-colors {{ request()->query('filter') === 'piket_rayon' ? 'bg-[#EFEFED] text-[#37352F] font-semibold' : 'text-[#5A5A57] hover:bg-[#EFEFED] hover:text-[#37352F] font-medium' }}">
                        <div class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 shrink-0 text-[#787774]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.75c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21" />
                            </svg>
                            <span>Piket Rayon</span>
                        </div>
                        <span class="text-[10px] px-1.5 py-0.5 rounded font-normal bg-[#EAEAE8] text-[#787774]">Rayon</span>
                    </a>

                    <div class="pt-3 pb-1 text-[10px] font-semibold text-[#9B9A97] uppercase tracking-wider px-2.5">
                        Tugas &amp; Akun
                    </div>

                    <!-- Kegiatan Piket -->
                    <a href="{{ route('activities.index') }}" 
                       class="flex items-center gap-2.5 px-2.5 py-1.5 rounded-md text-xs transition-colors {{ request()->routeIs('activities.*') ? 'bg-[#EFEFED] text-[#37352F] font-semibold' : 'text-[#5A5A57] hover:bg-[#EFEFED] hover:text-[#37352F] font-medium' }}">
                        <svg class="w-4 h-4 shrink-0 text-[#787774]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Checklist Tugas</span>
                    </a>

                    <!-- Ubah Password -->
                    <a href="{{ route('profile.edit') }}" 
                       class="flex items-center gap-2.5 px-2.5 py-1.5 rounded-md text-xs transition-colors {{ request()->routeIs('profile.edit') ? 'bg-[#EFEFED] text-[#37352F] font-semibold' : 'text-[#5A5A57] hover:bg-[#EFEFED] hover:text-[#37352F] font-medium' }}">
                        <svg class="w-4 h-4 shrink-0 text-[#787774]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                        </svg>
                        <span>Ubah Password</span>
                    </a>
                    
                    @if(Auth::user()->role === 'admin')
                    <!-- Admin Dashboard -->
                    <a href="{{ url('/admin') }}" 
                       class="flex items-center gap-2.5 px-2.5 py-1.5 rounded-md text-xs transition-colors text-[#5A5A57] hover:bg-[#EFEFED] hover:text-[#37352F] font-medium">
                        <svg class="w-4 h-4 shrink-0 text-[#787774]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75" />
                        </svg>
                        <span>Admin Panel</span>
                    </a>
                    @endif
                </nav>
            </div>

            <!-- Illustration Flush to Bottom-Left (Transparent, No Background) -->
            <div class="mt-auto -mx-4 -mb-3 overflow-hidden pointer-events-none select-none flex justify-start">
                <img src="{{ asset('images/sidebar-illustration.png') }}"
                     alt="Siswa Rayon Cisarua 5"
                     class="w-[85%] max-w-[220px] h-auto object-contain object-bottom" />
            </div>

            <!-- Bottom User & Logout (Matching Mockup) -->
            <div class="pt-3 border-t border-[#EBEBEA] relative z-10 bg-[#F7F7F5] space-y-1">
                <a href="{{ route('profile.edit') }}" class="flex items-center justify-between px-2.5 py-1.5 rounded-lg hover:bg-[#EFEFED] transition-colors group">
                    <div class="flex items-center gap-2.5 overflow-hidden">
                        <div class="w-8 h-8 rounded-lg bg-[#EAEAE8] text-[#37352F] flex items-center justify-center font-bold text-xs uppercase shrink-0">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div class="overflow-hidden">
                            <div class="text-xs font-semibold text-[#37352F] truncate leading-tight">
                                {{ Auth::user()->name }}
                            </div>
                            <span class="text-[10px] text-[#9B9A97] block">Siswa • Profil</span>
                        </div>
                    </div>
                    <svg class="w-4 h-4 text-[#9B9A97] shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
                    </svg>
                </a>

                <form method="POST" action="{{ route('logout') }}" class="px-1">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-2 px-2 py-1 rounded text-[11px] font-medium text-[#9B9A97] hover:text-rose-600 transition-colors">
                        <svg class="w-3.5 h-3.5 text-[#9B9A97]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                        </svg>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- ================= MAIN CONTENT WRAPPER ================= -->
        <div class="flex-1 flex flex-col min-w-0 bg-white">
            <!-- Mobile Top Header -->
            <header class="md:hidden bg-white border-b border-[#EBEBEA] px-4 py-3 flex items-center justify-between sticky top-0 z-40">
                <a href="{{ route('profile.edit') }}" class="flex items-center gap-2">
                    <div class="w-7 h-7 rounded-md bg-[#EAEAE8] text-[#37352F] flex items-center justify-center font-bold text-xs uppercase">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div>
                        <h2 class="text-xs font-bold text-[#37352F] leading-tight">Piket Cisarua 5</h2>
                        <span class="text-[10px] text-[#787774]">{{ Auth::user()->name }}</span>
                    </div>
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-8 h-8 rounded-md text-[#787774] hover:text-[#37352F] hover:bg-[#F7F7F5] flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                        </svg>
                    </button>
                </form>
            </header>

            <!-- Desktop Topbar (Notion Style) -->
            <div class="hidden md:flex items-center justify-between px-8 py-3 bg-white border-b border-[#EBEBEA] sticky top-0 z-30">
                <div class="flex items-center gap-2 text-xs text-[#787774]">
                    <span class="hover:text-[#37352F] cursor-pointer">Jadwal Piket</span>
                    <span>/</span>
                    <span class="font-medium text-[#37352F] capitalize">{{ request()->segment(1) ?: 'Dashboard' }}</span>
                </div>

                <div class="flex items-center gap-3">
                    <!-- Search Bar with shortcut key -->
                    <div class="relative flex items-center">
                        <svg class="w-3.5 h-3.5 text-[#9B9A97] absolute left-3 pointer-events-none" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                        </svg>
                        <input type="text" placeholder="Cari..." 
                               class="pl-8 pr-7 py-1 rounded-md border border-[#EBEBEA] text-xs bg-[#F7F7F5] w-40 focus:w-56 focus:bg-white focus:border-[#37352F] focus:ring-0 transition-all text-[#37352F] placeholder-[#9B9A97]" />
                        <span class="absolute right-2 text-[10px] text-[#9B9A97] border border-[#EBEBEA] rounded px-1 bg-white font-mono">/</span>
                    </div>

                    <span class="text-xs text-[#787774] hidden lg:inline">
                        {{ now()->translatedFormat('l, d F Y') }}
                    </span>

                    @if(Auth::user()->role === 'admin')
                        <!-- Primary Action Button: Notion Black Button -->
                        <a href="{{ route('schedules.create') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-md bg-[#2F2E2B] hover:bg-[#191919] text-white text-xs font-medium transition-colors shadow-none">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                            <span>Buat Jadwal</span>
                        </a>
                    @endif
                </div>
            </div>

            <!-- Page Content -->
            <main class="flex-1 p-5 sm:p-7 md:p-9 max-w-5xl w-full mx-auto relative bg-white">
                <!-- Global Success Toast Notification -->
                @if (session('success') || session('status') === 'password-updated')
                    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 6000)" x-show="show"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 -translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"
                         class="mb-6 p-3 rounded-lg bg-[#F7F7F5] border border-[#EBEBEA] text-[#37352F] flex items-center justify-between gap-3">
                        <div class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                            </svg>
                            <p class="text-xs text-[#37352F]">
                                {{ session('success') ?? 'Kata sandi akun Anda telah berhasil diperbarui!' }}
                            </p>
                        </div>
                        <button type="button" @click="show = false" class="text-[#9B9A97] hover:text-[#37352F] p-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                @endif

                {{ $slot }}
            </main>

            <!-- Footer -->
            <footer class="hidden md:block py-4 px-8 border-t border-[#EBEBEA] bg-white text-xs text-[#9B9A97]">
                <div class="flex items-center justify-between">
                    <span>Sistem Jadwal Piket — Rayon Cisarua 5</span>
                    <span>© {{ date('Y') }}</span>
                </div>
            </footer>
        </div>
    </div>

    <!-- ================= MOBILE BOTTOM NAVIGATION ================= -->
    <nav class="md:hidden bg-[#F7F7F5] border-t border-[#EBEBEA] px-4 py-2 select-none sticky bottom-0 z-50">
        <div class="flex items-center justify-around">
            <a href="{{ route('dashboard') }}" class="flex flex-col items-center gap-1 py-1 {{ request()->routeIs('dashboard') ? 'text-[#37352F] font-bold' : 'text-[#9B9A97] font-medium' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" /></svg>
                <span class="text-[10px]">Home</span>
            </a>
            <a href="{{ route('schedules.index', ['filter' => 'piket_wc']) }}" class="flex flex-col items-center gap-1 py-1 {{ request()->query('filter') === 'piket_wc' ? 'text-[#37352F] font-bold' : 'text-[#9B9A97] font-medium' }}">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <circle cx="6" cy="3.5" r="2"/>
                    <path d="M4 7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v6h-.6v6.5a1 1 0 1 1-2 0V14H4V7z"/>
                    <line x1="12" y1="2" x2="12" y2="22" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                    <circle cx="18" cy="3.5" r="2"/>
                    <path d="M16.2 7a1 1 0 0 1 .8-.8h2a1 1 0 0 1 .8.8l1.6 5.5a.8.8 0 0 1-.76 1h-1.24v6a1 1 0 1 1-2 0v-6h-1.24a.8.8 0 0 1-.76-1L16.2 7z"/>
                </svg>
                <span class="text-[10px]">Piket WC</span>
            </a>
            <a href="{{ route('schedules.index', ['filter' => 'piket_rayon']) }}" class="flex flex-col items-center gap-1 py-1 {{ request()->query('filter') === 'piket_rayon' ? 'text-[#37352F] font-bold' : 'text-[#9B9A97] font-medium' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.75c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21" /></svg>
                <span class="text-[10px]">Rayon</span>
            </a>
            <a href="{{ route('activities.index') }}" class="flex flex-col items-center gap-1 py-1 {{ request()->routeIs('activities.*') ? 'text-[#37352F] font-bold' : 'text-[#9B9A97] font-medium' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <span class="text-[10px]">Tugas</span>
            </a>
            <a href="{{ route('profile.edit') }}" class="flex flex-col items-center gap-1 py-1 {{ request()->routeIs('profile.edit') ? 'text-[#37352F] font-bold' : 'text-[#9B9A97] font-medium' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" /></svg>
                <span class="text-[10px]">Profil</span>
            </a>
        </div>
    </nav>

</body>
</html>
