<x-app-layout>
    <div style="max-width: 960px; margin: 0 auto; padding: 32px 24px 64px 24px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Helvetica, Arial, sans-serif;">
        <!-- Top Navigation -->
        <div style="margin-bottom: 24px;">
            <a href="{{ route('dashboard') }}" 
               style="display: inline-flex; align-items: center; gap: 6px; font-size: 13px; color: #787774; text-decoration: none; font-weight: 500; transition: color 0.15s ease;"
               onmouseover="this.style.color='#37352f';" 
               onmouseout="this.style.color='#787774';">
                <svg style="width: 15px; height: 15px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
                <span>Dashboard</span>
            </a>
        </div>

        <!-- Header: Account (Lebih Besar & Lega) -->
        <div style="margin-bottom: 36px;">
            <h1 style="font-size: 30px; font-weight: 700; color: #191919; letter-spacing: -0.025em; margin: 0 0 6px 0;">Akun Saya</h1>
            <p style="font-size: 14px; color: #787774; margin: 0;">Kelola profil, info login, dan keamanan akun kamu</p>
        </div>

        <!-- Flash Success Notifications -->
        @if (session('status') === 'profile-updated')
            <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 4000)"
                 style="margin-bottom: 28px; padding: 12px 16px; border-radius: 8px; background: #edf5fd; border: 1px solid #d0e4f7; color: #1e60a5; font-size: 13px; font-weight: 500; display: flex; align-items: center; justify-content: space-between;">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <svg style="width: 18px; height: 18px; color: #2383e2; flex-shrink: 0;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Profil berhasil diperbarui.</span>
                </div>
                <button type="button" @click="show = false" style="background: none; border: none; color: #1e60a5; cursor: pointer; font-size: 18px; line-height: 1;">&times;</button>
            </div>
        @endif

        @if (session('status') === 'password-updated')
            <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 5000)"
                 style="margin-bottom: 28px; padding: 12px 16px; border-radius: 8px; background: #edf5fd; border: 1px solid #d0e4f7; color: #1e60a5; font-size: 13px; font-weight: 500; display: flex; align-items: center; justify-content: space-between;">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <svg style="width: 18px; height: 18px; color: #2383e2; flex-shrink: 0;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Password berhasil diubah! Jangan lupa pake password baru ya pas login lagi.</span>
                </div>
                <button type="button" @click="show = false" style="background: none; border: none; color: #1e60a5; cursor: pointer; font-size: 18px; line-height: 1;">&times;</button>
            </div>
        @endif

        <!-- ================= SECTION: Profile ================= -->
        <div style="margin-bottom: 44px;">
            <h2 style="font-size: 15px; font-weight: 600; color: #191919; margin: 0 0 12px 0;">Profil</h2>
            <div style="height: 1px; background-color: #ededeb; margin-bottom: 24px;"></div>

            <!-- Avatar & Preferred Name Form -->
            <div style="display: flex; align-items: flex-start; gap: 20px; margin-bottom: 12px;">
                <!-- Circular Avatar (Locked dimensions: 58px) -->
                <div style="width: 58px; height: 58px; min-width: 58px; min-height: 58px; max-width: 58px; max-height: 58px; border-radius: 50%; aspect-ratio: 1/1; background: #262626; color: #ffffff; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 1px 3px rgba(0,0,0,0.12); overflow: hidden;">
                    <svg style="width: 36px; height: 36px; color: #eaeaea;" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/>
                    </svg>
                </div>

                <!-- Preferred name input (Wider & more comfortable) -->
                <div style="flex: 1; max-width: 480px;">
                    <form method="post" action="{{ route('profile.update') }}">
                        @csrf
                        @method('patch')
                        <input type="hidden" name="email" value="{{ old('email', $user->email) }}">
                        
                        <label for="name" style="display: block; font-size: 12px; color: #787774; font-weight: 500; margin-bottom: 6px;">
                            Nama lengkap / Panggilan
                        </label>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required
                                   style="flex: 1; height: 36px; padding: 6px 12px; font-size: 13px; color: #37352f; background: #fafafa; border: 1px solid #dfdfde; border-radius: 6px; outline: none; transition: border-color 0.15s, box-shadow 0.15s;"
                                   onfocus="this.style.borderColor='#2383e2'; this.style.boxShadow='0 0 0 1px #2383e2'; this.style.background='#ffffff';"
                                   onblur="this.style.borderColor='#dfdfde'; this.style.boxShadow='none'; this.style.background='#fafafa';" />
                            <button type="submit" 
                                    style="height: 36px; padding: 0 16px; font-size: 13px; font-weight: 500; color: #37352f; background: #ffffff; border: 1px solid #d3d3d1; border-radius: 6px; cursor: pointer; white-space: nowrap; transition: background 0.15s;"
                                    onmouseover="this.style.background='#efefed';"
                                    onmouseout="this.style.background='#ffffff';">
                                Simpan
                            </button>
                        </div>
                        @error('name')
                            <div style="font-size: 12px; color: #e11d48; margin-top: 4px;">{{ $message }}</div>
                        @enderror
                    </form>
                </div>
            </div>

            <!-- Notion Faces Link -->
            <div style="margin: 12px 0 24px 0;">
                <span style="font-size: 13px; color: #2383e2; cursor: pointer;"
                      onmouseover="this.style.textDecoration='underline';"
                      onmouseout="this.style.textDecoration='none';">
                    Atur foto profil biar lebih kece
                </span>
            </div>

            <!-- Light Blue Callout Banner (Persis Gambar Notion, Full Width) -->
            <div style="background-color: #edf5fd; border: 1px solid #d0e4f7; border-radius: 8px; padding: 14px 18px; display: flex; align-items: center; gap: 14px; margin-bottom: 14px;">
                <div style="color: #2383e2; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <svg style="width: 22px; height: 22px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-6.75-2.25l6.75-6.75 6.75 6.75v7.5a1.5 1.5 0 01-1.5 1.5h-10.5a1.5 1.5 0 01-1.5-1.5v-7.5z" />
                    </svg>
                </div>
                <span style="font-size: 13.5px; color: #1e60a5; font-weight: 500;">
                    Tambahin passkey biar loginnya gampang, cepat, dan anti ribet ngetik password
                </span>
            </div>

            <!-- Solid Blue Add passkey Button -->
            <div>
                <button type="button" 
                        style="background-color: #2383e2; color: #ffffff; font-size: 13px; font-weight: 500; padding: 7px 16px; border-radius: 6px; border: none; cursor: pointer; box-shadow: 0 1px 2px rgba(0,0,0,0.08); transition: background 0.15s;"
                        onmouseover="this.style.background='#1a73ca';"
                        onmouseout="this.style.background='#2383e2';">
                    Tambah passkey
                </button>
            </div>
        </div>

        <!-- ================= SECTION: Account Security ================= -->
        <div id="password-section" x-data="{ 
            openPassword: {{ $errors->updatePassword->any() ? 'true' : 'false' }},
            openEmail: {{ $errors->has('email') ? 'true' : 'false' }}
        }">
            <h2 style="font-size: 15px; font-weight: 600; color: #191919; margin: 0 0 12px 0;">Keamanan Akun</h2>
            <div style="height: 1px; background-color: #ededeb; margin-bottom: 8px;"></div>

            <!-- Row 1: Email -->
            <div style="padding: 16px 0; border-bottom: 1px solid #ededeb;">
                <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px;">
                    <div>
                        <div style="font-size: 14px; font-weight: 600; color: #191919; margin-bottom: 3px;">Email</div>
                        <div style="font-size: 13px; color: #787774;">{{ $user->email }}</div>
                    </div>
                    <button type="button" @click="openEmail = !openEmail"
                            style="height: 32px; padding: 0 14px; font-size: 13px; font-weight: 500; color: #37352f; background: #ffffff; border: 1px solid #d3d3d1; border-radius: 6px; cursor: pointer; white-space: nowrap; transition: background 0.15s;"
                            onmouseover="this.style.background='#efefed';"
                            onmouseout="this.style.background='#ffffff';">
                        <span x-text="openEmail ? 'Tutup' : 'Ubah email'">Ubah email</span>
                    </button>
                </div>

                <!-- Expandable Email Edit Form -->
                <div x-show="openEmail" x-transition x-cloak 
                     style="margin-top: 16px; padding: 18px 22px; background: #fbfbfa; border: 1px solid #edece9; border-radius: 8px;">
                    <form method="post" action="{{ route('profile.update') }}">
                        @csrf
                        @method('patch')
                        <input type="hidden" name="name" value="{{ old('name', $user->name) }}">
                        <div style="margin-bottom: 14px;">
                            <label for="email" style="display: block; font-size: 12px; font-weight: 500; color: #787774; margin-bottom: 6px;">Alamat Email Baru</label>
                            <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required
                                   style="width: 100%; max-width: 400px; height: 36px; padding: 6px 12px; font-size: 13px; color: #37352f; background: #ffffff; border: 1px solid #dfdfde; border-radius: 6px; outline: none;"
                                   onfocus="this.style.borderColor='#2383e2'; this.style.boxShadow='0 0 0 1px #2383e2';"
                                   onblur="this.style.borderColor='#dfdfde'; this.style.boxShadow='none';" />
                            @error('email')
                                <div style="font-size: 12px; color: #e11d48; margin-top: 4px;">{{ $message }}</div>
                            @enderror
                        </div>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <button type="submit" 
                                    style="height: 34px; padding: 0 16px; font-size: 13px; font-weight: 500; color: #ffffff; background: #2383e2; border: none; border-radius: 6px; cursor: pointer;">
                                Simpan Email
                            </button>
                            <button type="button" @click="openEmail = false" 
                                    style="height: 34px; padding: 0 12px; font-size: 13px; font-weight: 500; color: #787774; background: transparent; border: none; border-radius: 6px; cursor: pointer;">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Row 2: Passkeys (Matching Notion UI Screenshot) -->
            <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px; padding: 16px 0; border-bottom: 1px solid #ededeb;">
                <div>
                    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 3px;">
                        <span style="font-size: 14px; font-weight: 600; color: #191919;">Passkey</span>
                        <span style="font-size: 11px; font-weight: 500; background: #edf5fd; color: #2383e2; padding: 2px 7px; border-radius: 4px;">Sangat Disarankan</span>
                    </div>
                    <div style="font-size: 13px; color: #787774;">Bisa login cepat pakai sidik jari atau Face ID tanpa ribet ngetik</div>
                </div>
                <button type="button"
                        style="height: 32px; padding: 0 14px; font-size: 13px; font-weight: 500; color: #37352f; background: #ffffff; border: 1px solid #d3d3d1; border-radius: 6px; cursor: pointer; white-space: nowrap; transition: background 0.15s;"
                        onmouseover="this.style.background='#efefed';"
                        onmouseout="this.style.background='#ffffff';">
                    Tambah passkey
                </button>
            </div>

            <!-- Row 3: Two-step verification (Matching Notion UI Screenshot) -->
            <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px; padding: 16px 0; border-bottom: 1px solid #ededeb;">
                <div>
                    <div style="font-size: 14px; font-weight: 600; color: #191919; margin-bottom: 3px;">Verifikasi 2 Langkah</div>
                    <div style="font-size: 13px; color: #787774;">Tambahin keamanan ekstra biar akunmu nggak gampang ke-hack</div>
                </div>
                <button type="button" disabled
                        style="height: 32px; padding: 0 14px; font-size: 13px; font-weight: 500; color: #b4b4b2; background: #ffffff; border: 1px solid #e5e5e3; border-radius: 6px; cursor: default; white-space: nowrap;">
                    Tambah verifikasi
                </button>
            </div>

            <!-- Row 4: Password -->
            <div style="padding: 16px 0;">
                <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px;">
                    <div>
                        <div style="font-size: 14px; font-weight: 600; color: #191919; margin-bottom: 3px;">Password</div>
                        <div style="font-size: 13px; color: #787774;">Atur atau ganti password untuk akun kamu</div>
                    </div>
                    <button type="button" @click="openPassword = !openPassword"
                            style="height: 32px; padding: 0 14px; font-size: 13px; font-weight: 500; color: #37352f; background: #ffffff; border: 1px solid #d3d3d1; border-radius: 6px; cursor: pointer; white-space: nowrap; transition: background 0.15s;"
                            onmouseover="this.style.background='#efefed';"
                            onmouseout="this.style.background='#ffffff';">
                        <span x-text="openPassword ? 'Tutup' : 'Ganti password'">Ganti password</span>
                    </button>
                </div>

                <!-- Notion Expandable Password Change Form (Lebih Lega & Proporsional) -->
                <div x-show="openPassword" x-transition x-cloak 
                     style="margin-top: 16px; padding: 22px 24px; background: #fbfbfa; border: 1px solid #edece9; border-radius: 8px;">
                    <div style="margin-bottom: 16px;">
                        <div style="font-size: 14px; font-weight: 600; color: #191919;">Ganti password akun</div>
                        <div style="font-size: 13px; color: #787774; margin-top: 3px;">Masukin password lama kamu dan bikin password baru (minimal 8 karakter).</div>
                    </div>

                    <form method="post" action="{{ route('password.update') }}" style="max-width: 440px;">
                        @csrf
                        @method('put')

                        <!-- Current Password -->
                        <div style="margin-bottom: 14px;" x-data="{ show: false }">
                            <label for="update_password_current_password" style="display: block; font-size: 12px; font-weight: 500; color: #787774; margin-bottom: 6px;">
                                Password saat ini <span style="color: #e11d48;">*</span>
                            </label>
                            <div style="position: relative;">
                                <input id="update_password_current_password" name="current_password" :type="show ? 'text' : 'password'" required autocomplete="current-password"
                                       placeholder="Ketik password lama"
                                       style="width: 100%; height: 36px; padding: 6px 56px 6px 12px; font-size: 13px; color: #37352f; background: #ffffff; border: 1px solid #dfdfde; border-radius: 6px; outline: none; box-sizing: border-box;"
                                       onfocus="this.style.borderColor='#2383e2'; this.style.boxShadow='0 0 0 1px #2383e2';"
                                       onblur="this.style.borderColor='#dfdfde'; this.style.boxShadow='none';" />
                                <button type="button" @click="show = !show" 
                                        style="position: absolute; right: 10px; top: 9px; background: none; border: none; font-size: 12px; color: #787774; cursor: pointer; padding: 0;">
                                    <span x-text="show ? 'Tutup' : 'Lihat'">Lihat</span>
                                </button>
                            </div>
                            @if($errors->updatePassword->has('current_password'))
                                <div style="font-size: 12px; color: #e11d48; margin-top: 4px;">
                                    {{ $errors->updatePassword->first('current_password') }}
                                </div>
                            @endif
                        </div>

                        <!-- New Password -->
                        <div style="margin-bottom: 14px;" x-data="{ show: false }">
                            <label for="update_password_password" style="display: block; font-size: 12px; font-weight: 500; color: #787774; margin-bottom: 6px;">
                                Password baru <span style="color: #e11d48;">*</span>
                            </label>
                            <div style="position: relative;">
                                <input id="update_password_password" name="password" :type="show ? 'text' : 'password'" required autocomplete="new-password"
                                       placeholder="Min. 8 karakter"
                                       style="width: 100%; height: 36px; padding: 6px 56px 6px 12px; font-size: 13px; color: #37352f; background: #ffffff; border: 1px solid #dfdfde; border-radius: 6px; outline: none; box-sizing: border-box;"
                                       onfocus="this.style.borderColor='#2383e2'; this.style.boxShadow='0 0 0 1px #2383e2';"
                                       onblur="this.style.borderColor='#dfdfde'; this.style.boxShadow='none';" />
                                <button type="button" @click="show = !show" 
                                        style="position: absolute; right: 10px; top: 9px; background: none; border: none; font-size: 12px; color: #787774; cursor: pointer; padding: 0;">
                                    <span x-text="show ? 'Tutup' : 'Lihat'">Lihat</span>
                                </button>
                            </div>
                            @if($errors->updatePassword->has('password'))
                                <div style="font-size: 12px; color: #e11d48; margin-top: 4px;">
                                    {{ $errors->updatePassword->first('password') }}
                                </div>
                            @endif
                        </div>

                        <!-- Confirm Password -->
                        <div style="margin-bottom: 18px;" x-data="{ show: false }">
                            <label for="update_password_password_confirmation" style="display: block; font-size: 12px; font-weight: 500; color: #787774; margin-bottom: 6px;">
                                Ulangi password baru <span style="color: #e11d48;">*</span>
                            </label>
                            <div style="position: relative;">
                                <input id="update_password_password_confirmation" name="password_confirmation" :type="show ? 'text' : 'password'" required autocomplete="new-password"
                                       placeholder="Ketik ulang password baru"
                                       style="width: 100%; height: 36px; padding: 6px 56px 6px 12px; font-size: 13px; color: #37352f; background: #ffffff; border: 1px solid #dfdfde; border-radius: 6px; outline: none; box-sizing: border-box;"
                                       onfocus="this.style.borderColor='#2383e2'; this.style.boxShadow='0 0 0 1px #2383e2';"
                                       onblur="this.style.borderColor='#dfdfde'; this.style.boxShadow='none';" />
                                <button type="button" @click="show = !show" 
                                        style="position: absolute; right: 10px; top: 9px; background: none; border: none; font-size: 12px; color: #787774; cursor: pointer; padding: 0;">
                                    <span x-text="show ? 'Tutup' : 'Lihat'">Lihat</span>
                                </button>
                            </div>
                            @if($errors->updatePassword->has('password_confirmation'))
                                <div style="font-size: 12px; color: #e11d48; margin-top: 4px;">
                                    {{ $errors->updatePassword->first('password_confirmation') }}
                                </div>
                            @endif
                        </div>

                        <!-- Actions -->
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <button type="submit" 
                                    style="height: 36px; padding: 0 18px; font-size: 13px; font-weight: 500; color: #ffffff; background: #2383e2; border: none; border-radius: 6px; cursor: pointer; box-shadow: 0 1px 2px rgba(0,0,0,0.08); transition: background 0.15s;"
                                    onmouseover="this.style.background='#1a73ca';"
                                    onmouseout="this.style.background='#2383e2';">
                                Simpan password
                            </button>
                            <button type="button" @click="openPassword = false" 
                                    style="height: 36px; padding: 0 14px; font-size: 13px; font-weight: 500; color: #787774; background: transparent; border: none; border-radius: 6px; cursor: pointer; transition: background 0.15s, color 0.15s;"
                                    onmouseover="this.style.background='#efefed'; this.style.color='#37352f';"
                                    onmouseout="this.style.background='transparent'; this.style.color='#787774';">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
