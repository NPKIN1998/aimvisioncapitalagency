<x-app-layout>
    <div class="max-w-4xl mx-auto flex flex-col gap-6 pt-4 sm:pt-8 px-4 sm:px-6">

        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mb-4">
            <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-foreground">
                All Transactions
            </h1>
        </div>

        <!-- Transaction List -->
        <div class="bg-background text-foreground rounded-lg shadow-sm divide-y divide-gray-100 dark:divide-gray-700">

            @forelse ($transactions as $trx)
                <div
                    class="flex justify-between items-center p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-200">

                    <!-- Left -->
                    <div class="flex items-center gap-4">
                        <div
                            class="rounded-full bg-background border border-primary overflow-hidden
                                    w-12 h-12 sm:w-14 sm:h-14 flex items-center justify-center">
                            <img src="/mpesalogo.png" alt="mpesa" class="w-full h-full object-cover" />
                        </div>

                        <div>
                            <p class="font-semibold text-sm sm:text-base capitalize">
                                {{ $trx->type }}
                            </p>

                            <p class="text-gray-500 dark:text-gray-400 text-xs pt-1">
                                {{ $trx->created_at->format('d M Y, h:i A') }}
                            </p>

                            <p class="text-gray-500 dark:text-gray-400 text-xs">
                                Transaction ID: #{{ $trx->shortcode }}
                            </p>
                        </div>
                    </div>

                    <!-- Right -->
                    <div class="flex flex-col items-end">
                        <p class="font-semibold text-sm sm:text-base pb-1">
                            KES {{ number_format($trx->amount, 2) }}
                        </p>

                        <!-- Status Badge -->
                        @php
                            $statusColors = [
                                'pending' => 'text-orange-500 bg-orange-200',
                                'approved' => 'text-green-600 bg-green-200',
                                'rejected' => 'text-red-600 bg-red-200',
                            ];
                        @endphp

                        <span
                            class="text-xs py-0.5 px-2 rounded-md dark:bg-darkN40
                            {{ $statusColors[$trx->status] ?? 'text-gray-600 bg-gray-200' }}">
                            {{ ucfirst($trx->status) }}
                        </span>
                    </div>
                </div>

            @empty
                <div class="p-6 text-center text-gray-500 dark:text-gray-400">
                    No transactions found.
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $transactions->links() }}
        </div>

    </div>
</x-app-layout>
