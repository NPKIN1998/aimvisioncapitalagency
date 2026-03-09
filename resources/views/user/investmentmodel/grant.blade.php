<x-app-layout>
    <div class="max-w-3xl mx-auto p-4 sm:p-6 lg:p-8">
        <!-- Form Card -->
        <div class="bg-white shadow-lg rounded-xl p-6 sm:p-8">
            <h2 class="text-2xl font-extrabold text-gray-800 text-center sm:text-3xl mb-2">Grant Application</h2>
            <p class="text-sm text-gray-500 text-center mb-6">
                Fill out the form below to apply for a grant. Ensure all details are accurate.
            </p>

            <form class="space-y-5" method="POST" action="{{ route('grant.store') }}">
                @csrf

                <!-- Phone Number Field -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Registered Phone Number</label>
                    <input type="tel" name="phone"
                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                        value="{{ Auth::user()->phone }}" readonly>
                </div>

                <!-- Grant Amount Field -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Requested Grant Amount (KES)</label>
                    <input type="number" name="amount" min="2500"
                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                        placeholder="Enter amount you wish to apply for">
                    <p class="text-xs text-gray-400 mt-1">Minimum amount is KES 2,500</p>
                </div>

                <!-- Submit Button -->
                <div class="mt-4">
                    <button type="submit"
                        class="w-full py-3 bg-primary text-white font-semibold rounded-lg shadow hover:bg-blue-700 transform hover:scale-105 transition duration-200">
                        Apply for Grant
                    </button>
                </div>
            </form>
        </div>

        <!-- Grants Table -->
        <div class="mt-10">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Your Grant Requests</h2>
            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead class="bg-gray-100 rounded-t-lg">
                        <tr>
                            <th class="px-4 py-3 text-left text-gray-700 text-sm font-medium">Amount (KES)</th>
                            <th class="px-4 py-3 text-left text-gray-700 text-sm font-medium">Status</th>
                            <th class="px-4 py-3 text-left text-gray-700 text-sm font-medium">Return (KES)</th>
                            <th class="px-4 py-3 text-left text-gray-700 text-sm font-medium">Applied On</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($grants as $grant)
                            <tr class="hover:bg-gray-50 transition duration-150">
                                <td class="px-4 py-3 text-sm text-gray-700">{{ number_format($grant->capital, 2) }}</td>
                                <td class="px-4 py-3 text-sm">
                                    <span
                                        class="px-2 py-1 rounded-full text-xs font-semibold
                                        @if ($grant->status === 'active') bg-green-100 text-green-800
                                        @elseif($grant->status === 'pending') bg-yellow-100 text-yellow-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ $grant->status }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ number_format($grant->return, 2) }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $grant->date->format('M d, Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-gray-400 py-4 text-sm">No grants found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
