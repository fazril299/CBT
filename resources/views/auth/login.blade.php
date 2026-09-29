<x-guest-layout>
    {{-- Card Container --}}
    <div class="relative w-full max-w-4xl min-h-[540px] md:h-[580px] bg-white rounded-[32px] md:rounded-[36px] shadow-2xl overflow-hidden flex flex-col md:flex-row items-center border border-white/80"
         style="box-shadow: 0 25px 60px -15px rgba(215, 155, 110, 0.35);">

        {{-- Left Accent Strip (Forest Green) --}}
        <div class="absolute left-0 top-0 bottom-0 w-5 sm:w-6 bg-[#217C5B] z-20 rounded-l-[32px] md:rounded-l-[36px]"></div>

        {{-- Left Area: Peeking Character --}}
        <div class="relative w-full md:w-[48%] h-56 md:h-full flex items-end justify-start overflow-hidden pointer-events-none select-none">
            {{-- Character Image: Anchored to bottom and gripping the green bar --}}
            <img src="{{ asset('images/login-character.png') }}"
                 alt="Karakter Piket"
                 class="absolute bottom-0 -left-1 sm:left-1 md:left-2 w-64 sm:w-72 md:w-[380px] max-h-[95%] object-contain object-bottom drop-shadow-sm z-10" />
        </div>

        {{-- Right Area: Login Form --}}
        <div class="w-full md:w-[52%] h-full flex flex-col justify-center px-8 sm:px-12 md:px-14 py-8 md:py-10 z-20">
            <div class="max-w-[340px] w-full mx-auto">

                {{-- Header --}}
                <div class="text-center mb-6">
                    <h1 class="text-3xl font-extrabold text-neutral-900 tracking-tight">Log in</h1>
                    <p class="text-xs text-neutral-400 mt-2 leading-relaxed">
                        Halo! Selamat datang di Sistem Piket Rayon Cisarua 5. Masuk untuk mengecek jadwal & absensimu!
                    </p>
                </div>

                {{-- Session Status --}}
                <x-auth-session-status class="mb-4 text-xs text-center text-[#217C5B] font-medium" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-3.5">
                    @csrf

                    {{-- Email Input --}}
                    <div>
                        <input id="email" type="email" name="email"
                               value="{{ old('email') }}"
                               required autofocus autocomplete="username"
                               placeholder="Email"
                               class="w-full px-5 py-3 rounded-full text-xs sm:text-sm bg-[#EFF1F4] border-0 text-neutral-800 placeholder-neutral-400 focus:outline-none focus:ring-2 focus:ring-[#217C5B]/40 focus:bg-white transition-all shadow-inner/10" />
                        <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs text-red-500 pl-3" />
                    </div>

                    {{-- Password Input --}}
                    <div x-data="{ show: false }">
                        <div class="relative">
                            <input id="password"
                                   :type="show ? 'text' : 'password'"
                                   name="password"
                                   required autocomplete="current-password"
                                   placeholder="Password"
                                   class="w-full px-5 py-3 rounded-full text-xs sm:text-sm bg-[#EFF1F4] border-0 text-neutral-800 placeholder-neutral-400 focus:outline-none focus:ring-2 focus:ring-[#217C5B]/40 focus:bg-white transition-all pr-12" />
                            <button type="button" @click="show = !show"
                                    class="absolute right-4 top-1/2 -translate-y-1/2 text-neutral-400 hover:text-neutral-600 transition-colors">
                                <svg x-show="!show" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <svg x-show="show" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="display:none;">
                                    <path d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                </svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs text-red-500 pl-3" />
                    </div>

                    {{-- Remember Me --}}
                    <div class="flex items-center px-2 pt-0.5">
                        <label class="flex items-center gap-2 cursor-pointer select-none">
                            <input type="checkbox" name="remember" class="w-3.5 h-3.5 rounded border-neutral-300 text-[#217C5B] focus:ring-0">
                            <span class="text-[11px] text-neutral-400">Ingat saya</span>
                        </label>
                    </div>

                    {{-- Submit Button (Forest Green Pill) --}}
                    <button type="submit"
                            class="w-full py-3.5 rounded-full text-xs sm:text-sm font-semibold text-white bg-[#217C5B] hover:bg-[#1A684C] transition-all shadow-md shadow-[#217C5B]/20 active:scale-[0.99] mt-2">
                        Let's start!
                    </button>
                </form>


                {{-- Sign up link --}}
                <p class="text-center text-[11px] text-neutral-400 mt-5">
                    Don't have an account?
                    <a href="{{ route('register') }}"
                       class="text-[#217C5B] font-semibold hover:underline ml-0.5">
                        Sign up
                    </a>
                </p>

            </div>
        </div>

    </div>
</x-guest-layout>
