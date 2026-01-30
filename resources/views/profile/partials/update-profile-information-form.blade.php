<section>
    <header class="mb-6">
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full rounded-xl border-slate-300 focus:border-red-500 focus:ring-red-500" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full rounded-xl border-slate-300 focus:border-red-500 focus:ring-red-500" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>
                {{-- Input NIM --}}
        <div>
            <x-input-label for="nim" :value="__('NIM')" />
            <x-text-input id="nim" name="nim" type="text" class="mt-1 block w-full rounded-xl border-slate-300 focus:border-red-500 focus:ring-red-500" :value="old('nim', $user->studentProfile->nim ?? '')" required />
            <x-input-error class="mt-2" :messages="$errors->get('nim')" />
        </div>

        {{-- Input Universitas --}}
        <div class="mt-4">
            <x-input-label for="university" :value="__('Asal Kampus')" />
            <x-text-input id="university" name="university" type="text" class="mt-1 block w-full rounded-xl border-slate-300 focus:border-red-500 focus:ring-red-500" :value="old('university', $user->studentProfile->university ?? '')" required />
            <x-input-error class="mt-2" :messages="$errors->get('university')" />
        </div>

        {{-- Input Jurusan --}}
        <div class="mt-4">
            <x-input-label for="major" :value="__('Jurusan')" />
            <x-text-input id="major" name="major" type="text" class="mt-1 block w-full rounded-xl border-slate-300 focus:border-red-500 focus:ring-red-500" :value="old('major', $user->studentProfile->major ?? '')" required />
            <x-input-error class="mt-2" :messages="$errors->get('major')" />
        </div>

        {{-- Input No HP --}}
        <div class="mt-4">
            <x-input-label for="phone_number" :value="__('Nomor HP / WhatsApp')" />
            <x-text-input id="phone_number" name="phone_number" type="text" class="mt-1 block w-full rounded-xl border-slate-300 focus:border-red-500 focus:ring-red-500" :value="old('phone_number', $user->studentProfile->phone_number ?? '')" />
        </div>

        {{-- Input Alamat --}}
        <div class="mt-4">
            <x-input-label for="address" :value="__('Alamat Domisili')" />
            <textarea id="address" name="address" class="border-slate-300 focus:border-red-500 focus:ring-red-500 rounded-xl shadow-sm mt-1 block w-full" rows="3">{{ old('address', $user->studentProfile->address ?? '') }}</textarea>
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="inline-flex items-center px-6 py-2 bg-gradient-to-r from-red-600 to-red-500 border border-transparent rounded-xl font-bold text-xs text-white uppercase tracking-wider hover:from-red-500 hover:to-red-400 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md shadow-red-200">
                {{ __('Save Changes') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
