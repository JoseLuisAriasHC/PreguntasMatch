<?php
// saber el numero de archivos y para luego iterar sobre ellos
$rutaCarpetaIcons = 'assets/img/icons';
$numIconsPNG = contarArchivosPNG($rutaCarpetaIcons);
?>

<nav class="navbar navbar-expand-sm fixed-top" data-bs-theme="dark" id="navigation">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">
            <img src="assets/img/logo.PNG" alt="Logo" width="150">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item dropdown">
                    <!-- Button trigger login modal -->
                    <?php if (!$user) : ?>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#loginModal">
                            Iniciar sesión
                        </button>
                    <?php else : ?>
                        <button class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="assets/img/icons/<?= e($user->icon) ?>" alt="user-icon" class="user-icon">
                            <?= e($user->name) ?>
                        </button>

                        <ul class="dropdown-menu dropdown-menu-light">
                            <li><a class="dropdown-item" href="user.php?idUser=<?= $user->idUser ?>"><i class="fas fa-user"></i> Perfil</a></li>
                            <li><a class="dropdown-item" href="ajax/logout.php"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</a></li>
                        </ul>
                    <?php endif; ?>
                </li>
            </ul>
        </div>
    </div>

    <?php if (!$user) : ?>
        <!-- Login Modal -->
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

        <!-- Register Modal -->
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

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary" id="btnRegisterSubmit">Crear cuenta</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endif; ?>
</nav>