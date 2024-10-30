<?php
require_once __DIR__ . '/models/user.php';
require_once __DIR__ . '/models/test.php';
require_once __DIR__ . '/models/category.php';
require_once __DIR__ . '/models/question.php';
session_start();

// verificar si hay un usuario logueado
$user = isset($_SESSION['user']) ? $_SESSION['user'] : false;

$category = isset($_GET['category']) ? $_GET['category'] : $_POST['category'];
$title = isset($_POST['title']) ? $_POST['title'] : '';
$order = isset($_POST['order']) ? $_POST['order'] : '';

$listTest = Test::list($category, $title, $order);
?>
<?php include __DIR__ . '/views/head.php'; ?>

<!-- Navigation  -->
<?php include __DIR__ . '/views/navigation.php'; ?>

<!-- Category  -->
<div class="container" id="category">
    <form method="post" action="category.php" id="search" class="row">
        <input type="hidden" name="category" value="<?= e($category) ?>">
        <div class="col-md-8 col-sm-6 my-2">
            <div class="input-group ">
                <input type="text" name="title" class="form-control" placeholder="Título del test" value="<?= e($title) ?>">
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>
        </div>

        <div class="col-md-2 col-sm-3 my-2">
            <select class="form-select" name="order" onchange="this.form.submit()">>
                <option class="dropdown-item" value="date-desc" <?php echo $order == 'date-desc' ? 'selected' : ''; ?> >Subidos recientes</option>
                <option class="dropdown-item" value="date-asc" <?php echo $order == 'date-asc' ? 'selected' : ''; ?>>Más antiguos</option>
                <option class="dropdown-item" value="title-asc" <?php echo $order == 'title-asc' ? 'selected' : ''; ?>>Título A-Z</option>
                <option class="dropdown-item" value="title-desc" <?php echo $order == 'title-desc' ? 'selected' : ''; ?>>Título Z-A</option>
            </select>
        </div>

        <div class="col-md-2 col-sm-3 my-2">
            <?php if ($user != false) : ?>
                <a class="btn btn-primary w-100" href="test_form.php">
                    <i class="fa-solid fa-circle-plus"></i> Crear Test
                </a>
            <?php else : ?>
                <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#loginModal">
                    <i class="fa-solid fa-circle-plus"></i> Crear Test
                </button>
            <?php endif; ?>
        </div>
    </form>

    <div class="py-4 row gx-4 row-cols-xl-5 row-cols-md-3 row-cols-sm-2 g-3" id="test-list">
        <?php foreach ($listTest as $k => $test) : ?>
            <?php
            $categoriesList = Question::listCategories($test->idTest);
            $popoverContent = "<ul class='list-group mb-2'>";
            foreach ($categoriesList as $key => $categoryName) {
                $popoverContent .= "<li class='list-group-item d-flex justify-content-between align-items-center'>" . $categoryName['name'] . "<span class='badge text-bg-primary rounded-pill'>" . $categoryName['num_questions'] . "</span></li>";
            }
            $popoverContent .= '</ul>';
            $popoverContent .= $test->description;
            ?>
            <div class="col">
                <a href="test.php?idTest=<?= e($test->idTest) ?>" class="card category-card link-offset-2 link-underline link-underline-opacity-0" data-bs-toggle="popover" data-bs-placement="right" data-bs-custom-class="popover-category" data-bs-trigger="hover focus" data-bs-title="<?= $test->title ?>" data-bs-content="<?= $popoverContent ?>">

                    <?php if ($test->image) : ?>
                        <img src="uploads/usuarios/<?= e($test->idUser) ?>/test/<?= e($test->idTest) ?>-<?= e($test->image) ?>" alt="<?= e($test->title) ?>">
                    <?php else : ?>
                        <img src="assets/img/no-image.png" alt="<?= e($test->title) ?>">
                    <?php endif; ?>
                    <div class="card-body">
                        <h5 class="card-title mb-0"><?= e($test->title) ?></h5>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include __DIR__ . '/views/scripts.php'; ?>
<script type="module" src="assets/js/login-register.js"></script>
</body>
</html>