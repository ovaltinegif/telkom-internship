<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-bold text-2xl text-slate-800 dark:text-slate-200 leading-tight">
                {{ __('Pengaturan Akun') }}
            </h2>
            <p class="text-slate-500 dark:text-slate-400 text-sm">Kelola informasi profil dan keamanan akun Anda</p>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            {{-- Profile Header Card --}}
            <div class="relative overflow-hidden bg-white dark:bg-slate-900 rounded-[3rem] border border-slate-100 dark:border-slate-800 shadow-sm transition-colors duration-300">
                <div class="absolute top-0 right-0 w-80 h-80 bg-red-500/10 dark:bg-red-500/5 rounded-full -mr-32 -mt-32 blur-[100px] animate-pulse"></div>
                <div class="absolute bottom-0 left-0 w-80 h-80 bg-slate-100/50 dark:bg-slate-950/50 rounded-full -ml-32 -mb-32 blur-[100px]"></div>
                
                <div class="relative p-8 sm:p-10 flex flex-col md:flex-row items-center gap-8">
                    <div class="shrink-0 relative group">
                        @php
                            $photoUrl = null;
                            if($user->role === 'student' && $user->studentProfile && $user->studentProfile->photo) {
                                $photoUrl = asset('storage/' . $user->studentProfile->photo);
                            } elseif($user->role === 'mentor' && $user->mentorProfile && $user->mentorProfile->photo) {
                                $photoUrl = asset('storage/' . $user->mentorProfile->photo);
                            }
                        @endphp
                        
                        <input type="file" id="photo_input" name="photo" form="profile-update-form" class="hidden" accept="image/*" onchange="if(this.files && this.files[0]) { document.getElementById('avatar-preview').src = window.URL.createObjectURL(this.files[0]); document.getElementById('avatar-preview').classList.remove('hidden'); if(document.getElementById('avatar-placeholder')) document.getElementById('avatar-placeholder').classList.add('hidden'); document.getElementById('photo-save-btn').classList.remove('hidden'); document.getElementById('photo-save-btn').classList.add('flex'); }">

                        <div class="w-36 h-36 rounded-[2.5rem] overflow-hidden border-4 border-white dark:border-slate-800 shadow-2xl rotate-3 group-hover:rotate-0 transition-all duration-500 group-hover:scale-105 bg-gradient-to-br from-slate-50 to-slate-100 dark:from-slate-800 dark:to-slate-950 flex items-center justify-center text-slate-300 dark:text-slate-700 relative cursor-pointer" onclick="document.getElementById('photo_input').click()">
                            <img id="avatar-preview" src="{{ $photoUrl ?? '' }}" class="w-full h-full object-cover z-10 {{ $photoUrl ? '' : 'hidden' }}" alt="{{ $user->name }}">
                            
                            <div id="avatar-placeholder" class="absolute inset-0 flex items-center justify-center {{ $photoUrl ? 'hidden' : '' }}">
                                <svg class="w-20 h-20" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                        </div>
                        
                        <button type="button" onclick="document.getElementById('photo_input').click()" class="absolute -top-3 -right-3 bg-gradient-to-br from-red-600 to-red-500 text-white p-3.5 rounded-[1.25rem] shadow-xl border-4 border-white dark:border-slate-900 transition-all hover:scale-110 active:scale-95 z-20 group-hover:rotate-12 group-hover:scale-110">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" />
                            </svg>
                        </button>

                        <button type="submit" id="photo-save-btn" form="profile-update-form" class="hidden absolute -bottom-5 left-1/2 -translate-x-1/2 bg-gradient-to-br from-emerald-600 to-emerald-500 text-white px-5 py-2.5 rounded-[1.25rem] shadow-xl border-4 border-white dark:border-slate-900 transition-all hover:scale-105 hover:shadow-emerald-500/30 active:scale-95 z-20 items-center justify-center gap-2 w-max animate-bounce">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                            </svg>
                            <span class="font-black text-[11px] uppercase tracking-widest">Simpan</span>
                        </button>
                    </div>

                    <div class="text-center md:text-left flex-1">
                        <div class="inline-flex items-center px-3 py-1 rounded-full bg-red-50 dark:bg-red-500/10 text-red-600 dark:text-red-400 text-[10px] font-black uppercase tracking-widest mb-3 border border-red-100 dark:border-red-500/20">
                            {{ $user->role }} Access
                        </div>
                        <h1 class="text-3xl font-black text-slate-800 dark:text-slate-200 mb-2">{{ $user->name }}</h1>
                        <div class="flex flex-wrap justify-center md:justify-start gap-4 text-slate-500 dark:text-slate-400 text-sm">
                            <div class="flex items-center gap-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                                </svg>
                                {{ $user->email }}
                            </div>
                            <div class="flex items-center gap-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                </svg>
                                Bergabung {{ $user->created_at->translatedFormat('d F Y') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-slate-900 rounded-[3rem] border border-slate-100 dark:border-slate-800 shadow-sm overflow-hidden transition-all duration-300 hover:shadow-xl dark:shadow-slate-950/50">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <div class="space-y-8">
                    <div class="bg-white dark:bg-slate-900 rounded-[3rem] border border-slate-100 dark:border-slate-800 shadow-sm overflow-hidden p-8 sm:p-10 transition-all duration-300 hover:shadow-xl dark:shadow-slate-950/50">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
