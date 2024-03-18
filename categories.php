<?php
require_once __DIR__ . '/models/user.php';
require_once __DIR__ . '/models/category.php';
session_start();

// verificar si hay un usuario logueado
$user = isset($_SESSION['user']) ? $_SESSION['user'] : false;
$categories = Category::list();

include __DIR__ . '/views/head.php';
?>

<!-- Navigation  -->
<?php include __DIR__ . '/views/navigation.php'; ?>

<!-- Category  -->
<div class="container" id="categories">
    <div class="row">
        <?php for ($i = 0; $i < count($categories); $i++) : ?>
            <?php $ejemplos = explode(".", $categories[$i]['description']); ?>
            <div class="col-lg-3 col-md-4 col-sm-6 mb-3 edit-card">
                <a href="category.php?category=<?= e($categories[$i]['idCategory'])?>">
                    <div class="card" data-bs-toggle="popover" data-bs-placement="right" data-bs-custom-class="popover-category" data-bs-trigger="hover focus" data-bs-title="<?= e($categories[$i]['name']) ?>" data-bs-content="<ul class='mb-1'>
                    <?php for ($j = 0; $j < count($ejemplos) - 1; $j++) : ?>
                        <li><?= e($ejemplos[$j]) ?></li>
                    <?php endfor; ?>
                    </ul>
                    <div class='d-flex justify-content-end'>
                        <div class='d-flex justify-content-start'>
                            <div class='me-2'>
                                <i class='fa-regular fa-paste view-icon'></i>
                            </div>
                            <div class='d-flex justify-content-center align-items-center'>
                                <?= e($categories[$i]['num_Tests']) ?> Test
                            </div>
                        </div>
                    </div>">
                        <div class="card-body">
                            <img src="assets/img/categories/<?= e($categories[$i]['name']) ?>.jpg" class="card-img-top" alt="<?= e($categories[$i]['name']) ?>">
                        </div>
                    </div>
                    <div class="card-footer mt-2">
                        <p class="card-text"><?= e($categories[$i]['name']) ?></p>
                    </div>
                </a>
            </div>
        <?php endfor; ?>
    </div>
</div>

<?php include __DIR__ . '/views/scripts.php'; ?>
<script type="module" src="assets/js/login-register.js"></script>
</body>

</html>