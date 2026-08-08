/* ==========================================================
   HANJARI'S MUSIC HOUSE STOCK MAINTENANCE SYSTEM
   validation.js
========================================================== */

document.addEventListener("DOMContentLoaded", () => {

    /* ==========================================
       Required Field Validation
    ========================================== */

    document.querySelectorAll("form").forEach(form => {

        form.addEventListener("submit", function (e) {

            let valid = true;

            this.querySelectorAll("[required]").forEach(field => {

                field.classList.remove("is-invalid");
                field.classList.remove("is-valid");

                if (field.value.trim() === "") {

                    field.classList.add("is-invalid");

                    valid = false;

                } else {

                    field.classList.add("is-valid");

                }

            });

            if (!valid) {

                e.preventDefault();

                alert("Please complete all required fields.");

                return;

            }

            /* Prevent Double Submission */

            const submitButton = this.querySelector("button[type='submit']");

            if (submitButton) {

                submitButton.disabled = true;

                submitButton.innerHTML =
                    '<i class="fa-solid fa-spinner fa-spin"></i> Saving...';

            }

        });

    });

    /* ==========================================
       Email Validation
    ========================================== */

    document.querySelectorAll("input[type='email']").forEach(email => {

        email.addEventListener("input", function () {

            const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (this.value === "") {

                this.classList.remove("is-valid", "is-invalid");

                return;

            }

            if (regex.test(this.value)) {

                this.classList.add("is-valid");

                this.classList.remove("is-invalid");

            } else {

                this.classList.add("is-invalid");

                this.classList.remove("is-valid");

            }

        });

    });

    /* ==========================================
       Phone Number Validation
    ========================================== */

    document.querySelectorAll("input[name='phone']").forEach(phone => {

        phone.addEventListener("input", function () {

            this.value = this.value.replace(/[^\d+]/g, "");

            const regex = /^(\+254|0)[17]\d{8}$/;

            if (this.value === "") {

                this.classList.remove("is-valid", "is-invalid");

                return;

            }

            if (regex.test(this.value)) {

                this.classList.add("is-valid");

                this.classList.remove("is-invalid");

            } else {

                this.classList.add("is-invalid");

                this.classList.remove("is-valid");

            }

        });

    });

    /* ==========================================
       Password Strength
    ========================================== */

    document.querySelectorAll("input[type='password']").forEach(password => {

        password.addEventListener("input", function () {

            const value = this.value;

            let score = 0;

            if (value.length >= 8) score++;

            if (/[A-Z]/.test(value)) score++;

            if (/[a-z]/.test(value)) score++;

            if (/[0-9]/.test(value)) score++;

            if (/[^A-Za-z0-9]/.test(value)) score++;

            if (value === "") {

                this.classList.remove("is-valid", "is-invalid");

                return;

            }

            if (score >= 4) {

                this.classList.add("is-valid");

                this.classList.remove("is-invalid");

            } else {

                this.classList.add("is-invalid");

                this.classList.remove("is-valid");

            }

        });

    });

    /* ==========================================
       Confirm Password
    ========================================== */

    const password = document.getElementById("password");

    const confirm = document.getElementById("confirm_password");

    if (password && confirm) {

        confirm.addEventListener("input", function () {

            if (this.value === "") {

                this.classList.remove("is-valid", "is-invalid");

                return;

            }

            if (this.value === password.value) {

                this.classList.add("is-valid");

                this.classList.remove("is-invalid");

            } else {

                this.classList.add("is-invalid");

                this.classList.remove("is-valid");

            }

        });

    }

    /* ==========================================
       Numbers Only
    ========================================== */

    document.querySelectorAll("input[type='number']").forEach(number => {

        number.addEventListener("input", function () {

            if (parseFloat(this.value) < 0) {

                this.value = "";

            }

        });

    });

    /* ==========================================
       Price Validation
    ========================================== */

    document.querySelectorAll("input[name='price']").forEach(price => {

        price.addEventListener("input", function () {

            if (parseFloat(this.value) < 0) {

                this.value = "";

            }

        });

    });

    /* ==========================================
       Quantity Validation
    ========================================== */

    document.querySelectorAll("input[name='quantity']").forEach(quantity => {

        quantity.addEventListener("input", function () {

            if (parseInt(this.value) < 0) {

                this.value = "";

            }

        });

    });

    /* ==========================================
       Auto Capitalize Names
    ========================================== */

    document.querySelectorAll(
        "input[name='full_name'],input[name='instrument_name'],input[name='category_name'],input[name='supplier_name']"
    ).forEach(field => {

        field.addEventListener("blur", function () {

            this.value = this.value.replace(/\b\w/g, c => c.toUpperCase());

        });

    });

    /* ==========================================
       Character Counter
    ========================================== */

    document.querySelectorAll("textarea").forEach(textarea => {

        const counter = document.createElement("small");

        counter.className = "text-muted";

        textarea.parentNode.appendChild(counter);

        const updateCounter = () => {

            counter.textContent =
                textarea.value.length + " characters";

        };

        textarea.addEventListener("input", updateCounter);

        updateCounter();

    });

});