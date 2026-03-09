<!-- Toast Container -->
<div x-data="toastManager()" @notify.window="add($event.detail)"
    class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-[9999] space-y-3 pointer-events-none">

    <template x-for="toast in toasts" :key="toast.id">
        <div x-show="toast.visible" x-transition.duration.300ms @mouseenter="pause(toast.id)"
            @mouseleave="resume(toast.id)"
            class="pointer-events-auto w-80 max-w-full flex items-start gap-3 p-4 border rounded-lg shadow-lg"
            :class="toastClass(toast.type)">

            <!-- Icon -->
            <div class="shrink-0">
                <template x-if="toast.type !== 'message'">
                    <svg class="h-5 w-5 mt-1" :class="iconClass(toast.type)" fill="currentColor" viewBox="0 0 20 20">
                        <path :d="iconPath(toast.type)" />
                    </svg>
                </template>
            </div>

            <!-- Content -->
            <div class="flex-1">
                <h3 x-text="toast.title" class="text-sm font-semibold"></h3>
                <p x-text="toast.message" class="text-sm mt-0.5"></p>
            </div>

            <!-- Close Button -->
            <button @click="remove(toast.id)" class="text-gray-400 hover:text-gray-600">
                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" />
                </svg>
            </button>

        </div>
    </template>
</div>
