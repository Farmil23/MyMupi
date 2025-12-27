<x-guest-layout>
    <x-auth-card>

        <x-slot name="logo">
            <a href="{{ route('home') }}" class="inline-flex items-center justify-center">
                <div class="rounded-2xl border border-cinema3-navy/10 bg-white shadow-md p-3">
                    <x-application-logo class="h-14 w-14 object-contain" />
                </div>
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <div class="mb-6 text-center">
            <h1 class="text-2xl font-semibold text-cinema3-navy">Create Your Account</h1>
            <p class="mt-1 text-sm text-cinema3-navy/60">Join MyMupi and book movies faster.</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-label for="name" value="Name" />
                <x-input id="name" class="block mt-1 w-full"
                         type="text" name="name" :value="old('name')" required autofocus />
            </div>

            <!-- Email -->
            <div class="mt-4">
                <x-label for="email" value="Email" />
                <x-input id="email" class="block mt-1 w-full"
                         type="email" name="email" :value="old('email')" required />
            </div>

            <!-- Password (with eye) -->
            <div class="mt-4" x-data="{ showPassword: false }">
                <x-label for="password" value="Password" />

                <div class="relative mt-1">
                    <x-input id="password" class="block w-full pr-12"
                             x-bind:type="showPassword ? 'text' : 'password'"
                             name="password" required autocomplete="new-password" />

                    <button type="button"
                            @click="showPassword = !showPassword"
                            class="absolute inset-y-0 right-0 flex items-center pr-3 text-cinema3-navy/50 hover:text-cinema3-navy"
                            aria-label="Toggle password visibility">
                        <span x-show="!showPassword">👁️</span>
                        <span x-show="showPassword" style="display:none;">🙈</span>
                    </button>
                </div>
            </div>

            <!-- Confirm Password (with eye) -->
            <div class="mt-4" x-data="{ showConfirm: false }">
                <x-label for="password_confirmation" value="Confirm Password" />

                <div class="relative mt-1">
                    <x-input id="password_confirmation" class="block w-full pr-12"
                             x-bind:type="showConfirm ? 'text' : 'password'"
                             name="password_confirmation" required />

                    <button type="button"
                            @click="showConfirm = !showConfirm"
                            class="absolute inset-y-0 right-0 flex items-center pr-3 text-cinema3-navy/50 hover:text-cinema3-navy"
                            aria-label="Toggle confirm password visibility">
                        <span x-show="!showConfirm">👁️</span>
                        <span x-show="showConfirm" style="display:none;">🙈</span>
                    </button>
                </div>
            </div>

            <!-- Button -->
            <div class="mt-6">
                <x-button class="w-full justify-center py-3 text-base">
                    Register
                </x-button>
            </div>

            <p class="mt-4 text-center text-xs text-cinema3-navy/50">
                By creating an account, you agree to our Terms & Privacy Policy.
            </p>

            <!-- Sign in link -->
            <p class="mt-6 text-center text-sm text-cinema3-navy/70">
                Already have an account?
                <a href="{{ route('login') }}" class="font-semibold text-cinema3-gold hover:text-cinema3-goldDark underline">
                    Sign in
                </a>
            </p>
        </form>
    </x-auth-card>
</x-guest-layout>
