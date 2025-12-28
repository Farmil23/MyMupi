<x-guest-layout>
    <!-- Header -->
    <div class="mb-10">
        <h1 class="text-4xl font-black text-cinema3-navy tracking-tight mb-2">Create Your Account</h1>
        <p class="text-cinema3-navy/60 font-medium text-lg">Join MyMupi and book movies faster.</p>
    </div>

    <!-- Form -->
    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <!-- Name -->
        <div class="space-y-2">
            <x-label for="name" value="Full Name" class="text-cinema3-navy font-bold uppercase text-xs tracking-wider" />
            <input id="name" type="text" name="name" :value="old('name')" required autofocus
                   placeholder="e.g. Farhan Kamil"
                   class="block w-full rounded-2xl border-2 border-cinema3-navy/10 bg-white px-5 py-4 text-cinema3-navy font-bold placeholder-cinema3-navy/20 focus:border-cinema3-gold focus:ring focus:ring-cinema3-gold/20 transition-all outline-none" />
        </div>

        <!-- Email -->
        <div class="space-y-2">
            <x-label for="email" value="Email Address" class="text-cinema3-navy font-bold uppercase text-xs tracking-wider" />
            <input id="email" type="email" name="email" :value="old('email')" required
                   placeholder="name@example.com"
                   class="block w-full rounded-2xl border-2 border-cinema3-navy/10 bg-white px-5 py-4 text-cinema3-navy font-bold placeholder-cinema3-navy/20 focus:border-cinema3-gold focus:ring focus:ring-cinema3-gold/20 transition-all outline-none" />
        </div>

        <!-- Password -->
        <div class="space-y-2" x-data="{ show: false }">
            <x-label for="password" value="Password" class="text-cinema3-navy font-bold uppercase text-xs tracking-wider" />
            <div class="relative">
                <input id="password" :type="show ? 'text' : 'password'" name="password" required autocomplete="new-password"
                       placeholder="••••••••"
                       class="block w-full rounded-2xl border-2 border-cinema3-navy/10 bg-white px-5 py-4 text-cinema3-navy font-bold placeholder-cinema3-navy/20 focus:border-cinema3-gold focus:ring focus:ring-cinema3-gold/20 transition-all outline-none" />
                <button type="button" @click="show = !show" class="absolute right-5 top-1/2 -translate-y-1/2 text-cinema3-navy/30 hover:text-cinema3-navy transition">
                    <span x-show="!show" class="text-sm font-bold">SHOW</span>
                    <span x-show="show" class="text-sm font-bold" style="display:none;">HIDE</span>
                </button>
            </div>
        </div>

        <!-- Confirm Password -->
        <div class="space-y-2" x-data="{ show: false }">
            <x-label for="password_confirmation" value="Confirm Password" class="text-cinema3-navy font-bold uppercase text-xs tracking-wider" />
            <div class="relative">
                <input id="password_confirmation" :type="show ? 'text' : 'password'" name="password_confirmation" required
                       placeholder="••••••••"
                       class="block w-full rounded-2xl border-2 border-cinema3-navy/10 bg-white px-5 py-4 text-cinema3-navy font-bold placeholder-cinema3-navy/20 focus:border-cinema3-gold focus:ring focus:ring-cinema3-gold/20 transition-all outline-none" />
                <button type="button" @click="show = !show" class="absolute right-5 top-1/2 -translate-y-1/2 text-cinema3-navy/30 hover:text-cinema3-navy transition">
                    <span x-show="!show" class="text-sm font-bold">SHOW</span>
                    <span x-show="show" class="text-sm font-bold" style="display:none;">HIDE</span>
                </button>
            </div>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="w-full rounded-2xl bg-cinema3-navy py-4 text-lg font-bold text-white shadow-xl shadow-cinema3-navy/30 hover:bg-cinema3-navySoft hover:shadow-2xl hover:-translate-y-0.5 transition-all duration-300">
            Create Account
        </button>

        <!-- Login Link -->
        <div class="text-center pt-4">
            <p class="text-sm text-cinema3-navy/60 font-medium">
                Already have an account? 
                <a href="{{ route('login') }}" class="text-cinema3-navy font-black underline decoration-2 decoration-cinema3-gold hover:text-cinema3-goldDark transition-colors">
                    Login here
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
