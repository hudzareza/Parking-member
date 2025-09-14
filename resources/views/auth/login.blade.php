<x-guest-layout>
    <h2>Masuk ke LOTUS Parking</h2>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4 text-sm text-green-600" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email -->
        <div>
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
            <x-input-error :messages="$errors->get('email')" class="text-sm text-red-500 mt-1" />
        </div>

        <!-- Password -->
        <div>
            <label for="password">Password</label>
            <input id="password" type="password" name="password" required autocomplete="current-password">
            <x-input-error :messages="$errors->get('password')" class="text-sm text-red-500 mt-1" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-3 mb-3">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" name="remember" class="mr-2">
                <span class="text-sm text-gray-700">Ingat saya</span>
            </label>
        </div>

        <div>
            <button type="submit" class="login-button">Login</button>
        </div>

        <div class="link">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}">
                    Lupa password?
                </a>
            @endif
        </div>
    </form>
</x-guest-layout>
