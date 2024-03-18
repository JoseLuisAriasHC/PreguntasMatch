import { errorInput, eliminarErrorInput, alertDiv } from './utils.js';

$(document).ready(function () {

    console.log("category-form.js abierto");

    let imageImgPreview = document.getElementById('imageImgPreview');
    // al hacer clic en la img hacer el evento click del input
    imageImgPreview.addEventListener('click', openFileInput);
    function openFileInput() {
        document.getElementById('image').click();
    }

    // cambiar el titulo en el preview
    let title = document.getElementById('title');
    let titlePreview = document.getElementById('titlePreview');
    title.addEventListener('change', function (e) {
        titlePreview.innerText = title.value
    });

    // Borrar img
    let deleteImgBtn = document.getElementById('deleteImg');
    deleteImgBtn.addEventListener('click', deleteImg);

    function deleteImg() {
        let img = document.getElementById('imageImgPreview');
        let checkImageStatus = document.getElementById('checkImageStatus');
        let imgInput = document.getElementById('image');
        imgInput.value = '';
        img.src = 'assets/img/no-image.png';
        checkImageStatus.value = 1
    }

    // aplicar a todos los btn la funcion de addAnswer
    $(document).on('click', '[id^="btnAddAnswer"]', function (e) {
        addAnswer(this);
    });

    function eliminarRespuesta(button) {
        let divRow = button.closest('.row');
        if (divRow) {
            divRow.remove();
        }
    }

    // añadir otra opcion para responder para cada pregunta
    function addAnswer(element) {
        let arrayid = element.id.split('-');
        let questionId = arrayid[1] + "-" + arrayid[2]; // ej:question-1
        let idCollapse = "collapse-" + questionId;
        let collapse = document.getElementById(idCollapse);
        let numAnswers = collapse.firstElementChild.childElementCount;
        let numMaxAnswers = 9;
        if (numMaxAnswers > numAnswers) {
            let answerName = 'answer-' + questionId;
            let newAnswerDiv = `
            <div class="row">
                <div class="col-sm-11 col-10">
                    <input type="text" class="form-control" name="${answerName}" placeholder="respuesta" required>
                </div>
                <button class="btn btn-danger col-sm-1 col-2" type="button" title="Borrar respuesta"> 
                    <i class="fa-solid fa-delete-left" aria-hidden="true"></i>
                </button>
            </div>
            `;
            let listAnswers = collapse.querySelector('.list_answers');
            listAnswers.insertAdjacentHTML('beforeend', newAnswerDiv);

            let lastAnswer = listAnswers.lastElementChild;
            let deleteButton = lastAnswer.querySelector('.btn-danger');
            deleteButton.addEventListener('click', function (e) {
                eliminarRespuesta(this);
            });
        } else {
            let errorContainer = document.getElementById('error');
            alertDiv("Error numero de respuestas", "No se puede crear más de " + numMaxAnswers + " respuestas", errorContainer);
        }
    }

    // añadir una nueva pregunta
    var questionCounter = document.getElementById('question_answer').childElementCount;
    function addQuestion() {
        questionCounter++;

        // obtener la lista de categorias
        let originalSelect = document.getElementById('category-question-1');
        let originalOptions = originalSelect.innerHTML;

        // Limite de 10 preguntas
        let listQuestions = document.getElementById('question_answer');
        let numQuestions = listQuestions.childElementCount;
        let numMaxQuestions = 10;

        if (numMaxQuestions > numQuestions) {
            let newQuestionDiv = `
            <div class="row gy-3 mb-3">
                <div class="col-lg-7 col-md-6 form-floating">
                    <input type="text" class="form-control" id="question-${questionCounter}" name="question-${questionCounter}" placeholder="Pregunta" required="">
                    <label for="question-${questionCounter}">Pregunta</label>
                    <div class="invalid-feedback">
                        Por favor, introduce una pregunta válida.
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 form-floating">
                    <select class="form-select" id="category-question-${questionCounter}">
                        ${originalOptions}
                    </select>
                    <label for="category-question-${questionCounter}">Categoría</label>
                </div>
                <div class="col col-lg-2 col-md-3 d-flex align-items-center justify-content-center">
                    <button class="btn btn-primary m-1" type="button" id="btnAddAnswer-question-${questionCounter}" title="Añadir respuesta">
                        <i class="fa-solid fa-circle-plus" aria-hidden="true"></i>
                    </button>
                    <a class="btn btn-secondary" data-bs-toggle="collapse" href="#collapse-question-${questionCounter}" role="button" aria-expanded="false" aria-controls="collapse-question-${questionCounter}" title="Mostrar respuestas">
                        <i class="fa-solid fa-chevron-down" aria-hidden="true"></i>
                    </a>
                    <button class="btn btn-danger m-1 delete_question" type="button" title="Borrar pregunta">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
                <div class="collapse" id="collapse-question-${questionCounter}">
                    <div class="list_answers">
                        <div>
                            <input type="text" class="form-control" name="answer-question-${questionCounter}" placeholder="respuesta" required>
                            <div class="invalid-feedback">
                                Por favor, introduce una respuesta.
                            </div>
                        </div>
                        <div>
                            <input type="text" class="form-control" name="answer-question-${questionCounter}" placeholder="respuesta" required>
                             <div class="invalid-feedback">
                                Por favor, introduce una respuesta.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
            // Añadir la pregunta a la lista
            let listQuestionsContainer = document.getElementById("question_answer");
            listQuestionsContainer.insertAdjacentHTML('beforeend', newQuestionDiv);

            // Activar la funcion de eliminar pregunta
            let btnDeleteQuestionList = document.querySelectorAll('button.delete_question');
            let lastBtn = btnDeleteQuestionList[btnDeleteQuestionList.length - 1];
            lastBtn.addEventListener('click', function () {
                deleteQuestion(lastBtn);
            })
        } else {
            let errorContainer = document.getElementById('error');
            alertDiv("Error numero de preguntas", "No se puede crear mas de " + numMaxQuestions + " preguntas", errorContainer);
        }

    }

    let btnAddQuestion = document.getElementById("btnAddQuestion");
    btnAddQuestion.addEventListener("click", addQuestion);

    // validacion del formulario compleo y de cada input
    let form = document.getElementById('testForm');
    checkInputsForm(form, 'ajax/validate-form-test.php');
    handleFormSubmit(form, 'ajax/validate-form-test.php');

    function sendFormData(url, data, input) {
        return fetch(url, {
            method: 'POST',
            body: data
        })
            .then(res => res.json())
            .then(datos => handleResponse(datos, input))
            .catch(error => console.error('Error en la solicitud fetch:', error));
    }

    //validar el cambibio de cada input
    function checkInputsForm(form, url) {
        form.addEventListener("change", function (e) {
            let input = e.target;
            let datos = new FormData();

            // Manejar múltiples inputs
            if (input.type == "file") {
                datos.append(input.id, input.files[0]);
            } else {
                if (input.id) {
                    datos.append(input.id, input.value);
                } else {
                    datos.append(input.name, input.value);
                }
            }

            sendFormData(url, datos, input);
        });
    }

    //validar el form completo
    function handleFormSubmit(form, url) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            e.stopPropagation();

            if (form.checkValidity()) {
                let datos = new FormData();
                form.querySelectorAll('input, textarea, select').forEach(function (input) {
                    // Manejar múltiples inputs
                    if (input.type == "file") {
                        if (input.files.length > 0) {
                            datos.append(input.id, input.files[0]);
                        }
                    } else {
                        if (input.id) {
                            datos.append(input.id, input.value);
                        } else {
                            // Almacenar los valores en un array en FormData si ya existe
                            if (datos.has(input.name)) {
                                // Obtener el valor actual del FormData y actualizarlo
                                let existingValue = datos.getAll(input.name);
                                existingValue.push(input.value);
                                datos.set(input.name, existingValue);
                            } else {
                                // almacenar el valor como un array cuando el name aparece por primera vez
                                datos.append(input.name, [input.value]);
                            }
                        }
                    }
                });

                sendFormData(url, datos);
            }

            form.classList.add("was-validated");
        });
    }

    function handleResponse(datos, input = null) {
        switch (datos['status']) {
            case 200:
                if (input != null) {
                    // borrar el error si aun persiste
                    let error = document.getElementById("error");
                    error.innerHTML = "";
                    if (input.type == "file") {
                        // leer el archivo con la clase FileReader para obtener su src y mostralo en el preview
                        let reader = new FileReader();
                        reader.onload = function (e) {
                            let imageImgPreview = document.getElementById('imageImgPreview');
                            imageImgPreview.src = e.target.result;
                        };
                        reader.readAsDataURL(input.files[0]);
                    } else {
                        // el try es para ignorar el error a la hora de 
                        // eliminar el invalid-feedback producido porque el select no cuenta con uno
                        try {
                            eliminarErrorInput(input);
                        } catch (error) {
                        }
                    }
                } else {
                    window.history.back();
                }
                break;
            case 400:
                console.log(datos);
                handleErrors(datos['errors']);
                break;
            default:
                break;
        }
    }

    function handleErrors(errors) {
        let errorContainer = document.getElementById('error');

        for (let idElement in errors) {
            let message = errors[idElement];
            let element = document.getElementById(idElement);

            if (idElement == "image") {
                alertDiv("Error tipo de fichero", message, errorContainer);
                deleteImg();
            } else if (idElement == "answer-question") {
                alertDiv("Error faltan datos", message, errorContainer);
            } else {
                errorInput(element, message);
            }
        }
    }

    function deleteQuestion(button) {
        let divPadre = button.closest('.row.gy-3.mb-3');
        divPadre.remove();
    }

    // Poner la funcion cuando editan
    let deleteAnswerBtn = document.querySelectorAll('.list_answers .btn-danger');
    deleteAnswerBtn.forEach(button => {
        button.addEventListener('click', function () {
            eliminarRespuesta(this);
        });
    });

    let deleteQuestionBtn = document.querySelectorAll('button.delete_question');
    deleteQuestionBtn.forEach(button => {
        button.addEventListener('click', function () {
            deleteQuestion(this);
        });
    });


});


