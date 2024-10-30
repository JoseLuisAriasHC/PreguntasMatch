<?php
require_once __DIR__ . '/models/user.php';
require_once __DIR__ . '/models/test.php';
session_start();

$idUser = $_GET['idUser'];
$user = isset($_SESSION['user']) ? $_SESSION['user'] : false;
// verificar si hay un user logueado
if ($user == false) {
    $_SESSION['error'] = 'Tienes que iniciar sesión para poder acceder a este apartado.';
    header('Location: index.php');
    exit();
}
// verificar si el usuario logueado es el mismo que obtenemos del get
if ($user->idUser != $idUser) {
    $_SESSION['error'] = 'No puedes ver la infomarción de otros usuarios.';
    header('Location: index.php');
    exit();
}
// verificar si ha habido algun error en el proceso
$error = null;
if (isset($_SESSION['error'])) {
    $error = $_SESSION['error'];
    unset($_SESSION['error']);
}

$testList = Test::listByUserId($idUser);
?>

<?php include __DIR__ . '/views/head.php'; ?>

<!-- Navigation  -->
<?php include __DIR__ . '/views/navigation.php'; ?>

<!-- Container  -->
<div class="container" id="user">
    <?php if ($error != null) : ?>
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <strong>Error código manipulado: </strong><?= $error ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <div class="row datos">
        <div class="col col-md-2">
            <img src="assets/img/icons/<?= e($user->icon) ?>" alt="user-icon" class="rounded-circle img-fluid">
        </div>
        <div class="col col-md-9">
            <h1><?= e($user->name) ?></h1>
            <p><?= e($user->email) ?></p>
            <div class="mt-3">
                <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#registerModal">Gestionar datos</button>
                <a class="btn btn-info" href="test_form.php">Crear Test</a>
                <a class="btn btn-info" href="ajax/logout.php">Cerrar sesión</a>
            </div>
        </div>

        <!-- Register Modal -->
        <div data-bs-theme="dark">
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
                                        <img src="assets/img/icons/<?= e($user->icon) ?>" alt="Imagen Circular" class="rounded-circle" width="200" height="200" id="originalImage">
                                        <div class="edit-overlay">
                                            <i class="fa-solid fa-pencil" aria-hidden="true"></i>
                                        </div>
                                        <input type="text" class="form-control d-none" id="iconRegister" name="iconRegister" value="<?= e($user->icon) ?>" required>
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
                                                <?php
                                                for ($i = 1; $i <= $numIconsPNG; $i++) {
                                                    echo '<img src="' . $rutaCarpetaIcons . '/icon_N(' . $i . ').png" alt="Icono ' . $i . '" class="icon-gallery-item"> ';
                                                }
                                                ?>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Inputs de user -->
                                <div id="errorDivRegister"></div>
                                <input type="text" name="idUser" id="idUser" value="<?= $idUser ?>" style="display: none;">

                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="nameRegister" name="nameRegister" placeholder="paleyer1" value="<?= e($user->name) ?>" required>
                                    <label for="nameRegister">Nombre</label>
                                    <div class="invalid-feedback">
                                        Por favor, introduce un nombre válido.
                                    </div>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control" id="emailRegister" name="nameRegister" placeholder="name@example.com" value="<?= e($user->email) ?>" required>
                                    <label for="emailRegister">Correo electrónico</label>
                                    <div class="invalid-feedback">
                                        Por favor, introduce un correo electrónico válido.
                                    </div>
                                </div>

                                <div class="form-floating">
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-floating col">
                                                <input type="password" class="form-control" id="pwdRegister" name="nameRegister" placeholder="Contraseña" required>
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

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary" id="btnRegisterSubmit">Guardar datos</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <hr>

    <!-- lista de test -->
    <?php if (!empty($testList)) : ?>
        <div class="owl-carousel owl-theme" id="test-list">
            <?php foreach ($testList as $k => $test) : ?>
                <div href="test.php?idTest=<?= $test->idTest ?>" class="card category-card link-offset-2 link-underline link-underline-opacity-0" data-bs-toggle="popover" data-bs-placement="right" data-bs-custom-class="popover-category" data-bs-trigger="hover focus" data-bs-title="<?= e($test->title) ?>" data-bs-content="<?= e($test->description) ?>">
                    <?php if ($test->image) : ?>
                        <img src="uploads/usuarios/<?= $test->idUser ?>/test/<?= $test->idTest ?>-<?= e($test->image) ?>" alt="<?= e($test->title) ?>">
                    <?php else : ?>
                        <img src="assets/img/no-image.png" alt="<?= e($test->title) ?>">
                    <?php endif; ?>
                    <div class="card-body">
                        <h5 class="card-title mb-0"><?= e($test->title) ?></h5>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-primary edit-btn" title="Editar test" data-bs-toggle="modal" data-bs-target="#updateTestModal" data-id="<?= $test->idTest ?>">
                            <i class="fas fa-edit"></i> Editar
                        </button>
                        <button class="btn btn-danger delete-btn" title="Borrar test" data-bs-toggle="modal" data-bs-target="#deleteTestModal" data-id="<?= $test->idTest ?>">
                            <i class="fas fa-trash-alt"></i> Borrar
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Modals warning  -->
        <div data-bs-theme="dark">
            <!-- Modal update  -->
            <div class="modal fade" id="updateTestModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="updateTestMOdalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="updateTestMOdalLabel">Editar Test</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Si cambias cualquier texto de alguna pregunta o respuesta o eliminas alguna de ellas las respuestas de los usuarios se eliminaran. ¿Esta de acuerdo?</p>
                        </div>
                        <div class="modal-footer">
                            <a id="editModalLink" type="button" class="btn btn-primary" href="#">Editar</a>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal update -->
            <div class="modal fade" id="deleteTestModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteTestModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="deleteTestModalLabel">Borrar test</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>¿Estas seguro que quieres Borrar el test?</p>
                        </div>
                        <div class="modal-footer">
                            <a id="deleteModalLink" type="button" class="btn btn-primary" href="#">Borrar</a>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php endif; ?>
</div>

<?php include __DIR__ . '/views/scripts.php'; ?>
<script src="lib/OwlCarousel2-2.3.4/owl.carousel.min.js"></script>
<script type="module" src="assets/js/login-register.js"></script>
<script type="module" src="assets/js/user.js"></script>
</body>

</html>