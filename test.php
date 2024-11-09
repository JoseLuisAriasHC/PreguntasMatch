<?php
require_once __DIR__ . '/models/user.php';
require_once __DIR__ . '/models/question.php';
require_once __DIR__ . '/models/answer.php';
require_once __DIR__ . '/models/user_answers.php';
session_start();

// verificar si hay un idTest en la URL 
$idTest = isset($_GET['idTest']) ? $_GET['idTest'] : false;
if ($idTest == false) {
    $_SESSION['error'] = 'No se ha seleccionado ningun Test para realizar';
    header('Location: index.php');
    exit();
}

// Esto verifica si hay un test que dejo a medias pueda volver donde estaba y si es nuevo resetear el numero de pregunta y sus respuestas
if (isset($_SESSION['test']) && $_SESSION['test']['idTest'] != $idTest) {
    unset($_SESSION['test']);
}

// verificar si ha habido algun error en el proceso
$error = null;
if (isset($_SESSION['error'])) {
    $error = $_SESSION['error'];
    unset($_SESSION['error']);
}

$_SESSION['test']['idTest'] = $idTest;

// verifiacar el numero de la pregunta
$numQuestion = isset($_SESSION['test']['answers']) ? count($_SESSION['test']['answers']) : 0;

// cargar datos
$questionList = Question::list($idTest);
$question = $questionList[$numQuestion];
$answerList = Answer::list($question->idQuestion);

// ver si es la ultima pregunta
$_SESSION['test']['lastQuestion'] = (count($questionList) - 1 == $numQuestion) ? 1 : 0;

$colums = count($answerList) == 2 ? 6 : 4; // el tamaño que ocupara cada respuesta si son dos se divienta entre la mitad la fila
$progressBar = 100 * ($numQuestion + 1) / count($questionList);
?>

<?php include __DIR__ . '/views/head.php'; ?>

<div class="container text-center" id="test" data-id-question="<?= $question->idQuestion ?>" data-message="">
    <?php if ($error != null) : ?>
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <strong>Error código manipulado: </strong><?= e($error) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <div id="progress-container">
        <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="<?= $progressBar ?>" aria-valuemin="0" aria-valuemax="100">
            <div class="progress-bar" style="width: <?= $progressBar ?>%"><?= $numQuestion + 1 ?> / <?= count($questionList) ?></div>
        </div>
    </div>
    <div id="question_answers">
        <!-- Pregunta -->
        <div class="row" id="pregunta" data-aos="zoom-in" data-aos-duration="1250">
            <div class="col mb-4">
                <div class="bg-light p-3 rounded text-question"><?= e($question->text) ?></div>
            </div>
        </div>

        <!-- Respuestas -->
        <div class="row" id="respuestas">
            <?php foreach ($answerList as $k => $answer) : ?>
                <?php $delay = 300 * $k; ?>
                <div class="col-md-<?= $colums ?> mb-3" data-aos="flip-left" data-aos-duration="1000" data-aos-delay="<?= $delay ?>">
                    <div class="bg-light p-3 rounded text-answer" data-id-answer="<?= $answer->idAnswer ?>"><?= e($answer->text) ?></div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="d-flex justify-content-center">
        <div id="loadingScreen" class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
</div>

<?php include __DIR__ . '/views/scripts.php'; ?>
<script type="module" src="assets/js/test.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</body>

</html>