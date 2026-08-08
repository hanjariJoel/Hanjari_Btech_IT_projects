/* ==========================================================
   HANJARI'S MUSIC HOUSE STOCK MAINTENANCE SYSTEM
   app.js
========================================================== */

document.addEventListener("DOMContentLoaded", () => {

    /* ==========================================
       Delete Confirmation
    ========================================== */

    document.querySelectorAll(".delete-btn").forEach(button => {

        button.addEventListener("click", function (e) {

            if (!confirm("Are you sure you want to permanently delete this record?")) {

                e.preventDefault();

            }

        });

    });

    /* ==========================================
       Logout Confirmation
    ========================================== */

    document.querySelectorAll(".logout-btn").forEach(button => {

        button.addEventListener("click", function (e) {

            if (!confirm("Are you sure you want to logout?")) {

                e.preventDefault();

            }

        });

    });

    /* ==========================================
       Auto Close Alerts
    ========================================== */

    setTimeout(() => {

        document.querySelectorAll(".alert").forEach(alert => {

            alert.style.transition = "opacity .5s ease";

            alert.style.opacity = "0";

            setTimeout(() => {

                alert.remove();

            }, 500);

        });

    }, 5000);

    /* ==========================================
       Dashboard Card Hover
    ========================================== */

    document.querySelectorAll(".card-box").forEach(card => {

        card.addEventListener("mouseenter", () => {

            card.style.transform = "translateY(-6px)";

            card.style.boxShadow = "0 15px 30px rgba(0,0,0,.15)";

        });

        card.addEventListener("mouseleave", () => {

            card.style.transform = "translateY(0)";

            card.style.boxShadow = "";

        });

    });

    /* ==========================================
       Footer Current Year
    ========================================== */

    const year = document.getElementById("currentYear");

    if (year) {

        year.textContent = new Date().getFullYear();

    }

    /* ==========================================
       Active Sidebar Link
    ========================================== */

    const currentPage = window.location.pathname;

    document.querySelectorAll(".sidebar a").forEach(link => {

        if (currentPage.includes(link.getAttribute("href"))) {

            link.classList.add("active");

        }

    });

    /* ==========================================
       Button Loading Effect
    ========================================== */

    document.querySelectorAll("form").forEach(form => {

        form.addEventListener("submit", function () {

            const btn = form.querySelector("button[type='submit']");

            if (btn) {

                btn.disabled = true;

                btn.innerHTML =
                    '<i class="fa-solid fa-spinner fa-spin"></i> Please Wait...';

            }

        });

    });

    /* ==========================================
       Back To Top Button
    ========================================== */

    const topButton = document.getElementById("backToTop");

    if (topButton) {

        window.addEventListener("scroll", () => {

            if (window.scrollY > 300) {

                topButton.style.display = "block";

            } else {

                topButton.style.display = "none";

            }

        });

        topButton.addEventListener("click", () => {

            window.scrollTo({

                top: 0,

                behavior: "smooth"

            });

        });

    }

    /* ==========================================
       Bootstrap Tooltips
    ========================================== */

    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');

    tooltipTriggerList.forEach(el => {

        new bootstrap.Tooltip(el);

    });

    /* ==========================================
       Fade In Animation
    ========================================== */

    document.querySelectorAll(".card,.card-box,.table,.alert").forEach((element, index) => {

        element.style.opacity = "0";

        element.style.transform = "translateY(15px)";

        element.style.transition = ".5s ease";

        setTimeout(() => {

            element.style.opacity = "1";

            element.style.transform = "translateY(0)";

        }, index * 80);

    });

});