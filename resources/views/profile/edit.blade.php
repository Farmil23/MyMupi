<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-cinema-gold leading-tight">
            {{ __('My Profile') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-cinema-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            
            @if (session('status') === 'profile-updated')
                <div 
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="bg-cinema-gold text-cinema-900 px-4 py-2 rounded shadow-lg fixed top-20 right-10 z-50 font-bold"
                >
                    {{ __('Profile Updated Successfully.') }}
                </div>
            @endif

            @if (session('status') === 'password-updated')
                <div 
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="bg-cinema-gold text-cinema-900 px-4 py-2 rounded shadow-lg fixed top-20 right-10 z-50 font-bold"
                >
                    {{ __('Password Updated Successfully.') }}
                </div>
            @endif

            <div class="p-4 sm:p-8 bg-cinema-800 shadow sm:rounded-lg border border-cinema-700">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-white">
                                {{ __('Profile Information') }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-400">
                                {{ __("Update your account's profile information and email address.") }}
                            </p>
                        </header>

                        <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
                            @csrf
                            @method('patch')

                            <!-- Avatar -->
                            <div>
                                <x-label for="avatar" :value="__('Avatar')" class="text-gray-300" />
                                <div class="mt-2 flex items-center gap-4">
                                    <div class="relative w-20 h-20 rounded-full overflow-hidden border-2 border-cinema-gold">
                                        @if($user->avatar)
                                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full bg-cinema-700 flex items-center justify-center text-cinema-gold text-2xl font-bold">
                                                {{ substr($user->name, 0, 1) }}
                                            </div>
                                        @endif
                                    </div>
                                    <input id="avatar" name="avatar" type="file" class="block w-full text-sm text-gray-400
                                        file:mr-4 file:py-2 file:px-4
                                        file:rounded-full file:border-0
                                        file:text-sm file:font-semibold
                                        file:bg-cinema-gold file:text-cinema-900
                                        hover:file:bg-yellow-400
                                    " />
                                </div>
                                <x-input-error :messages="$errors->get('avatar')" class="mt-2" />
                            </div>

                            <div>
                                <x-label for="name" :value="__('Name')" class="text-gray-300" />
                                <x-input id="name" name="name" type="text" class="mt-1 block w-full bg-cinema-700 border-cinema-600 text-white focus:border-cinema-gold focus:ring-cinema-gold" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <div>
                                <x-label for="email" :value="__('Email')" class="text-gray-300" />
                                <x-input id="email" name="email" type="email" class="mt-1 block w-full bg-cinema-700 border-cinema-600 text-white focus:border-cinema-gold focus:ring-cinema-gold" :value="old('email', $user->email)" required autocomplete="username" />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <div class="flex items-center gap-4">
                                <x-button class="bg-cinema-red hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition">
                                    {{ __('Save Changes') }}
                                </x-button>
                            </div>
                        </form>
                    </section>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-cinema-800 shadow sm:rounded-lg border border-cinema-700">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-white">
                                {{ __('Update Password') }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-400">
                                {{ __('Ensure your account is using a long, random password to stay secure.') }}
                            </p>
                        </header>

                        <form method="post" action="{{ route('profile.password') }}" class="mt-6 space-y-6">
                            @csrf
                            @method('patch')

                            <div>
                                <x-label for="current_password" :value="__('Current Password')" class="text-gray-300" />
                                <x-input id="current_password" name="current_password" type="password" class="mt-1 block w-full bg-cinema-700 border-cinema-600 text-white focus:border-cinema-gold focus:ring-cinema-gold" autocomplete="current-password" />
                                <x-input-error :messages="$errors->get('current_password')" class="mt-2" />
                            </div>

                            <div>
                                <x-label for="new_password" :value="__('New Password')" class="text-gray-300" />
                                <x-input id="new_password" name="new_password" type="password" class="mt-1 block w-full bg-cinema-700 border-cinema-600 text-white focus:border-cinema-gold focus:ring-cinema-gold" autocomplete="new-password" />
                                <x-input-error :messages="$errors->get('new_password')" class="mt-2" />
                            </div>

                            <div>
                                <x-label for="new_password_confirmation" :value="__('Confirm Password')" class="text-gray-300" />
                                <x-input id="new_password_confirmation" name="new_password_confirmation" type="password" class="mt-1 block w-full bg-cinema-700 border-cinema-600 text-white focus:border-cinema-gold focus:ring-cinema-gold" autocomplete="new-password" />
                                <x-input-error :messages="$errors->get('new_password_confirmation')" class="mt-2" />
                            </div>

                            <div class="flex items-center gap-4">
                                <x-button class="bg-cinema-red hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition">
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
