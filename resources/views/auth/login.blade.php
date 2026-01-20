<x-guest-layout>
    <h1 class="page-title">Telkom Witel Internship</h1>

    <div class="hero-section">
        <div class="red-stripe"></div>

        <div class="content-container">
            <img src="{{ asset('images/char-male.png') }}" alt="Intern" class="char-img">

            <div class="login-wrapper">
                <x-auth-session-status class="mb-4 text-white" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-group">
                        <label for="email">Username / Email</label>
                        <input type="email" id="email" name="email" 
                               class="custom-input" 
                               value="{{ old('email') }}" 
                               required autofocus autocomplete="username">
                        
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-yellow-300 text-xs" />
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" 
                               class="custom-input" 
                               required autocomplete="current-password">
                        
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-yellow-300 text-xs" />
                    </div>

                    <div class="forgot-password flex justify-between items-center">
                        <label for="remember_me" class="inline-flex items-center" style="margin-bottom:0;">
                            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                            <span class="ms-2 text-xs text-white">{{ __('Remember me') }}</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}">Lupa password?</a>
                        @endif
                    </div>

                    <button type="submit" class="login-btn">
                        LOGIN
                    </button>
                </form>
            </div>

            <img src="{{ asset('images/char-female.png') }}" alt="Intern" class="char-img">
        </div>
    </div>
</x-guest-layout>