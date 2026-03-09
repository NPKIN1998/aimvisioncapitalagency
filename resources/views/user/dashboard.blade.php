<x-app-layout>
    <div class="container mx-auto px-4 py-6 bg-gray-50">

        <!-- Professional Balance Card -->
        <div x-data="{
            showBalance: false,
            isLoading: false,
            toggleBalance() {
                this.isLoading = true;
                setTimeout(() => {
                    this.showBalance = !this.showBalance;
                    this.isLoading = false;
                }, 300);
            }
        }"
            class="relative w-full mx-auto bg-linear-to-r from-indigo-600 to-purple-600 text-white rounded-3xl shadow-2xl overflow-hidden p-6 sm:p-8 md:p-10 flex flex-col items-center">

            <!-- Animated Gradient Overlay -->
            <div
                class="absolute inset-0 bg-linear-to-br from-indigo-500 via-purple-500 to-pink-500 opacity-20 animate-gradient-slow pointer-events-none rounded-3xl">
            </div>

            <!-- Background Circles -->
            <div class="absolute inset-0 opacity-10 pointer-events-none" aria-hidden="true">
                <div
                    class="absolute top-0 right-0 w-24 h-24 md:w-32 md:h-32 bg-white/20 rounded-full -translate-y-12 translate-x-12 md:-translate-y-16 md:translate-x-16 animate-float-slow">
                </div>
                <div
                    class="absolute bottom-0 left-0 w-16 h-16 md:w-24 md:h-24 bg-white/20 rounded-full translate-y-8 -translate-x-8 md:translate-y-12 md:-translate-x-12 animate-float-slow">
                </div>
            </div>

            <!-- Header -->
            <div class="flex items-center justify-between w-full mb-4 relative z-10">
                <h2 class="text-xs md:text-sm font-semibold uppercase tracking-wider text-white/80">
                    Available Balance
                </h2>
                <button @click="toggleBalance()" :disabled="isLoading"
                    :aria-label="showBalance ? 'Hide balance' : 'Show balance'" :aria-pressed="showBalance"
                    class="p-2 rounded-full bg-white/20 backdrop-blur-sm hover:bg-white/30 focus:outline-none focus:ring-2 focus:ring-white/50 transition transform hover:scale-105">
                    <template x-if="isLoading">
                        <i class="bi bi-arrow-repeat animate-spin text-lg md:text-xl text-white"></i>
                    </template>
                    <template x-if="!isLoading">
                        <i :class="showBalance ? 'bi-eye-slash' : 'bi-eye'"
                            class="text-lg md:text-xl transition-colors"></i>
                    </template>
                </button>
            </div>

            <!-- Balance Display -->
            <div
                class="text-3xl md:text-4xl font-bold mb-5 md:mb-6 min-h-[2.5rem] md:min-h-[3rem] flex items-center relative z-10">
                <!-- Visible Balance -->
                <template x-if="showBalance">
                    <div class="flex items-baseline fade-in transition-opacity duration-500">
                        <span class="sr-only">Your balance is</span>
                        <x-currency-display :amount="Auth::user()->balance" />
                    </div>
                </template>

                <!-- Hidden Balance Skeleton -->
                <template x-if="!showBalance">
                    <div class="flex space-x-2 fade-in transition-opacity duration-500" aria-hidden="true">
                        <span class="w-10 h-6 md:w-12 md:h-8 bg-white/30 rounded-lg animate-pulse"></span>
                        <span class="w-14 h-6 md:w-16 md:h-8 bg-white/30 rounded-lg animate-pulse"></span>
                        <span class="w-16 h-6 md:w-20 md:h-8 bg-white/30 rounded-lg animate-pulse"></span>
                    </div>
                </template>
            </div>

            <!-- Action Buttons -->
            <div class="mt-6 flex flex-col sm:flex-row gap-4 w-full">
                <a href="{{ route('deposit') }}"
                    class="flex-1 bg-white text-indigo-600 font-semibold py-3 rounded-xl text-center shadow-md hover:shadow-xl transition-all hover:-translate-y-1 hover:scale-105">
                    Deposit
                </a>
                <a href="{{ route('cashout') }}"
                    class="flex-1 bg-white text-purple-600 font-semibold py-3 rounded-xl text-center shadow-md hover:shadow-xl transition-all hover:-translate-y-1 hover:scale-105">
                    Withdraw
                </a>
            </div>
        </div>

        <!-- Tailwind Animations -->
        <style>
            /* Fade-in animation */
            .fade-in {
                opacity: 0;
                animation: fadeIn 0.5s forwards;
            }

            @keyframes fadeIn {
                to {
                    opacity: 1;
                }
            }

            /* Floating circles */
            @keyframes float {

                0%,
                100% {
                    transform: translateY(0)
                }

                50% {
                    transform: translateY(-10px)
                }
            }

            .animate-float-slow {
                animation: float 6s ease-in-out infinite;
            }

            /* Gradient overlay animation */
            @keyframes gradient {
                0% {
                    background-position: 0% 50%
                }

                50% {
                    background-position: 100% 50%
                }

                100% {
                    background-position: 0% 50%
                }
            }

            .animate-gradient-slow {
                background-size: 400% 400%;
                animation: gradient 15s ease infinite;
            }
        </style>





        <!-- Action Buttons Section -->
        <div class="mt-8 grid grid-cols-3 md:grid-cols-6 gap-5">
            @php
                $actions = [
                    [
                        'route' => 'plan',
                        'label' => 'Plan',
                        'icon' => 'bi-card-list',
                        'bg' => 'bg-orange-200 hover:bg-orange-300',
                        'text' => 'text-orange-700',
                    ],
                    [
                        'route' => 'grant',
                        'label' => 'Grant',
                        'icon' => 'bi-gift',
                        'bg' => 'bg-red-200 hover:bg-red-300',
                        'text' => 'text-red-700',
                    ],
                    [
                        'route' => 'cashout',
                        'label' => 'Withdraw',
                        'icon' => 'bi-cash-stack',
                        'bg' => 'bg-yellow-200 hover:bg-yellow-300',
                        'text' => 'text-yellow-700',
                    ],
                    [
                        'route' => 'deposit',
                        'label' => 'Deposit',
                        'icon' => 'bi-wallet2',
                        'bg' => 'bg-sky-200 hover:bg-sky-300',
                        'text' => 'text-sky-700',
                    ],
                    [
                        'route' => 'release',
                        'label' => 'Rental',
                        'icon' => 'bi-building',
                        'bg' => 'bg-purple-200 hover:bg-purple-300',
                        'text' => 'text-purple-700',
                    ],
                    [
                        'route' => 'task',
                        'label' => 'Task',
                        'icon' => 'bi-list-task',
                        'bg' => 'bg-green-200 hover:bg-green-300',
                        'text' => 'text-green-700',
                    ],
                ];
            @endphp

            @foreach ($actions as $action)
                <a href="{{ route($action['route']) }}"
                    class="{{ $action['bg'] }} rounded-2xl p-4 flex flex-col items-center justify-center shadow-md hover:shadow-xl transition-transform transform hover:scale-105">
                    <div class="h-12 w-12 rounded-full bg-white flex items-center justify-center shadow-inner">
                        <i class="bi {{ $action['icon'] }} text-2xl {{ $action['text'] }}"></i>
                    </div>
                    <p class="mt-2 text-sm font-semibold text-gray-900 text-center">
                        {{ $action['label'] }}
                    </p>
                </a>
            @endforeach
        </div>


        <!-- Recent Transactions Section -->
        <div class="mt-10 bg-white shadow-md rounded-3xl p-6">
            <div class="flex justify-between items-center mb-6">
                <p class="text-xl font-bold text-gray-900">Recent Transactions</p>
                <a href="{{ route('transactions') }}"
                    class="text-indigo-500 font-medium text-sm hover:text-indigo-600 transition duration-300">
                    View All
                </a>
            </div>

            @if ($transactions->isEmpty())
                <div class="flex flex-col items-center justify-center py-10 text-gray-400">
                    <i class="bi bi-exclamation-circle text-4xl mb-4"></i>
                    <p class="text-sm">No transactions yet.</p>
                </div>
            @else
                <div class="flex flex-col divide-y divide-gray-200">
                    @foreach ($transactions as $transaction)
                        @php
                            $typeValue =
                                $transaction->type instanceof \App\Enums\TransactionType
                                    ? $transaction->type->value
                                    : $transaction->type;

                            $typeClasses = [
                                'deposit' => ['bg-green-100', 'text-green-600', 'Deposit'],
                                'withdrawal' => ['bg-blue-100', 'text-blue-600', 'Withdrawal'],
                                'investment' => ['bg-purple-100', 'text-purple-600', 'Job Payment'],
                                'referral_bonus' => ['bg-indigo-100', 'text-indigo-600', 'Referral Bonus'],
                                'wealth_fund' => ['bg-amber-100', 'text-amber-600', 'Wealth Fund'],
                                'task_reward' => ['bg-amber-100', 'text-amber-600', 'Task Reward'],
                            ];

                            $statusConfig = [
                                'completed' => ['bg-green-400', 'text-green-600'],
                                'approved' => ['bg-green-400', 'text-green-600'],
                                'healthy' => ['bg-green-400', 'text-green-600'],
                                'pending' => ['bg-yellow-400', 'text-yellow-600'],
                                'failed' => ['bg-red-400', 'text-red-600'],
                                'active' => ['bg-blue-400', 'text-blue-600'],
                            ];

                            $typeConfig = $typeClasses[$typeValue] ?? $typeClasses['deposit'];
                            $status = $transaction->status ?? 'pending';
                            $statusConfig = $statusConfig[$status] ?? $statusConfig['pending'];

                            $currencySymbol = is_array($currency) ? $currency['symbol'] : $currency->symbol;
                            $currencyRate = is_array($currency) ? $currency['rate'] : $currency->rate;

                            $amountSign = in_array($typeValue, ['withdrawal', 'investment']) ? '-' : '+';
                        @endphp

                        <div class="flex items-center py-3">
                            <div class="relative shrink-0 mr-4">
                                <div
                                    class="w-10 h-10 rounded-full {{ $typeConfig[0] }} flex items-center justify-center">
                                    <span class="text-xs font-bold {{ $typeConfig[1] }}">
                                        {{ substr($typeConfig[2], 0, 1) }}
                                    </span>
                                </div>
                                <div
                                    class="absolute -bottom-1 -right-1 w-3 h-3 rounded-full border border-gray-100 {{ $statusConfig[0] }}">
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-800">{{ $typeConfig[2] }}</p>
                                <p class="text-xs text-gray-500">
                                    {{ $amountSign }} {{ $currencySymbol }}
                                    {{ number_format($transaction->amount * $currencyRate, 2) }}
                                    • {{ \Carbon\Carbon::parse($transaction->created_at)->diffForHumans() }}
                                </p>
                            </div>
                            <span class="text-xs font-semibold {{ $statusConfig[1] }}">
                                {{ ucfirst($status) }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>


    </div>
</x-app-layout>
