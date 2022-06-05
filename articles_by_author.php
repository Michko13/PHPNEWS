<?php
require_once 'components/header.php';
require_once 'autoloader.php';

$authorRepository = new AuthorRepository();
if (empty($_GET['id']) || !$authorRepository->does_author_exist($_GET['id'])) {
    header('Location: authors.php');
    die();
}

$articleRepository = new ArticleRepository();
$articles = $articleRepository->get_articles_by_author($_GET['id']);
$author = $authorRepository->get_author_name($_GET['id']);
?>
<body>
<?php require_once 'components/navbar.php' ?>
<div id="articled-by-author-page" class="page">
    <h1 class="page__title">Články od autora <?= $author['name'] ?> <?= $author['surname'] ?></h1>
    <div id="articles">
        <?php if(!empty($articles)): ?>
            <?php require_once("components/articles.php") ?>
        <?php else: ?>
            <h3>Tento autor ještě nenapsal žádný článek...</h3>
        <?php endif; ?>
    </div>
</div>
</body>