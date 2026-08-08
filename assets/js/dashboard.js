/* ==========================================================
   HANJARI'S MUSIC HOUSE STOCK MAINTENANCE SYSTEM
   Dashboard JavaScript
   dashboard.js
========================================================== */

document.addEventListener("DOMContentLoaded", () => {

    /* ==========================================
       Animated Counter Cards
    ========================================== */

    document.querySelectorAll(".card-box h2").forEach(counter => {

        const target = parseInt(counter.textContent.replace(/,/g, ""));

        if (isNaN(target)) return;

        let current = 0;

        const increment = Math.max(1, Math.ceil(target / 80));

        const updateCounter = () => {

            current += increment;

            if (current >= target) {

                counter.textContent = target.toLocaleString();

                return;

            }

            counter.textContent = current.toLocaleString();

            requestAnimationFrame(updateCounter);

        };

        updateCounter();

    });

    /* ==========================================
       Greeting
    ========================================== */

    const greeting = document.getElementById("greeting");

    if (greeting) {

        const hour = new Date().getHours();

        let message = "";

        if (hour < 12) {

            message = "☀️ Good Morning";

        } else if (hour < 17) {

            message = "🌤 Good Afternoon";

        } else {

            message = "🌙 Good Evening";

        }

        greeting.textContent = message;

    }

    /* ==========================================
       Current Date & Time
    ========================================== */

    const dateElement = document.getElementById("currentDate");

    if (dateElement) {

        const updateClock = () => {

            const now = new Date();

            dateElement.textContent = now.toLocaleString();

        };

        updateClock();

        setInterval(updateClock, 1000);

    }

    /* ==========================================
       Highlight Today's Activities
    ========================================== */

    document.querySelectorAll("table tbody tr").forEach(row => {

        const firstCell = row.querySelector("td");

        if (!firstCell) return;

        const today = new Date().toISOString().split("T")[0];

        if (firstCell.textContent.trim() === today) {

            row.style.backgroundColor = "#FFF8E1";

            row.style.fontWeight = "600";

        }

    });

    /* ==========================================
       Progress Bar Animation
    ========================================== */

    document.querySelectorAll(".progress-bar").forEach(bar => {

        const value = bar.getAttribute("aria-valuenow") || 0;

        bar.style.width = "0%";

        setTimeout(() => {

            bar.style.transition = "width 1.2s ease";

            bar.style.width = value + "%";

        }, 300);

    });

    /* ==========================================
       Dashboard Card Hover
    ========================================== */

    document.querySelectorAll(".card-box").forEach(card => {

        card.addEventListener("mouseenter", () => {

            card.style.transform = "translateY(-6px)";

            card.style.boxShadow = "0 18px 30px rgba(0,0,0,.12)";

        });

        card.addEventListener("mouseleave", () => {

            card.style.transform = "translateY(0)";

            card.style.boxShadow = "";

        });

    });

    /* ==========================================
       Fade In Dashboard
    ========================================== */

    document.querySelectorAll(".card-box,.card,.table").forEach((item, index) => {

        item.style.opacity = "0";

        item.style.transform = "translateY(15px)";

        item.style.transition = ".45s ease";

        setTimeout(() => {

            item.style.opacity = "1";

            item.style.transform = "translateY(0)";

        }, index * 120);

    });

    /* ==========================================
       Refresh Dashboard Button
    ========================================== */

    const refresh = document.getElementById("refreshDashboard");

    if (refresh) {

        refresh.addEventListener("click", () => {

            refresh.innerHTML =
                '<i class="fa-solid fa-spinner fa-spin"></i> Refreshing...';

            setTimeout(() => {

                location.reload();

            }, 800);

        });

    }

    /* ==========================================
       Welcome Card Animation
    ========================================== */

    const welcomeCard = document.querySelector(".alert");

    if (welcomeCard) {

        welcomeCard.animate([

            {
                opacity: 0,
                transform: "translateY(-15px)"
            },

            {
                opacity: 1,
                transform: "translateY(0)"
            }

        ], {

            duration: 700,

            easing: "ease-out"

        });

    }

});