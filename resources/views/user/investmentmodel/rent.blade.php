<x-app-layout>
    <div class="min-h-screen bg-background px-4 py-6">

        {{-- HERO --}}
        <header class="text-center mb-8">
            <h1 class="text-2xl sm:text-3xl font-extrabold text-foreground mb-3">
                Find Your Dream Rental
            </h1>

            <p class="text-sm text-muted-foreground max-w-md mx-auto">
                Explore premium properties tailored to your investment goals.
            </p>
        </header>

        {{-- GRID (mobile-first: single column by default) --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">

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
                @endphp

                {{-- CARD --}}
                <article
                    class="bg-card border border-border rounded-3xl overflow-hidden shadow-sm hover:shadow-md transition">

                    {{-- IMAGE --}}
                    <div class="relative">

                        <img src="{{ $image }}" alt="{{ $property->name }}" class="w-full h-44 sm:h-52 object-cover">

                        {{-- PRICE BADGE --}}
                        <div
                            class="absolute top-3 left-3 bg-primary/90 text-primary-foreground text-xs font-semibold px-3 py-1 rounded-xl shadow-sm">
                            KES {{ number_format($property->capital, 2) }}
                        </div>

                    </div>

                    {{-- CONTENT --}}
                    <div class="p-4 flex flex-col gap-3">

                        <h2 class="text-base font-semibold text-foreground line-clamp-1">
                            {{ $property->name }}
                        </h2>

                        {{-- INFO CHIPS (mobile-first scroll wrap) --}}
                        <div class="flex flex-wrap gap-2 text-xs">

                            <span class="px-2 py-1 rounded-full bg-muted text-muted-foreground">
                                🏠 {{ number_format($property->daily_rent, 2) }} / day
                            </span>

                            <span class="px-2 py-1 rounded-full bg-muted text-muted-foreground">
                                📅 {{ $property->days }} days
                            </span>

                            <span class="px-2 py-1 rounded-full bg-muted text-muted-foreground">
                                💰 {{ number_format($property->total_rent, 2) }}
                            </span>

                            <span class="px-2 py-1 rounded-full bg-accent/10 text-accent">
                                🎁 {{ number_format($property->upline_bonus, 2) }}
                            </span>

                        </div>

                        {{-- ACTION --}}
                        <form method="POST" action="{{ route('release.store') }}" class="mt-2">
                            @csrf
                            <input type="hidden" name="property_id" value="{{ $property->id }}">

                            <button type="submit"
                                class="w-full h-11 rounded-2xl bg-primary text-primary-foreground font-semibold active:scale-[0.98] transition">
                                Select Property
                            </button>
                        </form>

                    </div>
                </article>

            @endforeach

        </div>
    </div>
</x-app-layout>