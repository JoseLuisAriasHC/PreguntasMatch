<?php
require_once __DIR__ . '/models/user.php';
require_once __DIR__ . '/models/test_of_the_day.php';
session_start();

// verificar si hay un usuario logueado
$user = isset($_SESSION['user']) ? $_SESSION['user'] : false;
$test = test_of_the_day::getTest();

// verificar si ha habido algun error en el proceso
$error = null;
if (isset($_SESSION['error'])) {
    $error = $_SESSION['error'];
    unset($_SESSION['error']);
}

include __DIR__ . '/views/head.php';
?>
<!-- Navigation  -->
<?php include __DIR__ . '/views/navigation.php'; ?>

<!-- home page  -->
<div class="contaier" id="home">
    <?php if ($error != null) : ?>
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <strong>Error código manipulado: </strong><?= e($error) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <div class="text-center">
        <h1 class="display-1" id="titulo_main" data-aos="zoom-in" data-aos-duration="1000">Preguntas<span class="text-dark">Match</span></h1>
        <p data-aos="zoom-in" data-aos-duration="1000" data-aos-delay="200">Este es un juego donde vas a veriguar que porcentaje de
            personas estan de acuerdo contigo <br> !Conoce si
            eres común o estas en el 1%¡</p>
        <a class="btn btn-primary rounded mb-3 fs-5" id="btn_jugar" href="test.php?idTest=<?= e($test->idTest) ?>">¡Test del día!</a> <br>
        <a class="btn btn-primary rounded mb-3" href="categories.php">Categorias</a>

    </div>
</div>
<?php include __DIR__ . '/views/scripts.php'; ?>
<script type="module" src="assets/js/login-register.js"></script>

</body>

</html>