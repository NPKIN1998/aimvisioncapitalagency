<x-app-layout>
<div class="container mx-auto px-4 py-8">
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-red-500 px-6 py-4">
            <h1 class="text-white text-xl font-bold">Insufficient Balance</h1>
        </div>
        
        <div class="p-6">
            <div class="mb-4">
                <p class="text-gray-700 mb-2">{{ $message }}</p>
                
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div class="bg-gray-100 p-4 rounded-lg">
                        <p class="text-sm text-gray-500">Required Amount</p>
                        <p class="text-lg font-bold text-red-600">
                            KES {{ number_format($requiredAmount, 2) }}
                        </p>
                    </div>
                    <div class="bg-gray-100 p-4 rounded-lg">
                        <p class="text-sm text-gray-500">Your Balance</p>
                        <p class="text-lg font-bold">
                            KES {{ number_format($currentBalance, 2) }}
                        </p>
                    </div>
                </div>
                
                <div class="flex flex-col space-y-3">
                    <a href="{{ route('deposit') }}" 
                       class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-center transition">
                        Add Funds to Wallet
                    </a>
                    <a href="{{ url()->previous() }}" 
                       class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded text-center transition">
                        Go Back
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>