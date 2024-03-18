$(document).ready(function () {
    console.log("Main.js abierto");
    // iniciacion de AOS
    AOS.init({
        once: true,
    });

});

const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl, {
    html: true, // Permite contenido HTML
}));



