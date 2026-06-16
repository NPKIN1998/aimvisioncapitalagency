<!-- Toast Container -->
<div x-data="toastManager()" @notify.window="add($event.detail)"
    class="fixed inset-0 z-[9999] flex items-center justify-center pointer-events-none px-4">
    <div class="space-y-3 w-full max-w-sm">
        <template x-for="toast in toasts" :key="toast.id">
            <div x-show="toast.visible" x-transition.opacity.duration.300ms @mouseenter="pause(toast.id)"
                @mouseleave="resume(toast.id)"
                class="relative pointer-events-auto flex items-start gap-3 p-4 rounded-2xl border shadow-lg overflow-hidden bg-card"
                :class="toastClass(toast.type)">
                <!-- Bootstrap Icon -->
                <div class="shrink-0 pt-0.5">
                    <i class="text-lg" :class="[iconClass(toast.type), iconName(toast.type)]"></i>
                </div>

                <!-- Content -->
                <div class="flex-1 min-w-0">
                    <h3 x-text="toast.title" class="font-semibold text-sm text-foreground"></h3>

                    <p x-text="toast.message" class="text-sm text-muted-foreground mt-1"></p>
                </div>

                <!-- Close -->
                <button @click="remove(toast.id)" class="text-muted-foreground hover:text-foreground transition">
                    <i class="bi bi-x-lg"></i>
                </button>

                <!-- Progress -->
                <div class="absolute bottom-0 left-0 h-1 w-full bg-border">
                    <div class="h-full transition-all duration-100 ease-linear" :class="progressBarClass(toast.type)"
                        :style="'width:' + (toast.progress || 100) + '%'"></div>
                </div>
            </div>
        </template>
    </div>
</div>