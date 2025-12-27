<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1">
            <h2 class="font-semibold text-2xl text-cinema3-gold leading-tight">
                My Profile
            </h2>
            <p class="text-sm text-white/60">
                Manage your account details and password.
            </p>
        </div>
    </x-slot>

    <!-- Toasts -->
    @if (session('status') === 'profile-updated')
        <div x-data="{ show: true }" x-show="show" x-transition
             x-init="setTimeout(() => show = false, 2200)"
             class="fixed top-20 right-6 z-50 rounded-xl bg-cinema3-gold text-cinema3-navy px-4 py-3 font-semibold shadow-2xl">
            Profile updated successfully.
        </div>
    @endif

    @if (session('status') === 'password-updated')
        <div x-data="{ show: true }" x-show="show" x-transition
             x-init="setTimeout(() => show = false, 2200)"
             class="fixed top-20 right-6 z-50 rounded-xl bg-cinema3-gold text-cinema3-navy px-4 py-3 font-semibold shadow-2xl">
            Password updated successfully.
        </div>
    @endif

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- Profile Info -->
            <div class="rounded-2xl bg-white/85 backdrop-blur-md border border-white/20 shadow-2xl p-8">
                <header>
                    <h3 class="text-xl font-extrabold text-cinema3-navy">Profile Information</h3>
                    <p class="mt-1 text-sm text-cinema3-navy/60">
                        Update your name, email, and avatar.
                    </p>
                </header>

                <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
                    @csrf
                    @method('patch')

                    @php
                        $avatarUrl = $user->avatar ? asset('storage/' . $user->avatar) : null;
                    @endphp

                    <!-- Avatar -->
                    <div>
                        <x-label for="avatar" value="Avatar" class="text-cinema3-navy font-semibold" />

                        @php
                            $avatarUrl = $user->avatar ? asset('storage/' . $user->avatar) : null;
                            $initial = strtoupper(substr($user->name, 0, 1));
                        @endphp

                        <div class="mt-3 flex items-center gap-4"
                            x-data="{ preview: @json($avatarUrl), fileName: '' }">

                            <!-- Circle Avatar -->
                            <div class="h-20 w-20 rounded-full overflow-hidden border border-cinema3-navy/10 bg-white shadow-sm ring-4 ring-white/70 flex items-center justify-center">
                                <template x-if="preview">
                                    <img :src="preview" alt="Avatar" class="h-full w-full object-cover">
                                </template>

                                <template x-if="!preview">
                                    <span class="text-cinema3-navy font-extrabold text-3xl">
                                        {{ $initial }}
                                    </span>
                                </template>
                            </div>

                            <!-- Upload button + filename -->
                            <div class="flex-1">
                                <input
                                    id="avatar"
                                    name="avatar"
                                    type="file"
                                    accept="image/*"
                                    class="hidden"
                                    @change="
                                        fileName = $event.target.files[0] ? $event.target.files[0].name : '';
                                        if($event.target.files[0]){
                                            const reader = new FileReader();
                                            reader.onload = (e) => preview = e.target.result;
                                            reader.readAsDataURL($event.target.files[0]);
                                        }
                                    "
                                >

                                <div class="flex flex-wrap items-center gap-3">
                                    <label for="avatar"
                                        class="inline-flex items-center justify-center rounded-xl bg-cinema3-gold px-4 py-2 text-sm font-semibold text-cinema3-navy shadow-sm
                                                hover:bg-cinema3-goldDark focus:outline-none focus:ring-2 focus:ring-cinema3-gold/40 transition cursor-pointer">
                                        Choose Photo
                                    </label>

                                    <span class="text-sm text-cinema3-navy/60"
                                        x-text="fileName ? fileName : 'PNG, JPG, WEBP up to 2MB'">
                                    </span>
                                </div>
                            </div>
                        </div>

                        <x-input-error :messages="$errors->get('avatar')" class="mt-2" />
                    </div>

                    <!-- Name -->
                    <div>
                        <x-label for="name" value="Name" class="text-cinema3-navy font-semibold" />
                        <x-input id="name" name="name" type="text"
                                 class="mt-1 block w-full rounded-xl border border-cinema3-navy/20 bg-white text-cinema3-navy
                                        focus:border-cinema3-gold focus:ring focus:ring-cinema3-gold/30"
                                 :value="old('name', $user->name)" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email -->
                    <div>
                        <x-label for="email" value="Email" class="text-cinema3-navy font-semibold" />
                        <x-input id="email" name="email" type="email"
                                 class="mt-1 block w-full rounded-xl border border-cinema3-navy/20 bg-white text-cinema3-navy
                                        focus:border-cinema3-gold focus:ring focus:ring-cinema3-gold/30"
                                 :value="old('email', $user->email)" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="pt-2">
                        <button type="submit"
                                class="inline-flex items-center justify-center rounded-xl bg-cinema3-navy px-6 py-3 text-sm font-semibold text-white shadow-sm
                                       hover:bg-cinema3-navySoft focus:outline-none focus:ring-2 focus:ring-cinema3-gold/30 transition">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>

            <!-- Password -->
            <div class="rounded-2xl bg-white/85 backdrop-blur-md border border-white/20 shadow-2xl p-8">
                <header>
                    <h3 class="text-xl font-extrabold text-cinema3-navy">Update Password</h3>
                    <p class="mt-1 text-sm text-cinema3-navy/60">
                        Use a strong password to keep your account safe.
                    </p>
                </header>

                <form method="post" action="{{ route('profile.password') }}" class="mt-6 space-y-6">
                    @csrf
                    @method('patch')

                    <div>
                        <x-label for="current_password" value="Current Password" class="text-cinema3-navy font-semibold" />
                        <x-input id="current_password" name="current_password" type="password"
                                 class="mt-1 block w-full rounded-xl border border-cinema3-navy/20 bg-white text-cinema3-navy
                                        focus:border-cinema3-gold focus:ring focus:ring-cinema3-gold/30"
                                 autocomplete="current-password" required />
                        <x-input-error :messages="$errors->get('current_password')" class="mt-2" />
                    </div>

                    <div>
                        <x-label for="new_password" value="New Password" class="text-cinema3-navy font-semibold" />
                        <x-input id="new_password" name="new_password" type="password"
                                 class="mt-1 block w-full rounded-xl border border-cinema3-navy/20 bg-white text-cinema3-navy
                                        focus:border-cinema3-gold focus:ring focus:ring-cinema3-gold/30"
                                 autocomplete="new-password" required />
                        <x-input-error :messages="$errors->get('new_password')" class="mt-2" />
                    </div>

                    <div>
                        <x-label for="new_password_confirmation" value="Confirm New Password" class="text-cinema3-navy font-semibold" />
                        <x-input id="new_password_confirmation" name="new_password_confirmation" type="password"
                                 class="mt-1 block w-full rounded-xl border border-cinema3-navy/20 bg-white text-cinema3-navy
                                        focus:border-cinema3-gold focus:ring focus:ring-cinema3-gold/30"
                                 required />
                    </div>

                    <div class="pt-2">
                        <button type="submit"
                                class="inline-flex items-center justify-center rounded-xl bg-cinema3-gold px-6 py-3 text-sm font-semibold text-cinema3-navy shadow-sm
                                       hover:bg-cinema3-goldDark focus:outline-none focus:ring-2 focus:ring-cinema3-gold/40 transition">
                            Update Password
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
