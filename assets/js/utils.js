
console.log("utils.js importado");

export function alertDiv(tittle, message, lugar, seconds = 15) {
    let alertDiv = document.createElement("div");
    alertDiv.className = "alert alert-info alert-dismissible fade show";
    alertDiv.role = "alert";

    let strongElement = document.createElement("strong");
    strongElement.textContent = tittle + ": ";

    let messageText = document.createTextNode(message);

    let closeButton = document.createElement("button");
    closeButton.type = "button";
    closeButton.className = "btn-close";
    closeButton.setAttribute("data-bs-dismiss", "alert");
    closeButton.setAttribute("aria-label", "Close");

    alertDiv.appendChild(strongElement);
    alertDiv.appendChild(messageText);
    alertDiv.appendChild(closeButton);

    lugar.innerHTML = '';
    lugar.insertBefore(alertDiv, lugar.firstChild);

    if (seconds > 0) {
        setTimeout(function () {
            alertDiv.remove();
        }, seconds*1000);
    } 
}

export function errorInput(element, message, btnDisabled) {
    let btnSubmit = element.form.querySelector('button[type="submit"]');
    let error = "";
    if (element.closest('.form-floating')) {
        error = element.closest('.form-floating').querySelector('.invalid-feedback');
    } else {
        error = element.nextElementSibling;
    }
    element.value = "";
    error.innerHTML = message;
    element.classList.add('is-invalid');
    btnSubmit.disabled = true;
}

export function eliminarErrorInput(element) {
    let btnSubmit = element.form.querySelector('button[type="submit"]');
    let error = "";
    if (element.closest('.form-floating')) {
        error = element.closest('.form-floating').querySelector('.invalid-feedback');
    } else {
        error = element.nextElementSibling;
    }
    error.innerHTML = "";
    element.classList.remove('is-invalid');
    btnSubmit.disabled = false;
}
