<?php
require_once __DIR__ . '/models/user.php';
require_once __DIR__ . '/models/category.php';
require_once __DIR__ . '/models/test.php';
require_once __DIR__ . '/models/question.php';
require_once __DIR__ . '/models/answer.php';
session_start();

// verificar si hay un usuario logueado
$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;
// verificar si hay un user logueado
if ($user == null) {
    $_SESSION['error'] = "Necesitas estar logueado para poder crear un test.";
    prearray($_SESSION['user']);
    header('Location: index.php');
    exit;
}
// datos para el edit del test
$idTest = isset($_GET['idTest']) ? $_GET['idTest'] : null;
$test = null;
$questionsList = null;

// verificar si el test pertenece al usuario logueado
if ($idTest != null) {
    $test = Test::getById($idTest);
    if ($test->idUser != $user->idUser) {
        $_SESSION['error'] = "No puedes editar el test de otro usuario.";
        header('Location: user.php?idUser=' . $user->idUser);
        exit;
    }
    $questionsList = Question::list($idTest);
}

$categories = Category::list();

?>
<?php include __DIR__ . '/views/head.php'; ?>

<!-- Category  -->
<div class="container" id="test_form">
    <form class="row p-xs-2 p-sm-4 rounded" novalidate id="testForm">
        <div id="error"></div>

        <!-- Preview -->
        <div class="col-xl-3 col-lg-4 col-md-5">
            <div class="d-flex justify-content-between">
                <h4>Preview</h4>
                <button type="button" class="btn btn-danger text-end" title="Borrar imagen" id="deleteImg"><i class="fas fa-times"></i></button>
            </div>
            <div class="card category-card">
                <img src="<?php echo $test != null && $test->image != null ? 'uploads/usuarios/' . $test->idUser . '/test/' . $test->idTest . '-' . $test->image : 'assets/img/no-image.png' ?>" alt="Portada" id="imageImgPreview">
                <input type="file" id="image" accept="image/*" style="display: none">
                <input type="text" value="0" id="checkImageStatus" name="checkImageStatus" style="display: none">
                <div class="card-body">
                    <h5 class="card-title mb-0" id="titlePreview">
                        <?php echo $test == null ? 'Título' : $test->title ?>
                    </h5>
                </div>
            </div>
        </div>

        <!-- input titulo y descripcion -->
        <div class="col-xl-9 col-lg-8 col-md-7 mb-3">
            <?php if ($idTest != null) : ?>
                <input type="text" name="idTest" id="idTest" value="<?= e($idTest) ?>" style="display: none;">
            <?php endif; ?>
            <div>
                <label for="title" class="form-label">Título</label>
                <input type="text" class="form-control" id="title" placeholder="Los mejores platos" value="<?php echo $test != null ? $test->title : '' ?>" required>
                <div class="invalid-feedback">
                    Por favor, introduce un título.
                </div>
            </div>

            <div>
                <label for="description" class="form-label mt-3">Descripción</label>
                <textarea class="form-control" id="description" placeholder="Preguntas sobre ..." required style="height: 16.5rem;"><?php echo $test != null ? $test->description : '' ?></textarea>
                <div class="invalid-feedback">
                    Por favor, introduce una Descripción.
                </div>
            </div>
        </div>

        <!-- btn para añadir pregunta -->
        <div class="mb-3">
            <button class="btn btn-primary" type="button" id="btnAddQuestion">
                Añadir pregunta
            </button>
        </div>

        <!-- lista de preguntas y respuestas EDIT-->
        <?php if ($idTest != null) : ?>
            <div class="mb-3" id="question_answer">
                <?php for ($i = 0; $i < count($questionsList); $i++) : ?>
                    <div class="row gy-3 mb-3">
                        <!-- Pregunta -->
                        <div class="col-lg-<?php echo ($i > 2) ? '7' : '8'; ?> col-md-<?php echo ($i > 2) ? '6' : '7'; ?> form-floating">
                            <input type="text" class="form-control" id="question-<?= $i + 1 ?>" name="question-<?= $i + 1 ?>" placeholder="Pregunta" value="<?= e($questionsList[$i]->text) ?>">
                            <label for="question-<?= $i + 1 ?>">Pregunta</label>
                            <div class="invalid-feedback">
                                Por favor, introduce una pregunta.
                            </div>
                        </div>
                        <!-- Categorias -->
                        <div class="col-lg-3 col-md-3 form-floating">
                            <select class="form-select" id="category-question-<?= $i + 1 ?>">
                                <?php for ($j = 0; $j < count($categories); $j++) : ?>
                                    <option value="<?= e($categories[$j]["idCategory"]) ?>" <?= ($categories[$j]["idCategory"] == $questionsList[$i]->idCategory) ? "selected" : '' ?>><?= e($categories[$j]["name"]) ?></option>
                                <?php endfor; ?>
                            </select>
                            <label for="category-question-<?= $i + 1 ?>">Categoría</label>
                        </div>
                        <!-- Btn añadir respuesta y ver respuestas -->
                        <div class="col-lg-<?php echo ($i > 2) ? '2' : '1'; ?> col-md-<?php echo ($i > 2) ? '3' : '2'; ?> col-md-2 d-flex align-items-center justify-content-center">
                            <button class="btn btn-primary m-1" type="button" id="btnAddAnswer-question-<?= $i + 1 ?>" title="Añadir respuesta">
                                <i class="fa-solid fa-circle-plus"></i>
                            </button>
                            <a class="btn btn-secondary" data-bs-toggle="collapse" href="#collapse-question-<?= $i + 1 ?>" role="button" aria-expanded="false" aria-controls="collapse-question-<?= $i + 1 ?>" title="Mostrar respuestas">
                                <i class="fa-solid fa-chevron-down"></i>
                            </a>
                            <?php if ($i > 2) : ?>
                                <button class="btn btn-danger m-1 delete_question" type="button" title="Borrar pregunta">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            <?php endif; ?>
                        </div>
                        <!-- Respuestas -->
                        <div class="collapse" id="collapse-question-<?= $i + 1 ?>">
                            <div class="list_answers">
                                <?php
                                $answerList = Answer::list($questionsList[$i]->idQuestion);
                                for ($j = 0; $j < count($answerList); $j++) : ?>
                                    <?php if ($j > 1) : ?>
                                        <div class="row">
                                            <div class="col-sm-11 col-10">
                                                <input type="text" class="form-control" name="answer-question-<?= $i + 1 ?>" placeholder="respuesta" value="<?= e($answerList[$j]->text) ?>" required>
                                            </div>
                                            <button class="btn btn-danger col-sm-1 col-2" type="button" title="Borrar respuesta">
                                                <i class="fa-solid fa-delete-left" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                    <?php else : ?>
                                        <div>
                                            <input type="text" class="form-control" name="answer-question-<?= $i + 1 ?>" placeholder="respuesta" value="<?= e($answerList[$j]->text) ?>" required>
                                            <div class="invalid-feedback">
                                                Por favor, introduce una respuesta.
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php endfor; ?>
                            </div>
                        </div>
                    </div>
                <?php endfor; ?>
            </div>
            <!-- lista de preguntas y respuestas NEW-->
        <?php else : ?>
            <div class="mb-3" id="question_answer">
                <div class="row gy-3 mb-3">
                    <!-- Pregunta -->
                    <div class="col-lg-8 col-md-7 form-floating">
                        <input type="text" class="form-control" id="question-1" name="question-1" placeholder="Pregunta">
                        <label for="question-1">Pregunta</label>
                        <div class="invalid-feedback">
                            Por favor, introduce una pregunta.
                        </div>
                    </div>
                    <!-- Categorias -->
                    <div class="col-lg-3 col-md-3 form-floating">
                        <select class="form-select" id="category-question-1">
                            <?php for ($i = 0; $i < count($categories); $i++) : ?>
                                <option value="<?= e($categories[$i]["idCategory"]) ?>" <?= ($i == 0) ? "selected" : '' ?>><?= $categories[$i]["name"] ?></option>
                            <?php endfor; ?>
                        </select>
                        <label for="category-question-1">Categoría</label>
                    </div>
                    <!-- Btn añadir respuesta y ver respuestas -->
                    <div class="col-lg-1 col-md-2 d-flex align-items-center justify-content-center">
                        <button class="btn btn-primary m-1" type="button" id="btnAddAnswer-question-1" title="Añadir respuesta">
                            <i class="fa-solid fa-circle-plus"></i>
                        </button>
                        <a class="btn btn-secondary" data-bs-toggle="collapse" href="#collapse-question-1" role="button" aria-expanded="false" aria-controls="collapse-question-1" title="Mostrar respuestas">
                            <i class="fa-solid fa-chevron-down"></i>
                        </a>
                    </div>
                    <!-- Respuestas -->
                    <div class="collapse" id="collapse-question-1">
                        <div class="list_answers">
                            <div>
                                <input type="text" class="form-control" name="answer-question-1" placeholder="respuesta" required>
                                <div class="invalid-feedback">
                                    Por favor, introduce una respuesta.
                                </div>
                            </div>
                            <div>
                                <input type="text" class="form-control" name="answer-question-1" placeholder="respuesta" required>
                                <div class="invalid-feedback">
                                    Por favor, introduce una respuesta.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row gy-3 mb-3">
                    <!-- Pregunta -->
                    <div class="col-lg-8 col-md-7 form-floating">
                        <input type="text" class="form-control" id="question-2" name="question-2" placeholder="Pregunta" required>
                        <label for="question-2">Pregunta</label>
                        <div class="invalid-feedback">
                            Por favor, introduce una pregunta.
                        </div>
                    </div>
                    <!-- Categorias -->
                    <div class="col-lg-3 col-md-3 form-floating">
                        <select class="form-select" id="category-question-2">
                            <?php for ($i = 0; $i < count($categories); $i++) : ?>
                                <option value="<?= $categories[$i]["idCategory"] ?>" <?= ($i == 0) ? "selected" : '' ?>><?= e($categories[$i]["name"]) ?></option>
                            <?php endfor; ?>
                        </select>
                        <label for="category-question-2">Categoría</label>
                    </div>
                    <!-- Btn añadir respuesta y ver respuestas -->
                    <div class="col-lg-1 col-md-2 d-flex align-items-center justify-content-center">
                        <button class="btn btn-primary m-1" type="button" id="btnAddAnswer-question-2" title="Añadir respuesta">
                            <i class="fa-solid fa-circle-plus"></i>
                        </button>
                        <a class="btn btn-secondary" data-bs-toggle="collapse" href="#collapse-question-2" role="button" aria-expanded="false" aria-controls="collapse-question-2" title="Mostrar respuestas">
                            <i class="fa-solid fa-chevron-down"></i>
                        </a>
                    </div>
                    <!-- Respuestas -->
                    <div class="collapse" id="collapse-question-2">
                        <div class="list_answers">
                            <div>
                                <input type="text" class="form-control" name="answer-question-2" placeholder="respuesta" required>
                                <div class="invalid-feedback">
                                    Por favor, introduce una respuesta.
                                </div>
                            </div>
                            <div>
                                <input type="text" class="form-control" name="answer-question-2" placeholder="respuesta" required>
                                <div class="invalid-feedback">
                                    Por favor, introduce una respuesta.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row gy-3 mb-3">
                    <!-- Pregunta -->
                    <div class="col-lg-8 col-md-7 form-floating">
                        <input type="text" class="form-control" id="question-3" name="question-3" placeholder="Pregunta" required>
                        <label for="question-3">Pregunta</label>
                        <div class="invalid-feedback">
                            Por favor, introduce una pregunta.
                        </div>
                    </div>
                    <!-- Categorias -->
                    <div class="col-lg-3 col-md-3 form-floating">
                        <select class="form-select" id="category-question-3">
                            <?php for ($i = 0; $i < count($categories); $i++) : ?>
                                <option value="<?= $categories[$i]["idCategory"] ?>" <?= ($i == 0) ? "selected" : '' ?>><?= $categories[$i]["name"] ?></option>
                            <?php endfor; ?>
                        </select>
                        <label for="category-question-3">Categoría</label>
                    </div>
                    <!-- Btn añadir respuesta y ver respuestas -->
                    <div class="col-lg-1 col-md-2 d-flex align-items-center justify-content-center">
                        <button class="btn btn-primary m-1" type="button" id="btnAddAnswer-question-3" title="Añadir respuesta">
                            <i class="fa-solid fa-circle-plus"></i>
                        </button>
                        <a class="btn btn-secondary" data-bs-toggle="collapse" href="#collapse-question-3" role="button" aria-expanded="false" aria-controls="collapse-question-3" title="Mostrar respuestas">
                            <i class="fa-solid fa-chevron-down"></i>
                        </a>
                    </div>
                    <!-- Respuestas -->
                    <div class="collapse" id="collapse-question-3">
                        <div class="list_answers">
                            <div>
                                <input type="text" class="form-control" name="answer-question-3" placeholder="respuesta" required>
                                <div class="invalid-feedback">
                                    Por favor, introduce una respuesta.
                                </div>
                            </div>
                            <div>
                                <input type="text" class="form-control" name="answer-question-3" placeholder="respuesta" required>
                                <div class="invalid-feedback">
                                    Por favor, introduce una respuesta.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="text-end">
            <button type="submit" class="btn btn-primary" id="submit-test">
                <?php echo ($idTest != null) ? 'Editar test' : 'Crear Test' ?>
            </button>
        </div>
    </form>
</div>

<?php include __DIR__ . '/views/scripts.php'; ?>
<script type="module" src="assets/js/test-form.js"></script>

</body>

</html>