import { alertDiv } from './utils.js';
$(document).ready(function () {

    console.log("test.js abierto");

    let answerList = document.querySelectorAll('.text-answer');
    let test = document.getElementById('test');
    var answerSelected = '';
    answerList.forEach(function (answer) {
        answer.addEventListener('click', function (e) {
            let answer = e.target;
            answerSelected = answer.dataset.idAnswer;
            let data = new FormData();
            data.append('answer', answer.dataset.idAnswer);
            data.append('question', test.dataset.idQuestion);
            data.append('message', test.dataset.message);
            sendFormData(data);
        });
    });

    function sendFormData(data) {
        return fetch('ajax/createResult.php', {
            method: 'POST',
            body: data
        })
            .then(res => res.json())
            .then(data => handleResponse(data))
            .catch(error => console.error('Error en la solicitud fetch:', error));
    }

    function handleResponse(data) {
        console.log(data);
        switch (data['status']) {
            case 200:
                let question_answers = document.getElementById('question_answers');
                question_answers.style.opacity = 0;
                // quitar las preguntas y respuestas
                setTimeout(function () {
                    question_answers.style.display = 'none';
                    setTimeout(function () {
                        createResultDiv(data);
                        // poner las funciones
                        document.getElementById("next").addEventListener("click", function () {
                            nextQuestion(data['response']['lastQuestion']);
                        });

                        // introducer el login y register porque primero tiene estar logueado para comentar
                        // o inicar las funciones del modal mensaje
                        if (data['response']['user'] == null) {
                            let script = document.createElement('script');
                            script.src = 'assets/js/login-register.js';
                            script.type = 'module';
                            document.body.appendChild(script);
                            messageLoginBtnError();
                        } else {
                            document.getElementById("saveMessage").addEventListener("click", saveMessage);
                            characterRestriction();
                        }
                        confChart(data['response']);

                        // Poner visible el div "resultado"
                        let resultado = document.getElementById('resultado');
                        resultado.style.display = 'flex';
                        setTimeout(function () {
                            resultado.style.opacity = 1;
                        }, 150);
                    }, 200);
                }, 850);
                break;
            case 400:
                console.log("error");
                break;
            default:
                break;
        }
    }

    // Crear grafica y configurarla
    function createResultDiv(data) {
        var randomGIF = Math.floor(Math.random() * 37) + 1;
        let newChart = `
        <div class="row" id="resultado">
            <div class="col grafico">
                <canvas id="chart"></canvas>
            </div>
            <div class="col graficoText mt-3">
                <div>
                    <h1>Hay <span>${data['response']['sameOpinion']}</span> personas que opinan lo mismo que tú</h1>
                    <img src="assets/img/gif/gif_N(${randomGIF}).gif" class="img-fluid mb-3" alt="Gif">
                    ${data['response']['message'] != '' ? `<p>Tu match te dice "<span>${data['response']['message']}</span>"</p>` : ''}
                </div>
            </div>
            <div class="text-end mt-3">
                <button class="btn btn-primary" id="next">
                    ${data['response']['lastQuestion'] != 1 ? `Siguiente pregunta` : `Finalizar Test`}
                </button>
                ${data['response']['user'] == null ? `${createLoginDiv(data)}` : `${createMessageModal()}`}
            </div>
           </div>
        </div>
        `;
        test.insertAdjacentHTML('beforeend', newChart);
    }

    function createLoginDiv(data) {
        return `
        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#loginModal" id="messageLoginBtn">
            Mensaje para tu Match
        </button>

        <div class="text-start" data-bs-theme="dark">
            <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form novalidate id="loginForm">
                            <div class="modal-header">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div id="errorDivLogin"></div>
                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control" id="emailLogin" name="emailLogin" placeholder="name@example.com" required>
                                        <label for="emailLogin">Correo electrónico</label>
                                        <div class="invalid-feedback">
                                            Por favor, introduce un correo electrónico válido.
                                        </div>
                                </div>
                                <div class="form-floating">
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-floating col">
                                                <input type="password" class="form-control" id="pwdLogin" name="pwdLogin" placeholder="Contraseña" required></input>
                                                <label for="pwdLogin">Contraseña</label>
                                                <div class="invalid-feedback">
                                                    Por favor, introduce una contraseña válida.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto d-flex align-items-center ">
                                            <button type="button" class="btn btn-secondary showPasswordBtn">
                                                <i class="fas fa-eye" style="font-size: 1.25rem;"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer d-flex justify-content-between">
                                <div>
                                    <!-- Button trigger register modal -->
                                    <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#registerModal">
                                        Crear Cuenta
                                    </button>
                                </div>
                                <div>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-primary" id="btnLoginSubmit">Iniciar sesión</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form novalidate id="registerForm">
                            <div class="modal-header">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="text-center mb-3">
                                    <div class="edit-image-container" data-open-modal="iconGalleryModal">
                                        <img src="assets/img/icons/icon_N(1).png" alt="Imagen Circular" class="rounded-circle" width="200" height="200" id="originalImage">
                                            <div class="edit-overlay">
                                                <i class="fa-solid fa-pencil" aria-hidden="true"></i>
                                            </div>
                                            <input type="text" class="form-control d-none" id="iconRegister" name="iconRegister" value="icon_N(1).png" required>
                                                <div class="invalid-feedback">
                                                    Error, en el cambio del icono.
                                                </div>
                                            </div>
                                    </div>

                                    <!-- Gallery Modal -->
                                    <div class="modal fade" id="iconGalleryModal" tabindex="-1" role="dialog" aria-labelledby="iconGalleryModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-fullscreen modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="iconGalleryModalLabel">
                                                        Iconos</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    ${(() => {
                let result = '';
                for (let i = 1; i <= data['response']['numIcons']; i++) {
                    result += `<img src="assets/img/icons/icon_N(${i}).png" alt="Icono ${i}" class="icon-gallery-item">`;
                }
                return result;
            })()
            }
                                                </div >
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                </div>
                                            </div >
                                        </div >
                                    </div >

                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="nameRegister" name="nameRegister" placeholder="paleyer1" required>
                                            <label for="nameRegister">Nombre</label>
                                            <div class="invalid-feedback">
                                                Por favor, introduce un nombre válido.
                                            </div>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control" id="emailRegister" name="nameRegister" placeholder="name@example.com" required>
                                            <label for="emailRegister">Correo electrónico</label>
                                            <div class="invalid-feedback">
                                                Por favor, introduce un correo electrónico válido.
                                            </div>
                                    </div>

                                    <div class="form-floating">
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-floating col">
                                                    <input type="password" class="form-control" id="pwdRegister" name="nameRegister" placeholder="Contraseña" required></input>
                                                    <label for="pwdRegister">Contraseña</label>
                                                    <div class="invalid-feedback">
                                                        Por favor, introduce una contraseña válida.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-auto d-flex align-items-center ">
                                                <button type="button" class="btn btn-secondary showPasswordBtn">
                                                    <i class="fas fa-eye" style="font-size: 1.25rem;"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                </div >
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-primary" id="btnRegisterSubmit">Crear cuenta</button>
                                </div>
                        </form >
                    </div >
                </div >
            </div >
            `
            ;
    }

    function createMessageModal() {
        return `
        <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#messageModel">
            Mensaje para tu Match
        </button>
        <div class="modal fade" id="messageModel" tabindex="-1" aria-labelledby="message" aria-hidden="true" data-bs-theme="dark">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fw-bold f-2 text-start">Mensaje para tu Match</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-start" id="errorMessage"></div>
                        <div class="form-floating">
                            <textarea class="form-control" placeholder="mensaje" id="message" style="height: 150px"></textarea>
                            <label for="message">Mensaje</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="saveMessage">Guardar</button>
                    </div>
                </div>
            </div>
        </div>`;
    }

    function confChart(data) {
        const grafico = document.getElementById('chart');
        let colores = ['#36A2EB', '#FF6384', '#4BC0C0', '#FFA07A', '#C9A0DC', '#77DD77', '#FFD700', '#6495ED', '#FFDAB9'];
        new Chart(grafico, {
            type: 'pie',
            data: {
                labels: data['labels'],
                datasets: [{
                    label: 'Opiniones',
                    data: data['data'],
                    backgroundColor: colores.slice(0, data['data'].length),
                    borderColor: '#fff',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        labels: {
                            color: '#fff',
                            font: {
                                size: 15
                            }
                        }
                    },
                    title: {
                        display: true,
                        color: '#ff6347',
                        text: data['title'],
                        font: {
                            size: 20
                        }
                    }
                }
            }
        });
    }

    function nextQuestion(lastQuestion) {
        let data = new FormData();
        data.append('answer', answerSelected);
        data.append('question', test.dataset.idQuestion);
        data.append('message', test.dataset.message);
        data.append('lastQuestion', lastQuestion);

        fetch('ajax/test.php', {
            method: 'POST',
            body: data
        })
            .then(r => r.json())
            .then(response => {
                switch (response['status']) {
                    case 200:
                        if (lastQuestion == 1) {
                            window.history.back();
                        } else {
                            window.location.reload();
                        }
                        break;
                    case 400:
                        window.location.reload();
                        break;
                    default:
                        break;
                }
            })
            .catch(error => console.error('Error en la solicitud fetch:', error));
    }

    function characterRestriction() {
        let textarea = document.getElementById("message");
        let maxLength = 255;
        textarea.addEventListener("input", function () {
            if (textarea.value.length > maxLength) {
                textarea.value = textarea.value.slice(0, maxLength);
                alertDiv("Error número de caracteres", "no se puede exeder de los 255 carácteres.", document.getElementById('errorMessage'));
            }
        });
    }

    function saveMessage() {
        let textarea = document.getElementById('message');
        test.setAttribute("data-message", textarea.value);
    }

    function messageLoginBtnError() {
        let messageLoginBtn = document.getElementById('messageLoginBtn');
        messageLoginBtn.addEventListener('click', function () {
            let errorDivLogin = document.getElementById('errorDivLogin');
            alertDiv("Error acceso denegado", " Debe inicar sesión para poder enviar un comentario o mensaje", errorDivLogin);
        })
    }
});

