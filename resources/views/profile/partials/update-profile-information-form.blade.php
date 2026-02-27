<section class="p-8 sm:p-10">
    <header class="mb-10 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-black text-slate-800 dark:text-slate-200 tracking-tight">
                {{ __('Informasi Profil') }}
            </h2>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400 font-medium">
                {{ __("Kelola informasi dasar dan detail akun Anda.") }}
            </p>
        </div>
        <div class="hidden sm:block">
            <div class="w-12 h-12 bg-red-50 dark:bg-red-500/10 rounded-2xl flex items-center justify-center text-red-600 dark:text-red-400 shadow-sm border border-red-100 dark:border-red-500/20 transition-colors duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                </svg>
            </div>
        </div>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form id="profile-update-form" method="post" action="{{ route('profile.update') }}" class="space-y-10" enctype="multipart/form-data">
        @csrf
        @method('patch')

        {{-- Section: Personal Details --}}
        <div class="space-y-6">
            <div class="flex items-center gap-3 px-1">
                <span class="w-1.5 h-6 bg-red-600 rounded-full"></span>
                <h3 class="text-sm font-black text-slate-800 dark:text-slate-200 uppercase tracking-widest">Informasi Dasar</h3>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <x-input-label for="name" :value="__('Nama Lengkap')" class="text-slate-600 dark:text-slate-400 font-bold ml-1 mb-2" />
                    <input id="name" name="name" type="text" class="w-full rounded-[1.25rem] border-slate-200 dark:border-slate-800 focus:border-red-500 focus:ring-red-500 dark:bg-slate-950 shadow-sm transition-all py-3 px-5 text-slate-700 dark:text-slate-200 font-medium" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <div>
                    <x-input-label for="email" :value="__('Email Address')" class="text-slate-600 dark:text-slate-400 font-bold ml-1 mb-2" />
                    <input id="email" name="email" type="email" class="w-full rounded-[1.25rem] border-slate-200 dark:border-slate-800 focus:border-red-500 focus:ring-red-500 dark:bg-slate-950 shadow-sm transition-all py-3 px-5 text-slate-700 dark:text-slate-200 font-medium bg-slate-50/50 dark:bg-slate-950" value="{{ old('email', $user->email) }}" required autocomplete="username" />
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />

                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                        <div class="mt-2 p-3 bg-amber-50 dark:bg-amber-500/10 rounded-xl border border-amber-100 dark:border-amber-500/20">
                            <p class="text-[11px] text-amber-800 dark:text-amber-400 font-medium">
                                {{ __('Email Anda belum diverifikasi.') }}
                                <button form="send-verification" class="underline font-bold hover:text-amber-900 dark:hover:text-amber-300 focus:outline-none transition-colors ml-1">
                                    {{ __('Klik di sini untuk mengirim ulang.') }}
                                </button>
                            </p>
                            @if (session('status') === 'verification-link-sent')
                                <p class="mt-1 font-bold text-[10px] text-emerald-600 uppercase tracking-wider">
                                    {{ __('Link verifikasi baru telah dikirim.') }}
                                </p>
                            @endif
                        </div>
                    @endif
                </div>

                <div>
                    @php
                        $phone = '';
                        if($user->role === 'student') $phone = $user->studentProfile->phone_number ?? '';
                        elseif($user->role === 'mentor') $phone = $user->mentorProfile->phone_number ?? '';
                    @endphp
                    <x-input-label for="phone_number" :value="__('Nomor WhatsApp')" class="text-slate-600 dark:text-slate-400 font-bold ml-1 mb-2" />
                    <input id="phone_number" name="phone_number" type="text" class="w-full rounded-[1.25rem] border-slate-200 dark:border-slate-800 focus:border-red-500 focus:ring-red-500 dark:bg-slate-950 shadow-sm transition-all py-3 px-5 text-slate-700 dark:text-slate-200 font-medium" value="{{ old('phone_number', $phone) }}" placeholder="08xxxxxxxxxx" />
                    <x-input-error class="mt-2" :messages="$errors->get('phone_number')" />
                </div>
            </div>
        </div>

        {{-- Section: Role Specific Details --}}
        <div class="space-y-6">
            <div class="flex items-center gap-3 px-1">
                <span class="w-1.5 h-6 bg-red-600 rounded-full"></span>
                <h3 class="text-sm font-black text-slate-800 dark:text-slate-200 uppercase tracking-widest">Detail {{ ucfirst($user->role) }}</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @if($user->role === 'student')
                    <div>
                        <x-input-label for="nim" :value="__('NIM / Nomor Induk')" class="text-slate-600 dark:text-slate-400 font-bold ml-1 mb-2" />
                        <input id="nim" name="nim" type="text" class="w-full rounded-[1.25rem] border-slate-200 dark:border-slate-800 focus:border-red-500 focus:ring-red-500 dark:bg-slate-950 shadow-sm transition-all py-3 px-5 text-slate-700 dark:text-slate-200 font-medium" value="{{ old('nim', $user->studentProfile->nim ?? '') }}" required />
                        <x-input-error class="mt-2" :messages="$errors->get('nim')" />
                    </div>

                    <div>
                        <x-input-label for="university" :value="__('Asal Kampus / Sekolah')" class="text-slate-600 dark:text-slate-400 font-bold ml-1 mb-2" />
                        <input id="university" name="university" type="text" class="w-full rounded-[1.25rem] border-slate-200 dark:border-slate-800 focus:border-red-500 focus:ring-red-500 dark:bg-slate-950 shadow-sm transition-all py-3 px-5 text-slate-700 dark:text-slate-200 font-medium" value="{{ old('university', $user->studentProfile->university ?? '') }}" required />
                        <x-input-error class="mt-2" :messages="$errors->get('university')" />
                    </div>

                    <div class="md:col-span-2">
                        <x-input-label for="major" :value="__('Program Studi / Jurusan')" class="text-slate-600 dark:text-slate-400 font-bold ml-1 mb-2" />
                        <input id="major" name="major" type="text" class="w-full rounded-[1.25rem] border-slate-200 dark:border-slate-800 focus:border-red-500 focus:ring-red-500 dark:bg-slate-950 shadow-sm transition-all py-3 px-5 text-slate-700 dark:text-slate-200 font-medium" value="{{ old('major', $user->studentProfile->major ?? '') }}" required />
                        <x-input-error class="mt-2" :messages="$errors->get('major')" />
                    </div>

                    <div class="md:col-span-2">
                        <x-input-label for="address" :value="__('Alamat Domisili')" class="text-slate-600 dark:text-slate-400 font-bold ml-1 mb-2" />
                        <textarea id="address" name="address" rows="3" class="w-full rounded-[1.25rem] border-slate-200 dark:border-slate-800 focus:border-red-500 focus:ring-red-500 dark:bg-slate-950 shadow-sm transition-all py-4 px-5 text-slate-700 dark:text-slate-200 font-medium">{{ old('address', $user->studentProfile->address ?? '') }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('address')" />
                    </div>
                @endif

                @if($user->role === 'mentor')
                    <div>
                        <x-input-label for="nik" :value="__('NIK / NIK Komersial')" class="text-slate-600 dark:text-slate-400 font-bold ml-1 mb-2" />
                        <input id="nik" name="nik" type="text" class="w-full rounded-[1.25rem] border-slate-200 dark:border-slate-800 focus:border-red-500 focus:ring-red-500 dark:bg-slate-950 shadow-sm transition-all py-3 px-5 text-slate-700 dark:text-slate-200 font-medium" value="{{ old('nik', $user->mentorProfile->nik ?? '') }}" required />
                        <x-input-error class="mt-2" :messages="$errors->get('nik')" />
                    </div>

                    <div>
                        <x-input-label for="position" :value="__('Jabatan saat ini')" class="text-slate-600 dark:text-slate-400 font-bold ml-1 mb-2" />
                        <input id="position" name="position" type="text" class="w-full rounded-[1.25rem] border-slate-200 dark:border-slate-800 focus:border-red-500 focus:ring-red-500 dark:bg-slate-950 shadow-sm transition-all py-3 px-5 text-slate-700 dark:text-slate-200 font-medium" value="{{ old('position', $user->mentorProfile->position ?? '') }}" required />
                        <x-input-error class="mt-2" :messages="$errors->get('position')" />
                    </div>
                @endif
            </div>
        </div>

        <div class="pt-6 border-t border-slate-50 dark:border-slate-800 flex items-center gap-6 transition-colors duration-300">
            <button type="submit" class="px-10 py-4 bg-gradient-to-r from-red-600 to-red-500 hover:from-red-500 hover:to-red-400 text-white rounded-2xl font-black text-sm uppercase tracking-widest transition-all active:scale-95 shadow-xl shadow-red-200 dark:shadow-red-900/40">
                {{ __('Simpan Perubahan') }}
            </button>

            @if (session('status') === 'profile-updated')
                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)" 
                    class="flex items-center gap-2 text-emerald-600 dark:text-emerald-400">
                    <div class="w-5 h-5 bg-emerald-100 dark:bg-emerald-500/20 rounded-full flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-3 h-3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                        </svg>
                    </div>
                    <span class="text-xs font-bold uppercase tracking-wider">{{ __('Berhasil Disimpan') }}</span>
                </div>
            @endif
        </div>
    </form>
</section>
