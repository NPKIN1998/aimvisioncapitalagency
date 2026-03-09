<x-guest-layout>
    <div class="flex justify-center items-center text-center flex-col text-foreground">
        <h1 class="text-2xl font-medium text-foreground">Create an Account</h1>
        <p class="tet-sm pt-3 px-4">
            Stay connected, follow teams, and never miss thrilling Stay connected
        </p>
    </div>
    <form method="POST" action="{{ route('register') }}" class="flex flex-col gap-4 pt-8 px-2">
        @csrf

        <!-- Name -->
        <div class="flex flex-col justify-start">
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full outline-none" type="text" name="name"
                :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Username -->
        <div class="flex flex-col justify-start">
            <x-input-label for="username" :value="__('Username')" />
            <x-text-input id="username" class="block mt-1 w-full" type="text" name="username" :value="old('username')"
                required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('username')" class="mt-2" />
        </div>


        <!-- Country -->
        <div class="flex flex-col justify-start mt-4">
            <x-input-label for="country" :value="__('Country')" />
            <select id="country" name="country" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                <option value="">Select Country</option>
                <option value="US" @selected(old('country') == 'US')>United States</option>
                <option value="UK" @selected(old('country') == 'UK')>United Kingdom</option>
                <option value="CA" @selected(old('country') == 'CA')>Canada</option>
                <option value="NG" @selected(old('country') == 'NG')>Nigeria</option>
                <option value="KE" @selected(old('country') == 'KE')>Kenya</option>
                <option value="GH" @selected(old('country') == 'GH')>Ghana</option>
                <option value="IN" @selected(old('country') == 'IN')>India</option>
                <option value="PH" @selected(old('country') == 'PH')>Philippines</option>
            </select>
            <x-input-error :messages="$errors->get('country')" class="mt-2" />
        </div>
        
        <!-- Phone -->
        <div class="flex flex-col justify-start">
            <x-input-label for="phone" :value="__('Phone')" />
            <x-text-input id="phone" class="block mt-1 w-full" type="tel" name="phone" :value="old('phone')"
                required autofocus autocomplete="phone" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="flex flex-col justify-start">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div x-data="{ showPassword: false }">
            @foreach (['password' => __('Password'), 'password_confirmation' => __('Confirm Password')] as $name => $label)
                <div class="flex flex-col justify-start mt-4">
                    <x-input-label :for="$name" :value="$label" />
                    <div class="relative">
                        <!-- Fix: Bind type properly inside Alpine.js -->
                        <x-text-input :id="$name" class="block mt-1 w-full pr-10"
                            x-bind:type="showPassword ? 'text' : 'password'" name="{{ $name }}" required autocomplete="new-password" />
        
                        <!-- Toggle Password Visibility -->
                        <button type="button" @click="showPassword = !showPassword"
                            class="absolute inset-y-0 right-0 flex items-center px-2">
                            <!-- Show Eye Icon -->
                            <svg x-show="!showPassword" x-cloak xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
        
                            <!-- Show Eye Slash Icon -->
                            <svg x-show="showPassword" x-cloak xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                            </svg>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get($name)" class="mt-2" />
                </div>
            @endforeach
        </div>
        



        <div class="flex flex-col">
            <x-primary-button class="w-full text-center items-center justify-center">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
    <div class="pt-4 text-center text-sm text-foreground">
        Already have an account?
        <a href="{{ route('login') }}" class="text-primary font-medium">Sign In</a> here
    </div>
</x-guest-layout>
