<x-guest-layout>
    <!-- Card Register -->
    <div class="w-full max-w-md bg-white dark:bg-gray-800 p-10 rounded-2xl shadow-lg">
        <!-- Logo -->
        <div class="mb-8 flex justify-center">
            <x-application-logo class="h-20 w-auto text-[#B53543]" />
        </div>

        <!-- Title -->
        <h2 class="text-center text-2xl font-bold text-[#283539] dark:text-gray-100 mb-2">
            Hello, Welcome to FLOWS
        </h2>
        <p class="text-center text-sm text-[#283539] dark:text-gray-400 mb-6">
            First time here? We got you!
        </p>

        <!-- Form -->
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="mb-4 relative">
                <x-input-label for="name" :value="__('Name')" class="text-[#000000]" />
                <x-text-input id="name" type="text" name="name"
                    class="block mt-1 w-full rounded-xl shadow-sm border-gray-300 focus:border-[#B53543] focus:ring-[#B53543] pr-10"
                    placeholder="Enter Name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />

                <!-- Ikon -->
                <div class="absolute inset-y-0 right-3 flex items-center mt-6 pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#B53543]" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
            </div>

            <!-- Email -->
            <div class="mb-4 relative">
                <x-input-label for="email" :value="__('Email')" class="text-[#000000]" />
                <x-text-input id="email" type="email" name="email"
                    class="block mt-1 w-full rounded-xl shadow-sm border-gray-300 focus:border-[#B53543] focus:ring-[#B53543] pr-10"
                    placeholder="Enter Email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />

                <!-- Ikon -->
                <div class="absolute inset-y-0 right-3 flex items-center mt-8 pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#B53543]" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path
                            d="M18.9758 1.41346C18.9717 1.40511 18.9696 1.39603 18.9683 1.38685C18.9124 0.996834 18.7115 0.640112 18.4033 0.384486C18.0914 0.12584 17.692 -0.0108711 17.2824 0.000866236C12.0966 0.000866236 6.90949 0.000866236 1.72116 0.000866236C1.49273 -0.00640179 1.26521 0.0321295 1.05273 0.114066C0.840255 0.196002 0.647364 0.319591 0.486045 0.477154C0.324727 0.634716 0.198431 0.822884 0.115005 1.02996C0.0315789 1.23704 -0.00719362 1.45861 0.00109701 1.68089C0.00109701 4.89519 0.00109701 8.10828 0.00109701 11.3202C-0.00595625 11.5797 0.0515209 11.837 0.168636 12.0702C0.503713 12.7067 1.05225 12.999 1.78197 12.999H17.2514C17.5273 13.0084 17.8014 12.9522 18.0498 12.8351C18.2983 12.7181 18.5137 12.5439 18.6773 12.3275C18.9957 11.8652 19 11.272 19 10.7108V1.49432C19 1.46586 18.9882 1.43906 18.9758 1.41346ZM17.036 1.08787C17.0451 1.08787 17.0537 1.0919 17.0595 1.09888C17.0716 1.11338 17.0679 1.13523 17.052 1.14554C17.0193 1.16689 16.988 1.19039 16.9585 1.21589C14.8901 3.21275 12.8259 5.21082 10.7658 7.2101C10.2421 7.71857 9.6352 7.8937 8.92285 7.65819C8.684 7.57371 8.4683 7.43693 8.29241 7.25841C6.18431 5.21887 4.07457 3.17773 1.96316 1.13497C1.94551 1.11672 1.95927 1.08787 1.98466 1.08787H17.036ZM1.20489 11.0653C1.17371 11.0957 1.1205 11.0713 1.1205 11.0278V1.90861C1.1205 1.89819 1.12492 1.88827 1.13266 1.8813C1.15119 1.86463 1.18062 1.87086 1.19277 1.89261C1.20981 1.92312 1.22964 1.9521 1.25205 1.97921C2.76611 3.44787 4.28182 4.91572 5.79918 6.38277C5.8724 6.45403 5.93818 6.49509 5.824 6.60379C4.28182 8.08775 2.74212 9.57493 1.20489 11.0653ZM1.9625 11.9108C1.9542 11.9108 1.94626 11.9074 1.94052 11.9014C1.92721 11.8875 1.92997 11.8649 1.94591 11.8542C1.98515 11.8277 2.02282 11.799 2.05872 11.7683C3.56616 10.3125 5.07277 8.8559 6.57855 7.39851C6.70265 7.27773 6.75229 7.29223 6.86274 7.39851C7.1535 7.71066 7.46572 8.00321 7.79724 8.27415C8.92409 9.1196 10.4406 9.02539 11.4918 8.0326C11.7176 7.82003 11.9435 7.60504 12.1607 7.3816C12.2563 7.28377 12.3096 7.2729 12.4163 7.3816C13.5333 8.46861 14.6614 9.55561 15.782 10.6426C16.2555 11.1007 15.9232 11.9041 15.2644 11.9044L1.9625 11.9108ZM17.8719 11.0995C17.8719 11.1077 17.8684 11.1156 17.8623 11.1211C17.8495 11.1326 17.8296 11.1305 17.8192 11.1168C17.791 11.0797 17.761 11.044 17.7292 11.0098C16.2226 9.54836 14.7143 8.08976 13.2044 6.63399C13.0952 6.52891 13.0927 6.47939 13.2044 6.37311C14.716 4.91814 16.2242 3.45954 17.7292 1.99733C17.7831 1.94325 17.8743 1.97452 17.8743 2.05089L17.8719 11.0995Z"
                            fill="#B53543" />
                    </svg>
                </div>
            </div>



            <!-- Password -->
            <div class="mb-4" x-data="{ show: false }">
                <x-input-label for="password" :value="__('Password')" class="text-[#000000]" />

                <div class="relative">
                    <input :type="show ? 'text' : 'password'" id="password" name="password"
                        class="block mt-1 w-full rounded-xl shadow-sm border-gray-300 focus:border-[#B53543] focus:ring-[#B53543] pr-10"
                        placeholder="Enter Password" required autocomplete="new-password" />

                    <!-- Toggle Password -->
                    <button type="button" @click="show = !show"
                        class="absolute inset-y-0 right-3 flex items-center text-[#B53543] focus:outline-none">
                        <!-- Show -->
                        <svg x-show="!show" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <!-- Hide -->
                        <svg x-show="show" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.269-2.943-9.543-7a9.956 9.956 0 012.045-3.36m3.635-2.3A9.956 9.956 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.956 9.956 0 01-4.046 5.363M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18" />
                        </svg>
                    </button>
                </div>

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mb-6" x-data="{ show: false }">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-[#000000]" />

                <div class="relative">
                    <input :type="show ? 'text' : 'password'" id="password_confirmation" name="password_confirmation"
                        class="block mt-1 w-full rounded-xl shadow-sm border-gray-300 focus:border-[#B53543] focus:ring-[#B53543] pr-10"
                        placeholder="Confirm Password" required autocomplete="new-password" />

                    <!-- Toggle Password -->
                    <button type="button" @click="show = !show"
                        class="absolute inset-y-0 right-3 flex items-center text-[#B53543] focus:outline-none">
                        <svg x-show="!show" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg x-show="show" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.269-2.943-9.543-7a9.956 9.956 0 012.045-3.36m3.635-2.3A9.956 9.956 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.956 9.956 0 01-4.046 5.363M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18" />
                        </svg>
                    </button>
                </div>

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <!-- Register Button -->
            <button type="submit"
                class="w-full bg-[#B53543] text-white py-3 rounded-full shadow hover:bg-[#a32c38] transition font-bold">
                REGISTER
            </button>
        </form>

        <!-- Footer -->
        <p class="text-center text-sm text-gray-700 dark:text-gray-400 mt-6">
            Already registered?
            <a href="{{ route('login') }}" class="text-[#B53543] hover:underline">Login</a>
        </p>
    </div>
</x-guest-layout>