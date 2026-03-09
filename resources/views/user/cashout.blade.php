<x-app-layout>
    <div class="w-full p-4 sm:max-w-lg sm:mx-auto sm:p-8 sm:shadow-xl sm:mt-12">
        <h2 class="text-2xl font-bold mb-4 text-center text-gray-800 sm:text-3xl sm:mb-6">Withdrawal Funds</h2>
        <img src="mpesalogo.png" class="w-full h-36 object-contain mb-4 rounded-lg sm:h-56 sm:mb-6" alt="ithdrawal" />

        <form class="space-y-4 sm:space-y-6" method="POST" action="{{ route('cashout.store') }}">
            @csrf

            <!-- Mpesa Number Field -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1 sm:mb-2">Mpesa Number</label>
                <input type="tel"
                    class="w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none transition duration-200 sm:p-3"
                    name="phone" value="{{ Auth::user()->phone }}" placeholder="Enter Mpesa number">
            </div>

            <!-- Method Select Field -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1 sm:mb-2">Select Method</label>
                <select x-model="method" name="method"
                    class="w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none transition duration-200 sm:p-3">
                    <option value="mpesa">Mpesa</option>
                    <option value="airtel">Airtel Money</option>
                </select>
            </div>

            <!-- Amount Field -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1 sm:mb-2">Amount</label>
                <input type="number" name="amount" x-model="amount" min="1"
                    class="w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none transition duration-200 sm:p-3"
                    placeholder="Enter withdrawal amount">
            </div>

            <!-- Withdrawal Button -->
            <div class="mt-6 sm:mt-8">
                <button
                    class="w-full bg-primary text-primary-foreground py-2 rounded-lg font-semibold hover:bg-primary/70 transition duration-200 transform hover:scale-105 sm:py-3">
                    Withdrawal Now
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
