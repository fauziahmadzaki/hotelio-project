import "./bootstrap";

// Toggle menu (mobile navbar)
document.addEventListener("DOMContentLoaded", () => {
    const openBtn = document.getElementById("openBtn");
    const closeBtn = document.getElementById("closeBtn");
    const menu = document.getElementById("menu");

    if (openBtn && closeBtn && menu) {
        openBtn.addEventListener("click", () => {
            menu.classList.remove("max-h-0");
            menu.classList.add("max-h-96");
            openBtn.classList.add("hidden");
            closeBtn.classList.remove("hidden");
        });

        closeBtn.addEventListener("click", () => {
            menu.classList.add("max-h-0");
            menu.classList.remove("max-h-96");
            openBtn.classList.toggle("hidden");
            closeBtn.classList.toggle("hidden");
        });
    }
});
