<x-guest-layout>
    <x-auth-card>

        <x-slot name="logo">
            <a href="{{ route('home') }}" class="inline-flex items-center justify-center">
                <div class="rounded-2xl border border-cinema3-navy/10 bg-white shadow-md p-3">
                    <x-application-logo class="h-14 w-14 object-contain" />
                </div>
            </a>
        </x-slot>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <div class="mb-6 text-center">
            <h1 class="text-2xl font-semibold text-cinema3-navy">Welcome Back</h1>
            <p class="mt-1 text-sm text-cinema3-navy/60">Sign in to continue.</p>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div>
                <x-label for="email" value="Email" />
                <x-input id="email" class="block mt-1 w-full"
                         type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <!-- Password (with eye) -->
            <div class="mt-4" x-data="{ showPassword: false }">
                <x-label for="password" value="Password" />

                <div class="relative mt-1">
                    <x-input id="password" class="block w-full pr-12"
                             x-bind:type="showPassword ? 'text' : 'password'"
                             name="password" required autocomplete="current-password" />

                    <button type="button"
                            @click="showPassword = !showPassword"
                            class="absolute inset-y-0 right-0 flex items-center pr-3 text-cinema3-navy/50 hover:text-cinema3-navy"
                            aria-label="Toggle password visibility">
                        <span x-show="!showPassword">👁️</span>
                        <span x-show="showPassword" style="display:none;">🙈</span>
                    </button>
                </div>
            </div>

            <!-- Remember Me + Forgot -->
            <div class="mt-4 flex items-center justify-between">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox"
                           class="rounded border-gray-300 text-cinema3-gold shadow-sm focus:ring focus:ring-cinema3-gold/30"
                           name="remember">
                    <span class="ml-2 text-sm text-cinema3-navy/70">Remember me</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="text-sm font-medium text-cinema3-navy/70 hover:text-cinema3-navy underline"
                       href="{{ route('password.request') }}">
                        Forgot your password?
                    </a>
                @endif
            </div>

            <!-- Button -->
            <div class="mt-6">
                <x-button class="w-full justify-center py-3 text-base">
                    Log In
                </x-button>
            </div>

            <!-- Create account link -->
            @if (Route::has('register'))
                <p class="mt-6 text-center text-sm text-cinema3-navy/70">
                    Don’t have an account?
                    <a href="{{ route('register') }}" class="font-semibold text-cinema3-gold hover:text-cinema3-goldDark underline">
                        Create one!
                    </a>
                </p>
            @endif
        </form>
    </x-auth-card>
</x-guest-layout>
