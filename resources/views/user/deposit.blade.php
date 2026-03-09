<x-app-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-md bg-white rounded-3xl shadow-xl p-6 sm:p-8">

            <!-- Title -->
            <h2 class="text-2xl font-bold text-center text-gray-800 sm:text-3xl mb-6">
                Deposit Funds
            </h2>

            <!-- Mpesa Image -->
            <div class="flex justify-center mb-6">
                <img src="{{ asset('mpesalogo.png') }}" alt="Deposit"
                    class="w-48 h-32 object-contain rounded-lg sm:w-56 sm:h-36 shadow-sm" />
            </div>

            <!-- Deposit Form -->
            <form class="space-y-5" method="POST" action="{{ route('deposit.store') }}">
                @csrf

                <!-- Mpesa Number Field -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1 sm:mb-2">Mpesa
                        Number</label>
                    <input type="tel" name="phone" id="phone" x-model="phone"
                        value="{{ Auth::user()->phone }}" placeholder="Enter Mpesa number"
                        class="w-full px-4 py-2 sm:py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none transition duration-200" />
                </div>

                <!-- Amount Field -->
                <div>
                    <label for="amount" class="block text-sm font-medium text-gray-700 mb-1 sm:mb-2">Amount</label>
                    <input type="number" name="amount" id="amount" x-model="amount" min="1"
                        placeholder="Enter deposit amount"
                        class="w-full px-4 py-2 sm:py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none transition duration-200" />
                </div>

                <!-- Deposit Button -->
                <div class="mt-6">
                    <x-primary-button type="submit"
                        class="w-full py-2 sm:py-3 rounded-lg justify-center font-semibold transition duration-200 transform hover:scale-105 shadow-md">
                        Deposit Now
                    </x-primary-button>
                </div>
            </form>

            <!-- Optional Info / Note -->
            <p class="mt-6 text-center text-xs text-gray-500">
                Ensure your Mpesa number is active and you have sufficient balance.
            </p>

        </div>
    </div>
</x-app-layout>
