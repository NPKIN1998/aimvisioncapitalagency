import "./bootstrap";

import Alpine from "alpinejs";

import "bootstrap-icons/font/bootstrap-icons.css";
window.Alpine = Alpine;

// Toast Manager
Alpine.data("toastManager", () => ({
    toasts: [],
    timers: {},
    add({ type = "info", title = "", message = "" }) {
        const id = Date.now();
        const toast = { id, type, title, message, visible: true };
        this.toasts.push(toast);
        this.timers[id] = setTimeout(() => this.remove(id), 5000);
    },
    remove(id) {
        const toast = this.toasts.find((t) => t.id === id);
        if (!toast) return;
        toast.visible = false;
        clearTimeout(this.timers[id]);
        delete this.timers[id];
        setTimeout(() => {
            this.toasts = this.toasts.filter((t) => t.id !== id);
        }, 300);
    },
    pause(id) {
        clearTimeout(this.timers[id]);
    },
    resume(id) {
        this.timers[id] = setTimeout(() => this.remove(id), 3000);
    },
    toastClass(type) {
        return (
            {
                success: "bg-green-50 border-green-200 text-green-800",
                error: "bg-red-50 border-red-200 text-red-800",
                warning: "bg-yellow-50 border-yellow-200 text-yellow-800",
                info: "bg-blue-50 border-blue-200 text-blue-800",
            }[type] || "bg-white border-gray-200 text-gray-800"
        );
    },
    iconClass(type) {
        return (
            {
                success: "text-green-500",
                error: "text-red-500",
                warning: "text-yellow-500",
                info: "text-blue-500",
            }[type] || "text-gray-500"
        );
    },
    iconPath(type) {
        return (
            {
                success:
                    "M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z",
                error: "M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z",
                warning:
                    "M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z",
                info: "M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9z",
            }[type] || ""
        );
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
