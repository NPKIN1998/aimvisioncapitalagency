import "./bootstrap";

import Alpine from "alpinejs";

import "bootstrap-icons/font/bootstrap-icons.css";
window.Alpine = Alpine;

// Toast Manager
/**
 * Countdown Timer Component
 */
Alpine.data("countdownTimer", (targetTimestamp) => ({
    remaining: 0,
    interval: null,
    formattedTime: "00:00:00",
    isComplete: false,

    init() {
        this.updateRemaining();

        this.interval = setInterval(() => {
            this.updateRemaining();
        }, 1000);
    },

    updateRemaining() {
        const now = Date.now();
        this.remaining = Math.max(
            0,
            Math.floor((targetTimestamp - now) / 1000),
        );

        if (this.remaining === 0) {
            clearInterval(this.interval);
            this.isComplete = true;
            this.formattedTime = "00:00:00";
            return;
        }

        const hours = Math.floor(this.remaining / 3600);
        const minutes = Math.floor((this.remaining % 3600) / 60);
        const seconds = this.remaining % 60;

        this.formattedTime =
            `${hours.toString().padStart(2, "0")}:` +
            `${minutes.toString().padStart(2, "0")}:` +
            `${seconds.toString().padStart(2, "0")}`;
    },
}));

Alpine.data("toastManager", () => ({
    toasts: [],
    timers: {},
    intervals: {},
    defaultDuration: 5000,

    add({ type = "info", title = "", message = "" }) {
        const id = Date.now();

        const toast = {
            id,
            type,
            title,
            message,
            visible: true,
            expiresAt: Date.now() + this.defaultDuration,
            progress: 100,
            paused: false,
        };

        this.toasts.push(toast);

        this.startProgressUpdater(id);

        this.timers[id] = setTimeout(() => {
            this.remove(id);
        }, this.defaultDuration);
    },

    startProgressUpdater(id) {
        this.intervals[id] = setInterval(() => {
            const toast = this.toasts.find(t => t.id === id);

            if (!toast || toast.paused) return;

            const remaining = toast.expiresAt - Date.now();

            toast.progress = Math.max(
                0,
                (remaining / this.defaultDuration) * 100
            );
        }, 50);
    },

    remove(id) {
        const toast = this.toasts.find(t => t.id === id);

        if (!toast) return;

        toast.visible = false;

        clearTimeout(this.timers[id]);
        clearInterval(this.intervals[id]);

        delete this.timers[id];
        delete this.intervals[id];

        setTimeout(() => {
            this.toasts = this.toasts.filter(t => t.id !== id);
        }, 300);
    },

    pause(id) {
        const toast = this.toasts.find(t => t.id === id);

        if (!toast) return;

        toast.paused = true;
        toast.remainingMs = toast.expiresAt - Date.now();

        clearTimeout(this.timers[id]);
        clearInterval(this.intervals[id]);
    },

    resume(id) {
        const toast = this.toasts.find(t => t.id === id);

        if (!toast) return;

        toast.paused = false;

        const remaining = toast.remainingMs;

        toast.expiresAt = Date.now() + remaining;

        this.timers[id] = setTimeout(() => {
            this.remove(id);
        }, remaining);

        this.startProgressUpdater(id);
    },

    toastClass(type) {
        return {
            success: "border-accent/20 bg-accent/5",
            error: "border-destructive/20 bg-destructive/5",
            warning: "border-chart-3/20 bg-chart-3/5",
            info: "border-primary/20 bg-primary/5",
        }[type] || "border-border bg-card";
    },

    progressBarClass(type) {
        return {
            success: "bg-accent",
            error: "bg-destructive",
            warning: "bg-chart-3",
            info: "bg-primary",
        }[type] || "bg-primary";
    },

    iconClass(type) {
        return {
            success: "text-accent",
            error: "text-destructive",
            warning: "text-chart-3",
            info: "text-primary",
        }[type] || "text-primary";
    },

    iconName(type) {
        return {
            success: "bi bi-check-circle-fill",
            error: "bi bi-x-circle-fill",
            warning: "bi bi-exclamation-triangle-fill",
            info: "bi bi-info-circle-fill",
        }[type] || "bi bi-bell-fill";
    },
}));

Alpine.data("networkDashboard", () => ({
    showShareModal: false,

    copyReferralLink() {
        const input = this.$refs.referralInput;
        if (!input) return;

        input.select();
        input.setSelectionRange(0, 99999); // For mobile

        navigator.clipboard
            .writeText(input.value)
            .then(() => {
                window.notify({
                    type: "success",
                    title: "Copied!",
                    message: "Referral link copied to clipboard.",
                });
            })
            .catch(() => {
                window.notify({
                    type: "error",
                    title: "Error!",
                    message: "Failed to copy referral link.",
                });
            });
    },

    shareReferralLink() {
        this.showShareModal = true;
    },

    shareVia(platform) {
        const url = this.$refs.referralInput?.value;
        if (!url) return;

        let shareUrl = "";
        switch (platform) {
            case "whatsapp":
                shareUrl = `https://wa.me/?text=${encodeURIComponent(url)}`;
                break;
            case "telegram":
                shareUrl = `https://t.me/share/url?url=${encodeURIComponent(
                    url
                )}`;
                break;
            case "email":
                shareUrl = `mailto:?subject=Join%20My%20Team&body=${encodeURIComponent(
                    url
                )}`;
                break;
            default:
                console.warn("Unsupported platform:", platform);
                return;
        }

        window.open(shareUrl, "_blank", "noopener,noreferrer");
    },
}));

function togglePassword() {
    const passwordInput = document.getElementById("password_confirmation");
    const eyeOpen = document.getElementById("eye-open");
    const eyeClosed = document.getElementById("eye-closed");

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        eyeOpen.classList.add("hidden");
        eyeClosed.classList.remove("hidden");
    } else {
        passwordInput.type = "password";
        eyeOpen.classList.remove("hidden");
        eyeClosed.classList.add("hidden");
    }
}

// Make notify global
window.notify = function (options) {
    window.dispatchEvent(new CustomEvent("notify", { detail: options }));
};

Alpine.start();
