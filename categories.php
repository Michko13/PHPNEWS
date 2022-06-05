<?php
require_once 'components/header.php';
require_once 'autoloader.php';

$categoryRepository = new CategoryRepository();
$categories = $categoryRepository->get_all_categories();
?>
<body>
<?php require_once 'components/navbar.php' ?>
<div id="categories-page" class="page">
    <h1 class="page__title">Kategorie</h1>
    <div id="categories">
        <?php foreach ($categories as $category): ?>
            <a class="category" href="articles_by_category.php?id=<?= $category['id'] ?>">
                <h3 class="category__name"><?= $category['name'] ?></h3>
                <div class="category__description"><?= $category['description'] ?></div>
            </a>
        <?php endforeach; ?>
    </div>
</div>
</body>