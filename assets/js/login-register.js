import { alertDiv, eliminarErrorInput, errorInput } from './utils.js';

$(document).ready(function () {

    console.log("login.register.js abierto");

    // Abrir los modales de forma manual para evitar errores de anidacion (enfocado en abrir la galeria de icons para el register)
    let openModalButtons = document.querySelectorAll('[data-open-modal]');
    openModalButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            let idModal = button.dataset.openModal
            let nuevoModal = new bootstrap.Modal(document.getElementById(idModal));
            nuevoModal.show();
            if (idModal === "iconGalleryModal") {
                clickOnIconGallery(nuevoModal)
            }
        });
    });

    // veri si esta el login (esto para la pagina user)
    let loginForm = document.getElementById("loginForm");
    if (loginForm != null) {
        checkInputsForm("loginForm", "ajax/validate-login.php");
    }

    // veri si esta el register (esto para cuando ya este logueado y no salte un error en console)
    let registerForm = document.getElementById("registerForm");
    if (registerForm != null) {
        checkInputsForm("registerForm", "ajax/validate-register.php");
    }

    let forms = document.querySelectorAll('.modal-content form');

    //validar el cambibio de cada input
    function checkInputsForm(formID, url) {
        let form = document.getElementById(formID);
        form.addEventListener("change", function (e) {
            let input = e.target;
            let datos = new FormData();

            // Manejar múltiples inputs
            if (input.type == "file") {
                datos.append(input.id, input.files[0]);
            } else {
                datos.append(input.id, input.value);
            }

            // enviar el idUser para el edit
            let idUser = document.getElementById("idUser");
            if (idUser != null) {
                datos.append(idUser.id, idUser.value);
            }

            sendFormData(url, datos, input);
        });
    }

    function sendFormData(url, data, input) {
        return fetch(url, {
            method: 'POST',
            body: data
        })
            .then(res => res.json())
            .then(datos => handleResponse(datos, input))
            .catch(error => console.error('Error en la solicitud fetch:', error));
    }

    forms.forEach(function (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            e.stopPropagation();
            if (form.checkValidity()) {
                handleFormSubmit(form);
            }
            form.classList.add("was-validated");
        });
    });

    function handleFormSubmit(form) {
        let formId = form.id;
        let url = (formId.toLowerCase().includes("login")) ? "ajax/validate-login.php" : "ajax/validate-register.php";
        let formData = new FormData();
        let inputs = document.querySelectorAll("#" + formId + " input");
        inputs.forEach(input => {
            formData.append(input.id, input.value);
        });

        fetch(url, {
            method: 'POST',
            body: formData
        })
            .then(res => res.json())
            .then(handleResponse);
    }

    function handleResponse(datos, input = null) {
        switch (datos['status']) {
            case 200:
                if (input != null) {
                    eliminarErrorInput(input);
                } else {
                    location.reload();
                }
                break;
            case 400:
                handleFormErrors(datos['errors']);
                break;
            case 401:
                if (datos?.errors?.login != null) {
                    handleLoginErrors(datos["errors"]["login"]);
                } else {
                    alertDiv("Error código manipulado", datos["errors"]["idUser"], document.getElementById('errorDivRegister'));
                }
                break;
            default:
                break;
        }
    }

    function handleFormErrors(errors) {
        for (let idElement in errors) {
            let message = errors[idElement];
            let element = document.getElementById(idElement);
            errorInput(element, message);
        }
    }

    function handleLoginErrors(message) {
        let errorDivLogin = document.getElementById('errorDivLogin')
        let inputElements = loginForm.querySelectorAll("input");
        inputElements.forEach(element => errorInput(element, message));
        alertDiv("Inicio de sesión", message, errorDivLogin);
    }

    let showPasswordBtns = document.querySelectorAll('.showPasswordBtn');
    showPasswordBtns.forEach(function (btn) {
        let PasswordInput = btn.closest('.row').querySelector('input');

        // Agregar el evento al botón
        btn.addEventListener('click', function () {
            if (PasswordInput.type === 'password') {
                PasswordInput.type = 'text';
                btn.style.backgroundColor = '#00A88C';
            } else {
                PasswordInput.type = 'password';
                btn.style.backgroundColor = '#6c757d';

            }
        });
    });

    // Cambiar el icono seleccionado por el original y cerrar el modal
    function clickOnIconGallery(iconGalleryModal) {
        let originalImage = document.getElementById('originalImage');
        let inputIcon = document.getElementById('iconRegister');
        let iconGalleryItems = document.querySelectorAll('.icon-gallery-item');
        iconGalleryItems.forEach((iconGallery) => {
            iconGallery.addEventListener('click', () => {
                originalImage.src = iconGallery.src;
                let src = originalImage.src.split('/');
                let iconName = src[src.length - 1];
                inputIcon.value = iconName;
                iconGalleryModal.hide();
            });
        });
    }
});
