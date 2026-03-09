<x-app-layout>
    <div class="w-full px-4 py-6 md:px-8" x-data="{ activeTab: 'daily', ratings: {} }">
        <!-- Page Header -->
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Task Center</h1>
        </div>

        <!-- Tab Navigation -->
        <div class="flex space-x-2 md:space-x-4 mb-6 justify-center md:justify-start">
            <button @click="activeTab = 'daily'"
                :class="activeTab === 'daily' ? 'bg-blue-600 text-white shadow-lg' :
                    'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                class="relative px-6 py-2 font-medium rounded-lg transition-all duration-200"
                style="clip-path: polygon(15% 0%, 85% 0%, 100% 100%, 0% 100%);">
                Daily Tasks
            </button>
            <button @click="activeTab = 'rent'"
                :class="activeTab === 'rent' ? 'bg-blue-600 text-white shadow-lg' :
                    'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                class="relative px-6 py-2 font-medium rounded-lg transition-all duration-200"
                style="clip-path: polygon(15% 0%, 85% 0%, 100% 100%, 0% 100%);">
                Claim Rent
            </button>
        </div>

        <!-- Daily Tasks Tab -->
        <div x-show="activeTab === 'daily'" class="space-y-6" x-cloak>
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Rate Packages</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach ($investments as $investment)
                    <div
                        class="bg-white rounded-2xl shadow-lg p-4 border border-gray-100 flex flex-col md:flex-row hover:shadow-xl transition-shadow duration-200">
                        <img src="images/hotel1.png"
                            class="w-28 h-28 rounded-xl object-cover mb-4 md:mb-0 md:mr-4 shrink-0">

                        <div class="flex-1 flex flex-col justify-between">
                            <div>
                                <div class="flex justify-between items-start mb-2">
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-gray-900 font-semibold truncate">
                                            {{ $investment->package->name }}</h3>
                                        <p class="text-xs text-gray-500">Next Claim {{ $investment->next_payment }}</p>
                                    </div>
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                                        {{ $investment->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                        {{ $investment->status }}
                                    </span>
                                </div>

                                <!-- Ratings -->
                                <div class="mt-3">
                                    <p class="text-xs text-gray-600 mb-1">Rate this package</p>
                                    <div class="flex items-center justify-between">
                                        <div class="flex space-x-1">
                                            <template x-for="i in 5">
                                                <button @click="ratings[{{ $investment->id }}] = i"
                                                    class="focus:outline-none">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                        :class="i <= (ratings[{{ $investment->id }}] || 0) ?
                                                            'text-yellow-400 fill-current' : 'text-gray-300'"
                                                        viewBox="0 0 20 20" fill="currentColor">
                                                        <path
                                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                    </svg>
                                                </button>
                                            </template>
                                        </div>
                                        <span class="text-xs font-medium"
                                            :class="ratings[{{ $investment->id }}] ? 'text-gray-700' : 'text-gray-400'"
                                            x-text="ratings[{{ $investment->id }}] ? ratings[{{ $investment->id }}] + '/5' : 'Rate me'">
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <form class="mt-4 w-full" method="POST" action="{{ route('dailyTask') }}">
                                @csrf
                                <input type="hidden" name="investment_id" value="{{ $investment->id }}">
                                <input type="hidden" name="rating" x-model="ratings[{{ $investment->id }}]">
                                <button type="submit"
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 rounded-xl shadow-md transition duration-150 ease-in-out">
                                    Submit Rating
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Claim Rent Tab -->
        <div x-show="activeTab === 'rent'" class="space-y-6" x-cloak>
            @forelse($rents as $rent)
                <div
                    class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition duration-200">
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">
                                {{ $rent->property->name ?? 'Property Investment' }}</h3>
                            <p class="text-xs text-gray-500">Investment ID: #{{ $rent->id }}</p>
                        </div>
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                            {{ $rent->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ ucfirst($rent->status) }} Investment
                        </span>
                    </div>

                    <!-- Investment Stats -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                        <div class="p-3 rounded-xl bg-gray-50 border border-gray-100 text-center">
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Initial Investment</p>
                            <p class="font-semibold text-gray-900 mt-1"><x-currency-display :amount="$rent['property']['capital']" /></p>
                        </div>
                        <div class="p-3 rounded-xl bg-blue-50 border border-blue-100 text-center">
                            <p class="text-xs font-medium text-blue-600 uppercase tracking-wider">Daily Earnings</p>
                            <p class="font-semibold text-blue-800 mt-1">
                                <x-currency-display :amount="floatval($rent['property']['daily_rent'])" />
                            </p>
                            <p class="text-[10px] text-blue-500 mt-1">{{ $rent->return }}% daily rate</p>
                        </div>
                        <div class="p-3 rounded-xl bg-gray-50 border border-gray-100 text-center">
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Payment History</p>
                            <p class="font-semibold text-gray-900 mt-1">{{ $rent->days_paid }} successful
                                payment{{ $rent->days_paid != 1 ? 's' : '' }}</p>
                        </div>
                        <div class="p-3 rounded-xl bg-green-50 border border-green-100 text-center">
                            <p class="text-xs font-medium text-green-600 uppercase tracking-wider">Total Earnings</p>
                            <p class="font-semibold text-green-800 mt-1">
                                <x-currency-display :amount="floatval($rent['property']['total_rent'])" />
                            </p>
                        </div>
                    </div>

                    <button @click="claimRent({{ $rent->id }})"
                        :disabled="{{ $rent->status !== 'active' ? 'true' : 'false' }}"
                        class="w-full py-3 px-4 rounded-xl text-white font-medium transition duration-150 ease-in-out
                            {{ $rent->status === 'active' ? 'bg-blue-600 hover:bg-blue-700' : 'bg-gray-400 cursor-not-allowed' }}">
                        @if ($rent->status === 'active')
                            Claim Today's Earnings ( <x-currency-display :amount="floatval($rent['property']['daily_rent'])" />)
                        @else
                            Investment Inactive
                        @endif
                    </button>
                </div>
            @empty
                <div class="text-center py-12">
                    <h3 class="text-xl font-semibold text-gray-900">No Active Rental Investments</h3>
                    <p class="mt-2 text-sm text-gray-500 max-w-md mx-auto">You currently don't have any active property
                        investments earning rental income.</p>
                    <a href="{{ route('release') }}"
                        class="mt-6 inline-flex items-center px-4 py-2 rounded-xl bg-blue-600 text-white font-medium hover:bg-blue-700 transition">
                        Explore Rental Opportunities
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
