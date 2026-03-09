<x-app-layout>
    <div class="container mx-auto px-4 pb-12 max-w-7xl">
        <!-- Hero Section -->
        <header class="mb-12 text-center">
            <h1
                class="text-3xl sm:text-4xl md:text-5xl font-extrabold mb-4 bg-linear-to-r from-blue-600 to-purple-600 text-transparent bg-clip-text animate-gradient">
                Find Your Dream Rental
            </h1>
            <p class="text-gray-500 max-w-2xl mx-auto text-sm sm:text-base">
                Explore our hand-picked collection of premium properties that match your lifestyle.
            </p>
        </header>

        <!-- Property Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @foreach ($properties as $property)
                @php
                    $imageMap = [
                        'Luxury Villa' => '/images/luxuryvilla.png',
                        'Modern Apartment' => '/images/modernapartment.png',
                        'Beach House' => '/images/beachhouse.png',
                        'Penthouse' => '/images/penthouse.png',
                        'Countryside Cottage' => '/images/countrysidecottage.png',
                        'Downtown Loft' => '/images/downtownloft.png',
                        'Lakefront House' => '/images/lakefronthouse.png',
                        'Suburban Home' => '/images/suburbanhome.png',
                    ];
                    $image = $imageMap[$property->name] ?? '/images/default.png';
                    $formattedCapital = number_format($property->capital, 2);
                @endphp

                <article
                    class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition duration-300 flex flex-col border border-gray-200 hover:border-blue-400">

                    <!-- Property Image -->
                    <div class="relative w-full overflow-hidden">
                        <div class="aspect-w-4 aspect-h-3 sm:aspect-w-16 sm:aspect-h-9 lg:aspect-w-3 lg:aspect-h-2">
                            <img src="{{ $image }}" alt="{{ $property['name'] }}"
                                class="object-cover w-full h-48 transition-transform duration-500 group-hover:scale-105"
                                loading="lazy">
                        </div>
                        <div
                            class="absolute top-3 left-3 bg-blue-600 text-white text-xs sm:text-sm font-semibold px-2 py-1 rounded-md shadow-md">
                            KES {{ number_format($property['capital'], 2) }}
                        </div>
                    </div>

                    <!-- Property Details -->
                    <div class="p-5 flex-1 flex flex-col">
                        <h2 class="text-lg sm:text-xl font-semibold text-gray-800 mb-2 line-clamp-1">
                            {{ $property['name'] }}
                        </h2>

                        <div class="flex flex-wrap gap-2 mb-4 text-xs sm:text-sm">
                            <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded-full">
                                🏠 Daily Rent: KES {{ number_format($property['daily_rent'], 2) }}
                            </span>
                            <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded-full">
                                📅 Days: {{ $property['days'] }}
                            </span>
                            <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded-full">
                                💰 Total Rent: KES {{ number_format($property['total_rent'], 2) }}
                            </span>
                            <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded-full">
                                🎁 Upline Bonus: KES {{ number_format($property['upline_bonus'], 2) }}
                            </span>
                        </div>

                        <!-- Action Button (stick to bottom) -->
                        <form method="POST" action="{{ route('release.store') }}" class="mt-auto">
                            @csrf
                            <input type="hidden" name="property_id" value="{{ $property['id'] }}">
                            <button type="submit"
                                class="w-full bg-linear-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white py-2.5 rounded-lg font-semibold flex items-center justify-center gap-2 transition-all duration-300">
                                <span>Select</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</x-app-layout>
