<?php
require_once 'components/header.php';
require_once 'autoloader.php';

$categoryRepository = new CategoryRepository();
if (empty($_GET['id']) || !$categoryRepository->does_category_exist($_GET['id'])) {
    header('Location: categories.php');
    die();
}

$articleRepository = new ArticleRepository();
$articles = $articleRepository->get_articles_by_category($_GET['id']);
$categoryName = $categoryRepository->get_category_name($_GET['id']);
?>
<body>
<?php require_once 'components/navbar.php' ?>
<div id="articled-by-category-page" class="page">
    <h1 class="page__title"><?= $categoryName ?></h1>
    <div id="articles">
        <?php if(!empty($articles)): ?>
            <?php require_once("components/articles.php") ?>
        <?php else: ?>
            <h3>V této kategorii ještě nejsou žádné články...</h3>
        <?php endif; ?>
    </div>
</div>
</body>
