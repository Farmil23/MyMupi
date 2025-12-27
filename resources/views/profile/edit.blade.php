<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-cinema3-gold leading-tight">
            {{ __('My Profile') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-cinema3-cream min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- NOTIF PROFILE UPDATED -->
            @if (session('status') === 'profile-updated')
                <div 
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="bg-cinema3-gold text-cinema3-navy px-4 py-2 rounded-lg shadow-lg fixed top-20 right-10 z-50 font-bold"
                >
                    {{ __('Profile Updated Successfully.') }}
                </div>
            @endif

            <!-- NOTIF PASSWORD UPDATED -->
            @if (session('status') === 'password-updated')
                <div 
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="bg-cinema3-gold text-cinema3-navy px-4 py-2 rounded-lg shadow-lg fixed top-20 right-10 z-50 font-bold"
                >
                    {{ __('Password Updated Successfully.') }}
                </div>
            @endif

            <!--PROFILE INFORMATION -->
            <div class="p-6 sm:p-8 bg-white shadow-xl rounded-lg border border-cinema3-navy/10">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-xl font-bold text-cinema3-navy">
                                {{ __('Profile Information') }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-600">
                                {{ __("Update your account's profile information and email address.") }}
                            </p>
                        </header>

                        <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
                            @csrf
                            @method('patch')

                            <!-- AVATAR -->
                            <div>
                                <x-label for="avatar" :value="__('Avatar')" class="text-cinema3-navy font-semibold" />

                                <div class="mt-2 flex items-center gap-4">
                                    <div class="relative w-20 h-20 rounded-full overflow-hidden border-2 border-cinema3-gold shadow">
                                        @if($user->avatar)
                                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full bg-cinema3-navySoft flex items-center justify-center text-cinema3-gold text-2xl font-bold">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>

                                    <input id="avatar" name="avatar" type="file"
                                        class="block w-full text-sm text-gray-700
                                        file:mr-4 file:py-2 file:px-4
                                        file:rounded-lg file:border-0
                                        file:text-sm file:font-semibold
                                        file:bg-cinema3-gold file:text-cinema3-navy
                                        hover:file:bg-cinema3-goldDark transition"
                                    />
                                </div>
                                <x-input-error :messages="$errors->get('avatar')" class="mt-2" />
                            </div>

                            <!--NAME -->
                            <div>
                                <x-label for="name" :value="__('Name')" class="text-cinema3-navy font-semibold" />
                                <x-input id="name" name="name" type="text"
                                    class="mt-1 block w-full bg-white border border-cinema3-navy/20 text-cinema3-navy rounded-lg
                                    focus:border-cinema3-gold focus:ring focus:ring-cinema3-gold/30"
                                    :value="old('name', $user->name)" required autofocus autocomplete="name" />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <!-- EMAIL -->
                            <div>
                                <x-label for="email" :value="__('Email')" class="text-cinema3-navy font-semibold" />
                                <x-input id="email" name="email" type="email"
                                    class="mt-1 block w-full bg-white border border-cinema3-navy/20 text-cinema3-navy rounded-lg
                                    focus:border-cinema3-gold focus:ring focus:ring-cinema3-gold/30"
                                    :value="old('email', $user->email)" required autocomplete="username" />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <!-- BUTTON -->
                            <div class="flex items-center gap-4">
                                <x-button class="bg-cinema3-gold hover:bg-cinema3-goldDark text-cinema3-navy font-bold py-2 px-6 rounded-lg transition shadow">
                                    {{ __('Save Changes') }}
                                </x-button>
                            </div>
                        </form>
                    </section>
                </div>
            </div>

            <!--UPDATE PASSWORD -->
            <div class="p-6 sm:p-8 bg-white shadow-xl rounded-lg border border-cinema3-navy/10">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-xl font-bold text-cinema3-navy">
                                {{ __('Update Password') }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-600">
                                {{ __('Ensure your account is using a long, random password to stay secure.') }}
                            </p>
                        </header>

                        <form method="post" action="{{ route('profile.password') }}" class="mt-6 space-y-6">
                            @csrf
                            @method('patch')

                            <!-- CURRENT PASSWORD -->
                            <div>
                                <x-label for="current_password" :value="__('Current Password')" class="text-cinema3-navy font-semibold" />
                                <x-input id="current_password" name="current_password" type="password"
                                    class="mt-1 block w-full bg-white border border-cinema3-navy/20 text-cinema3-navy rounded-lg
                                    focus:border-cinema3-gold focus:ring focus:ring-cinema3-gold/30"
                                    autocomplete="current-password" />
                                <x-input-error :messages="$errors->get('current_password')" class="mt-2" />
                            </div>

                            <!-- NEW PASSWORD -->
                            <div>
                                <x-label for="new_password" :value="__('New Password')" class="text-cinema3-navy font-semibold" />
                                <x-input id="new_password" name="new_password" type="password"
                                    class="mt-1 block w-full bg-white border border-cinema3-navy/20 text-cinema3-navy rounded-lg
                                    focus:border-cinema3-gold focus:ring focus:ring-cinema3-gold/30"
                                    autocomplete="new-password" />
                                <x-input-error :messages="$errors->get('new_password')" class="mt-2" />
                            </div>

                            <!-- CONFIRM PASSWORD -->
                            <div>
                                <x-label for="new_password_confirmation" :value="__('Confirm Password')" class="text-cinema3-navy font-semibold" />
                                <x-input id="new_password_confirmation" name="new_password_confirmation" type="password"
                                    class="mt-1 block w-full bg-white border border-cinema3-navy/20 text-cinema3-navy rounded-lg
                                    focus:border-cinema3-gold focus:ring focus:ring-cinema3-gold/30"
                                    autocomplete="new-password" />
                                <x-input-error :messages="$errors->get('new_password_confirmation')" class="mt-2" />
                            </div>

                            <!--BUTTON -->
                            <div class="flex items-center gap-4">
                                <x-button class="bg-cinema3-navy hover:bg-cinema3-navySoft text-white font-bold py-2 px-6 rounded-lg transition shadow">
                                    {{ __('Update Password') }}
                                </x-button>
                            </div>
                        </form>
                    </section>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
