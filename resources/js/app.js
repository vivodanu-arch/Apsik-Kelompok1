import "./bootstrap";

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

document.addEventListener("DOMContentLoaded", () => {
    console.log("JS Loaded");

    // CARD POP UP
    const card = document.getElementById("mainCard");
    if (card) {
        setTimeout(() => {
            card.classList.add("show");
        }, 200);
    }

<<<<<<< HEAD
    document.querySelectorAll("a[data-transition]").forEach(link => {
        link.addEventListener("click", function(e) {
=======
    document.querySelectorAll("a[data-transition]").forEach((link) => {
        link.addEventListener("click", function (e) {
>>>>>>> 2b8a082 (tes)
            const target = this.href;

            e.preventDefault();

            document.body.classList.add("fade-out");

            setTimeout(() => {
                window.location.href = target;
            }, 200);
        });
    });
<<<<<<< HEAD
});
=======
});
>>>>>>> 2b8a082 (tes)
