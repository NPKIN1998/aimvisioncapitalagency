<x-app-layout>
    <div class="max-w-3xl mx-auto px-4 py-10">

        <h1 class="text-3xl font-bold text-center text-foreground mb-3 tracking-tight">
            Customer Support
        </h1>

        <p class="text-center text-muted-foreground mb-10">
            Reach us through any of the platforms below.
        </p>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

            <!-- WhatsApp Chat -->
            <a href="{{ config('support.whatsapp_chat') }}" target="_blank"
                class="flex items-center gap-4 p-5 bg-card text-foreground border border-border rounded-lg shadow hover:shadow-md transition">
                <i class="bi bi-whatsapp text-primary text-3xl"></i>
                <div>
                    <h3 class="font-semibold text-lg">WhatsApp Chat</h3>
                    <p class="text-muted-foreground text-sm">Private support</p>
                </div>
            </a>

            <!-- WhatsApp Group -->
            <a href="{{ config('support.whatsapp_group') }}" target="_blank"
                class="flex items-center gap-4 p-5 bg-card text-foreground border border-border rounded-lg shadow hover:shadow-md transition">
                <i class="bi bi-people text-primary text-3xl"></i>
                <div>
                    <h3 class="font-semibold text-lg">WhatsApp Group</h3>
                    <p class="text-muted-foreground text-sm">Community discussions</p>
                </div>
            </a>

            <!-- WhatsApp Channel -->
            <a href="{{ config('support.whatsapp_channel') }}" target="_blank"
                class="flex items-center gap-4 p-5 bg-card text-foreground border border-border rounded-lg shadow hover:shadow-md transition">
                <i class="bi bi-broadcast text-primary text-3xl"></i>
                <div>
                    <h3 class="font-semibold text-lg">WhatsApp Channel</h3>
                    <p class="text-muted-foreground text-sm">Official announcements</p>
                </div>
            </a>

            <!-- Telegram Chat -->
            <a href="{{ config('support.telegram_chat') }}" target="_blank"
                class="flex items-center gap-4 p-5 bg-card text-foreground border border-border rounded-lg shadow hover:shadow-md transition">
                <i class="bi bi-telegram text-secondary text-3xl"></i>
                <div>
                    <h3 class="font-semibold text-lg">Telegram Chat</h3>
                    <p class="text-muted-foreground text-sm">DM support</p>
                </div>
            </a>

            <!-- Telegram Group -->
            <a href="{{ config('support.telegram_group') }}" target="_blank"
                class="flex items-center gap-4 p-5 bg-card text-foreground border border-border rounded-lg shadow hover:shadow-md transition">
                <i class="bi bi-people-fill text-secondary text-3xl"></i>
                <div>
                    <h3 class="font-semibold text-lg">Telegram Group</h3>
                    <p class="text-muted-foreground text-sm">Join our users</p>
                </div>
            </a>

            <!-- Telegram Channel -->
            <a href="{{ config('support.telegram_channel') }}" target="_blank"
                class="flex items-center gap-4 p-5 bg-card text-foreground border border-border rounded-lg shadow hover:shadow-md transition">
                <i class="bi bi-megaphone text-secondary text-3xl"></i>
                <div>
                    <h3 class="font-semibold text-lg">Telegram Channel</h3>
                    <p class="text-muted-foreground text-sm">Broadcast updates</p>
                </div>
            </a>

        </div>

        <div class="mt-14 text-center text-muted-foreground text-sm">
            We respond quickly — choose any platform.
        </div>

    </div>
</x-app-layout>
