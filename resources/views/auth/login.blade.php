<x-guest-layout>
    <h1 class="page-title" x-data="{
        text1: '',
        text2: '',
        cursor1: true,
        cursor2: false,
        type(text, target, callback) {
            let i = 0;
            let speed = 100; 
            let interval = setInterval(() => {
                this[target] += text.charAt(i);
                i++;
                if (i >= text.length) {
                    clearInterval(interval);
                    if (callback) callback();
                }
            }, speed);
        },
        delete(target, callback) {
            let speed = 50; 
            let interval = setInterval(() => {
                this[target] = this[target].slice(0, -1);
                if (this[target].length === 0) {
                    clearInterval(interval);
                    if (callback) callback();
                }
            }, speed);
        },
        startLoop() {
            this.text1 = '';
            this.text2 = '';
            this.cursor1 = true;
            this.cursor2 = false;
            
            this.type('Telkom Witel', 'text1', () => {
                this.cursor1 = false;
                this.cursor2 = true;
                this.type('Internship', 'text2', () => {
                   // Wait 3 seconds, then delete
                   setTimeout(() => {
                       this.delete('text2', () => {
                           this.cursor2 = false;
                           this.cursor1 = true;
                           this.delete('text1', () => {
                               // Loop again after short pause
                               setTimeout(() => { this.startLoop(); }, 500);
                           });
                       });
                   }, 3000);
                });
            });
        },
        init() {
            setTimeout(() => {
                this.startLoop();
            }, 300);
        }
    }">
        <span x-text="text1" style="min-height: 1em; display: inline-block;"></span><span x-show="cursor1" class="animate-pulse">|</span>
        <br>
        <span x-text="text2" style="min-height: 1em; display: inline-block;"></span><span x-show="cursor2" class="animate-pulse">|</span>
    </h1>

    <div class="hero-section">
        <div class="red-stripe"></div>

        <div class="content-container">
            <img src="{{ asset('images/char-female.png') }}" alt="Intern Wanita" class="char-img">

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

            <img src="{{ asset('images/char-male.png') }}" alt="Intern Pria" class="char-img">
        </div>
    </div>
</x-guest-layout>