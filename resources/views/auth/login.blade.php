<x-guest-layout>
    <!-- Header -->
    <div class="mb-10">
        <h1 class="text-4xl font-black text-cinema3-navy tracking-tight mb-2">Welcome Back</h1>
        <p class="text-cinema3-navy/60 font-medium text-lg">Please enter your details to sign in.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Form -->
    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <!-- Email -->
        <div class="space-y-2">
            <x-label for="email" value="Email Address" class="text-cinema3-navy font-bold uppercase text-xs tracking-wider" />
            <input id="email" type="email" name="email" :value="old('email')" required autofocus
                   placeholder="name@example.com"
                   class="block w-full rounded-2xl border-2 border-cinema3-navy/10 bg-white px-5 py-4 text-cinema3-navy font-bold placeholder-cinema3-navy/20 focus:border-cinema3-gold focus:ring focus:ring-cinema3-gold/20 transition-all outline-none" />
        </div>

        <!-- Password -->
        <div class="space-y-2" x-data="{ show: false }">
            <div class="flex items-center justify-between">
                <x-label for="password" value="Password" class="text-cinema3-navy font-bold uppercase text-xs tracking-wider" />
                @if (Route::has('password.request'))
                    <a class="text-xs font-bold text-cinema3-navy/50 hover:text-cinema3-navy transition" href="{{ route('password.request') }}">
                        Forgot Password?
                    </a>
                @endif
            </div>
            
            <div class="relative">
                <input id="password" :type="show ? 'text' : 'password'" name="password" required autocomplete="current-password"
                       placeholder="••••••••"
                       class="block w-full rounded-2xl border-2 border-cinema3-navy/10 bg-white px-5 py-4 text-cinema3-navy font-bold placeholder-cinema3-navy/20 focus:border-cinema3-gold focus:ring focus:ring-cinema3-gold/20 transition-all outline-none" />
                <button type="button" @click="show = !show" class="absolute right-5 top-1/2 -translate-y-1/2 text-cinema3-navy/30 hover:text-cinema3-navy transition">
                    <span x-show="!show" class="text-sm font-bold">SHOW</span>
                    <span x-show="show" class="text-sm font-bold" style="display:none;">HIDE</span>
                </button>
            </div>
        </div>

        <!-- Remember Me -->
        <div class="block">
            <label for="remember_me" class="inline-flex items-center group cursor-pointer">
                <input id="remember_me" type="checkbox" name="remember" class="rounded border-cinema3-navy/20 text-cinema3-navy shadow-sm focus:border-cinema3-gold focus:ring focus:ring-cinema3-gold/20 focus:ring-opacity-50">
                <span class="ml-2 text-sm text-cinema3-navy/70 font-medium group-hover:text-cinema3-navy transition">Remember me</span>
            </label>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="w-full rounded-2xl bg-cinema3-navy py-4 text-lg font-bold text-white shadow-xl shadow-cinema3-navy/30 hover:bg-cinema3-navySoft hover:shadow-2xl hover:-translate-y-0.5 transition-all duration-300">
            Sign In
        </button>

        <!-- Register Link -->
        <div class="text-center pt-4">
            <p class="text-sm text-cinema3-navy/60 font-medium">
                Don't have an account? 
                <a href="{{ route('register') }}" class="text-cinema3-navy font-black underline decoration-2 decoration-cinema3-gold hover:text-cinema3-goldDark transition-colors">
                    Register for free
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
